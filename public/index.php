<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visitor Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .nav-link {
            color: #333 !important;
            font-weight: bold;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #007bff !important;
        }
        .card {
            max-width: 600px; /* Increased width */
            margin: 50px auto;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 30px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .about-section {
            background-color: #fff;
            padding: 50px 0;
            text-align: center;
        }
        .about-section h2 {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .about-section p {
            font-size: 1.2rem;
            color: #555;
            max-width: 600px;
            margin: 0 auto;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="./index.php">Visitor Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../templates/contact_information.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Visitor Management System</h1>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'Invalid credentials') { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Invalid credentials. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } else if (isset($_GET['success']) && $_GET['success'] === 'login') { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Login successful.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <p class="card-text text-center">Welcome to the Visitor Management System. Please log in to continue.</p>
                <form id="loginForm" action="login.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    <section id="about" class="about-section">
        <div class="container">
            <h2>About Us</h2>
            <p class="lead">The Visitor Management System is designed to streamline and manage the process of tracking visitors in an organization. It helps ensure security and provides a professional and efficient way of handling visitor information.</p>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pQdzXwQp5xI26+UE6J36TVs5id55F2yP8kzbi6lQj8U20jQrr5xxyJ6hg4vG53yp" crossorigin="anonymous"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            if (username.trim() === '' || password.trim() === '') {
                alert('Please fill in all fields.');
                event.preventDefault();
            }
        });
    document.querySelectorAll('.alert .btn-close').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('.alert').remove();
        });
    });
    </script>
</body>
</html>

