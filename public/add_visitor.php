<?php
include_once '../config/database.php';
include_once '../src/VisitorController.php';
include_once '../src/Auth.php';

$nameErr = $emailErr = $phoneErr = $visitDateErr = $purposeErr = '';
$successMessage = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $visit_date = $_POST['visit_date'];
    $purpose = $_POST['purpose'];
    $remarks = $_POST['remarks'];

    if (empty($name)) {
        $nameErr = 'Name is required';
    }
    if (empty($email)) {
        $emailErr = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Invalid email format';
    }
    if (empty($phone)) {
        $phoneErr = 'Phone number is required';
    }
    if (empty($visit_date)) {
        $visitDateErr = 'Visit date is required';
    }
    if (empty($purpose)) {
        $purposeErr = 'Purpose is required';
    }
    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($visitDateErr) && empty($purposeErr)) {
        $visitorController = new VisitorController($conn);
        $visitorController->addVisitor($name, $email, $phone, $visit_date, $purpose, $remarks);
        $successMessage = 'Visitor added successfully!';
        
        // Determine the destination dashboard based on user role
        $dashboardLocation = ($userRole === 'admin') ? 'admin_dashboard.php' : 'guard_dashboard.php';
        
        header("Location: $dashboardLocation");
    }
    


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Visitor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        textarea {
            resize: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Visitor</h1>
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <form action="add_visitor.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <span class="text-danger"><?php echo $nameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <span class="text-danger"><?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
                <span class="text-danger"><?php echo $phoneErr; ?></span>
            </div>
            <div class="form-group">
                <label for="visit_date">Visit Date:</label>
                <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                <span class="text-danger"><?php echo $visitDateErr; ?></span>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose:</label>
                <input type="text" class="form-control" id="purpose" name="purpose" required>
                <span class="text-danger"><?php echo $purposeErr; ?></span>
            </div>
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Visitor</button>
        </form>
    </div>
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

    </script>
</body>
</html>
