<?php
include_once '../config/database.php';
include_once '../src/Auth.php';
include_once '../src/VisitorController.php';
include_once '../src/UserController.php';

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

$visitorController = new VisitorController($conn);
$userController = new UserController($conn);

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$last7Days = date('Y-m-d', strtotime('-7 days'));

$todayVisitors = $visitorController->getVisitorsByDateRange($today, $today);
$yesterdayVisitors = $visitorController->getVisitorsByDateRange($yesterday, $yesterday);
$last7DaysVisitors = $visitorController->getVisitorsByDateRange($last7Days, $today);

$totalGuards = $userController->getTotalGuards();
$totalVisitors = $visitorController->getTotalVisitors(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            flex: 0 0 250px;
            background-color: #343a40;
            color: white;
            padding: 15px;
        }
        .sidebar h2 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .dropdown-menu {
            background-color: #343a40;
            color: white;
            border: none;
        }
        .dropdown-menu .dropdown-item {
            color: white;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #495057;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-weight: bold;
        }
        .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }
        .card-title {
            font-size: 2em;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
        <a href="admin_dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#" onclick="loadContent('add_visitor.php')"><i class="fas fa-user-plus"></i> Add Visitor</a>
        <a href="#" onclick="loadContent('view_visitors.php')"><i class="fas fa-users"></i> View Visitors</a>
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" id="manageGuardsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-shield"></i>User Management</a>
            <ul class="dropdown-menu" aria-labelledby="manageGuardsDropdown">
                <li><a class="dropdown-item" href="#" onclick="loadContent('manage_users.php')"><i class="fas fa-shield-alt"></i>Manage Users</a></li>
                <li><a class="dropdown-item" href="#" onclick="loadContent('add_user.php')"><i class="fas fa-user-plus"></i> Add User</a></li>
                <!--<li><a class="dropdown-item" href="#" onclick="loadContent('permissions.php')"><i class="fas fa-user-cog"></i> Permissions</a></li>-->
            </ul>
        </div>
        <a href="#" onclick="loadContent('reports.php')"><i class="fas fa-users"></i>Generate</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="main-content" id="dynamic-content">
        <div class="container-fluid">
            <h1>Welcome, <?php echo $_SESSION['user']['username']; ?></h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-header">Today's Visitors</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo count($todayVisitors); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-header">Yesterday's Visitors</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo count($yesterdayVisitors); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-header">Last 7 Days Visitors</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo count($last7DaysVisitors); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-header">Total Visitors</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $totalVisitors; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadContent(url) {
            $.ajax({
                url: url,
                success: function(data) {
                    $('#dynamic-content').html(data);
                    updateSidebarActive(url);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function updateSidebarActive(url) {
            $('.sidebar a').removeClass('active');
            $('.sidebar a[href*="' + url + '"]').addClass('active');
        }

        function openEditModal(visitorId) {
            $.ajax({
                url: 'get_visitor_details.php',
                type: 'GET',
                data: { id: visitorId },
                success: function(response) {
                    var visitor = JSON.parse(response);
                    $('#name').val(visitor.name);
                    $('#email').val(visitor.email);
                    $('#phone').val(visitor.phone);
                    $('#visit_date').val(visitor.visit_date);
                    $('#purpose').val(visitor.purpose);
                    $('#remarks').val(visitor.remarks);
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function saveChanges() {
            var formData = $('#editForm').serialize();
            $.ajax({
                url: 'save_visitor_changes.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#editModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            $('.sidebar a').on('click', function() {
                $('.sidebar a').removeClass('active');
                $(this).addClass('active');
            });

            $(document).on('click', '[data-bs-toggle="dropdown"]', function(event) {
                event.stopPropagation();
                var dropdown = new bootstrap.Dropdown(this);
                dropdown.toggle();
            });

            $(document).on('click', '.btn-edit', function() {
                var visitorId = $(this).data('visitor-id');
                openEditModal(visitorId);
            });
        });
    </script>
</body>
</html>
