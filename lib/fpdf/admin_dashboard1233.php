<?php
include_once '../config/database.php';
include_once '../src/Auth.php';
include_once '../src/VisitorController.php';
include_once '../src/UserController.php';

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            margin-bottom: 20px;
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
                <li><a class="dropdown-item" href="#" onclick="loadContent('permissions.php')"><i class="fas fa-user-cog"></i> Permissions</a></li>
            </ul>
        </div>
        <a href="#" onclick="loadContent('reports.php')"><i class="fas fa-users"></i>Generate</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="main-content">
        <div class="container-fluid">
            <h1>Welcome, <?php echo $_SESSION['user']['username']; ?></h1>
            <div class="row">
                <div class="col-md-12">
                    <canvas id="visitorChart"></canvas>
                </div>
                <div class="col-md-12">
                    <h3>Live Activity Feed</h3>
                    <div id="activityFeed" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function fetchData() {
            const response = await fetch('fetch_dashboard_data.php');
            const data = await response.json();

            // Update chart
            const ctx = document.getElementById('visitorChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Visitors',
                        data: data.visitors,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Update activity feed
            const feed = document.getElementById('activityFeed');
            feed.innerHTML = '';
            if (data.activity.length === 0) {
                feed.innerHTML = '<p>No recent activity.</p>';
            } else {
                data.activity.forEach(activity => {
                    const entry = document.createElement('div');
                    entry.innerText = `${activity.time} - ${activity.message}`;
                    feed.appendChild(entry);
                });
            }
        }

        // Initial data fetch
        fetchData();

       
        setInterval(fetchData, 60000); // Every minute
    </script>
</body>
</html>
