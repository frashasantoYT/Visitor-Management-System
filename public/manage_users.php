<?php
include_once '../config/database.php';
include_once '../src/UserController.php';
include_once '../src/Auth.php';


if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

$userController = new UserController($conn);

$users = $userController->getAllUsers();

// Function to display user status
function getUserStatus($is_active) {
    return $is_active ? 'Active' : 'Inactive';
}

// Function to get action buttons based on user status
function getActionButtons($user) {
    $actionButtons = '';
    if ($user['is_active']) {
        $actionButtons .= '<button class="btn btn-warning btn-sm me-1" onclick="updateUserStatus(' . $user['id'] . ', 0)"><i class="fas fa-user-slash"></i> Deactivate</button>';
    } else {
        $actionButtons .= '<button class="btn btn-success btn-sm me-1" onclick="updateUserStatus(' . $user['id'] . ', 1)"><i class="fas fa-user-check"></i> Activate</button>';
    }
    $actionButtons .= '<button class="btn btn-danger btn-sm" onclick="deleteUser(' . $user['id'] . ')"><i class="fas fa-trash-alt"></i> Delete</button>';
    return $actionButtons;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: auto;
        }
        .table thead {
            background-color: #343a40;
            color: #fff;
        }
        .table td, .table th {
            padding: 15px;
            vertical-align: middle;
        }
        .btn {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="table-container">
            <h1 class="mb-4">Manage Users</h1>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo ucfirst($user['role']); ?></td>
                                <td><?php echo getUserStatus($user['is_active']); ?></td>
                                <td>
                                    <?php echo getActionButtons($user); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
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

        function updateUserStatus(id, is_active) {
            if (confirm('Are you sure you want to change the status of this user?')) {
                $.ajax({
                    url: 'update_user_status.php',
                    type: 'POST',
                    data: {
                        id: id,
                        status: is_active
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'delete_user.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function updateSidebarActive(url) {
            $('.sidebar a').removeClass('active');
            $('.sidebar a[href*="' + url + '"]').addClass('active');
        }

        $(document).ready(function() {
            
            updateSidebarActive(window.location.pathname.split('/').pop());

            $(document).on('click', '.sidebar a', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                loadContent(url);
            });
        });
    </script>
</body>
</html>
