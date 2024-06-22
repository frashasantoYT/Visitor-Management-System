<?php
include_once '../config/database.php';
include_once '../src/Auth.php';
include_once '../src/VisitorController.php';

if (!isGuard() && !isAdmin()) {
    header("Location: login.php");
    exit();
}

$visitorController = new VisitorController($conn);
$visitors = $visitorController->getAllVisitors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Visitors</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha384-VhM4v7p+Tlk1Lz2F0wCh9XhDOD7IeYl0AMzK+Ej9s5wMEY/Jy/mfR35Pe8oBlpUG" crossorigin="anonymous">
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .search-bar {
            max-width: 400px;
            margin: 0 auto 20px auto;
        }
        .search-bar .form-control {
            border-radius: 20px;
            padding: 10px 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">All Visitors</h1>
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Name or Email">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Visit Date</th>
                        <th>Purpose</th>
                        <th>Visit Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="visitorTable">
                    <?php foreach ($visitors as $visitor): ?>
                    <tr>
                        <td><?php echo $visitor['id']; ?></td>
                        <td><?php echo $visitor['name']; ?></td>
                        <td><?php echo $visitor['email']; ?></td>
                        <td><?php echo $visitor['phone']; ?></td>
                        <td><?php echo $visitor['visit_date']; ?></td>
                        <td><?php echo $visitor['purpose']; ?></td>
                        <td><?php echo $visitor['created_at']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm btn-edit" onclick="openEditModal(<?php echo $visitor['id']; ?>)">Edit</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Visitor Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Visitor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="visitor_id" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="visit_date" class="form-label">Visit Date:</label>
                            <input type="date" class="form-control" id="visit_date" name="visit_date">
                        </div>
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Purpose:</label>
                            <input type="text" class="form-control" id="purpose" name="purpose">
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks:</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-B4n0ajwQ76P/bGG1piHR7QNY4DZsVROrAdCp7dhl3vM3ln1x5aJGh7x5UeR06Ph9" crossorigin="anonymous"></script>
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

        $(document).ready(function () {
          
            $('#searchInput').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#visitorTable tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function openEditModal(visitorId) {
            // Fetch visitor details from the server using AJAX
            $.ajax({
                url: 'get_visitor_details.php',
                type: 'GET',
                data: { id: visitorId },
                success: function (response) {
                    // Populate the modal form fields with retrieved data
                    var visitor = JSON.parse(response);
                    $('#visitor_id').val(visitor.id);
                    $('#name').val(visitor.name);
                    $('#email').val(visitor.email);
                    $('#phone').val(visitor.phone);
                    $('#visit_date').val(visitor.visit_date);
                    $('#purpose').val(visitor.purpose);
                    $('#remarks').val(visitor.remarks);
                    // Show the modal
                    $('#editModal').modal('show');
                },
                error: function (xhr, status, error) {
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
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
                $('#editModal').modal('hide');
                loadContent('view_visitors.php'); 
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred. Please try again.');
        }
    });
}


        function showAlert(type, message) {
            
            $('.alert').remove();
          
            var alert = $('<div>').addClass('alert alert-' + type).text(message);
        
            $('body').append(alert);
           
            setTimeout(function () {
                alert.fadeOut(500, function () {
                    $(this).remove();
                });
            }, 5000);
        }
    </script>
</body>
</html>
