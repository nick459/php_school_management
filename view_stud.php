<?php
// Database Connection
$conn = new mysqli('localhost', 'root', '', 'db_elgibor_management');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Handle Student Update
if (isset($_POST['edit_student'])) {
    $adm_no = $_POST['adm_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $class_id = $_POST['class_id'];
    $year = $_POST['year'];

    $update_sql = "UPDATE students SET first_name='$first_name', last_name='$last_name', gender='$gender', email='$email', class_id='$class_id', year='$year' WHERE adm_no='$adm_no'";

    if ($conn->query($update_sql)) {
        echo "<script>alert('Student details updated successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Handle Filters
$year_filter = isset($_GET['year']) ? $_GET['year'] : '';
$class_filter = isset($_GET['class_id']) ? $_GET['class_id'] : '';

// Build SQL Query with Filters
$students_sql = "SELECT * FROM students WHERE 1=1";
if (!empty($year_filter)) {
    $students_sql .= " AND year = '$year_filter'";
}
if (!empty($class_filter)) {
    $students_sql .= " AND class_id = '$class_filter'";
}

$students = $conn->query($students_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .navbar-text {
            color: white !important;
        }
        .logout-btn {
            margin-left: auto;
        }
        .filter-form {
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
    <!-- Navbar with Logout Button -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Main Student Dashboard</a>
            <div class="logout-btn">
                <a href="count.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Filter Form -->
        <div class="filter-form">
            <h3>Filter Students:</h3>
            <form method="GET" action="" class="row g-3">
                <div class="col-md-4">
                    <label for="year" class="form-label">Year:</label>
                    <input type="text" name="year" id="year" class="form-control" value="<?php echo htmlspecialchars($year_filter); ?>" placeholder="Enter year">
                </div>
                <div class="col-md-4">
                    <label for="class_id" class="form-label">Class ID:</label>
                    <input type="text" name="class_id" id="class_id" class="form-control" value="<?php echo htmlspecialchars($class_filter); ?>" placeholder="Enter class ID">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Apply Filter</button>
                    <a href="?" class="btn btn-secondary">Clear Filters</a>
                </div>
            </form>
        </div>

        <!-- Display Students List -->
        <div class="table-responsive">
            <h3>Student List:</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Admission No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Class ID</th>
                        <th>Year</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($students->num_rows > 0) {
                        while ($row = $students->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['adm_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['class_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No students found</td></tr>";
                    }
                    ?>
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
$conn->close();  // Closing the connection after everything is done
?>