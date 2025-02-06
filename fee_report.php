<?php
// Database Connection
session_start();
$conn = new mysqli('localhost', 'root', '', 'db_elgibor_management');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// STUDENT DASHBOARD
if (isset($_SESSION['adm_no'])) {
    $adm_no = $_SESSION['adm_no'];

    // Fetch Student Details
    $student_result = $conn->query("SELECT * FROM students WHERE adm_no = '$adm_no'");
    $student = $student_result->fetch_assoc();

    if ($student):
        // Fetch Fee Details
        $fee_query = $conn->query("SELECT * FROM school_fees WHERE student_id = '$adm_no'");
        $fee = $fee_query->fetch_assoc();

        // Fetch Payment History
        $payment_query = "SELECT * FROM payments WHERE student_id = '$adm_no'";
        if (isset($_POST['filter_payments'])) {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            if (!empty($start_date) && !empty($end_date)) {
                $payment_query .= " AND payment_date BETWEEN '$start_date' AND '$end_date'";
            }
        }
        $payment_result = $conn->query($payment_query);

        // Calculate Total Paid and Balance
        $total_paid = 0;
        while ($payment = $payment_result->fetch_assoc()) {
            $total_paid += $payment['amount_paid'];
        }
        $fee_balance = $fee ? ($fee['total_amount'] - $total_paid) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Fee Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            position: relative;
        }
        .header h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .logout-btn a {
            text-decoration: none;
            color: white;
            background-color: #dc3545;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .logout-btn a:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .table-responsive {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Header with Logout Button -->
    <div class="header">
        <h2>
            ELGIBOR | SABOTI | ACADEMY | SCHOOL<br>
            <span>Student Fee Portal</span>
        </h2>
        <div class="logout-btn">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <!-- Welcome Message -->
        <div class="alert alert-info">
            <h2>Welcome, <?php echo $student['first_name'] . ' ' . $student['last_name']; ?></h2>
            <p>Admission Number: <?php echo $student['adm_no']; ?></p>
        </div>

        <!-- Fee Details -->
        <?php if ($fee): ?>
            <div class="alert alert-warning">
                <h4>Total Fee: KES <?php echo number_format($fee['total_amount'], 2); ?></h4>
                <h4>Due Date: <?php echo $fee['due_date']; ?></h4>
                <h4>Fee Balance: KES <?php echo number_format($fee_balance, 2); ?></h4>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">No fee record found.</div>
        <?php endif; ?>

        <!-- Payment History Filter -->
        <div class="form-container">
            <h3>Payment History</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
                <button type="submit" name="filter_payments" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Payment History Table -->
        <div class="table-responsive">
            <h3>Payment History</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Amount Paid</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $payment_result = $conn->query($payment_query);
                    while ($payment = $payment_result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $payment['payment_date']; ?></td>
                            <td>KES <?php echo number_format($payment['amount_paid'], 2); ?></td>
                            <td><?php echo $payment['payment_method']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    endif;
} else {
    echo "<div class='alert alert-warning'>Please log in to access the portal.</div>";
}
$conn->close();
?>