<?php
// Database Connection
$conn = new mysqli('localhost', 'root', '', 'db_elgibor_management');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Fetch all teachers from the database
$teachers = [];
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Store all teacher records in an array
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
} else {
    echo "No teachers found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: greenyellow;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .btn-logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .form-control {
            border-radius: 5px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Logout Button -->
    <a href="teacher_dash.php" class="btn btn-danger btn-logout">Logout</a>

    <div class="container">
        <h2 class="text-center">ELGIBOR SABOTI ACADEMY<BR>Teaching Staff</h2>
        
        <!-- Table to Display Teachers List -->
        <?php if (!empty($teachers)): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($teacher['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($teacher['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No teachers available to display.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>