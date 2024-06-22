<?php
include_once '../config/database.php';
include_once '../src/Auth.php';
include_once '../src/VisitorController.php';
require '../lib/fpdf/fpdf.php';  // Include FPDF library

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

$visitorController = new VisitorController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dateRange = $_POST['date_range'];
    $startDate = '';
    $endDate = date('Y-m-d'); 

    switch ($dateRange) {
        case '1_month':
            $startDate = date('Y-m-d', strtotime('-1 month'));
            break;
        case '3_months':
            $startDate = date('Y-m-d', strtotime('-3 months'));
            break;
        case '1_year':
            $startDate = date('Y-m-d', strtotime('-1 year'));
            break;
        default:
            $startDate = date('Y-m-d', strtotime('-1 month'));
    }

    $visitors = $visitorController->getVisitorsByDateRange($startDate, $endDate);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Visitor Report');
    $pdf->Ln(20);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Name', 1);
    $pdf->Cell(45, 10, 'Email', 1);
    $pdf->Cell(30, 10, 'Phone', 1);
    $pdf->Cell(30, 10, 'Visit Date', 1);
    $pdf->Cell(60, 10, 'Purpose', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    foreach ($visitors as $visitor) {
        $pdf->Cell(30, 10, $visitor['name'], 1);
        $pdf->Cell(45, 10, $visitor['email'], 1);
        $pdf->Cell(30, 10, $visitor['phone'], 1);
        $pdf->Cell(30, 10, $visitor['visit_date'], 1);
        $pdf->Cell(60, 10, $visitor['purpose'], 1);
        $pdf->Ln();
    }

    $pdf->Output();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Generate Visitor Reports</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            flex: 0 0 250px;
            background-color: #343a40;
            color: white;
            padding: 15px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container-fluid">
            <h1>Generate Visitor Reports</h1>
            <form action="reports.php" method="post">
                <div class="form-group">
                    <label for="date_range">Select Date Range:</label>
                    <select id="date_range" name="date_range" class="form-control" required>
                        <option value="1_month">Last 1 Month</option>
                        <option value="3_months">Last 3 Months</option>
                        <option value="1_year">Last 1 Year</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
        </div>
    </div>
</body>
</html>
