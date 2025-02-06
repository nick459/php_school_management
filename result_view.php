<?php
// Database Connection
session_start();
$conn = new mysqli('localhost', 'root', '', 'db_elgibor_management');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

    // Filters
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
    $term = isset($_GET['term']) ? $_GET['term'] : 1;

    echo "<h2>Class Results for Year: $year, Term: $term</h2>";

    // Year and Term Filter Form
    echo "<form method='GET'>
            <label>Year:</label>
            <input type='number' name='year' value='$year' required>
            <label>Term:</label>
            <select name='term'>
                <option value='1' " . ($term == 1 ? 'selected' : '') . ">Term 1</option>
                <option value='2' " . ($term == 2 ? 'selected' : '') . ">Term 2</option>
                <option value='3' " . ($term == 3 ? 'selected' : '') . ">Term 3</option>
            </select>
            <button type='submit'>Filter</button>
          </form>";

    $subjects = ['english', 'kiswahili', 'maths', 'home_science', 'cre'];

    $classes_result = $conn->query("SELECT * FROM classes WHERE teacher_id = '$teacher_id'");
    while ($class = $classes_result->fetch_assoc()) {
        echo "<h3>Class: {$class['class_name']}</h3>";

        $students_result = $conn->query("SELECT * FROM students WHERE class_id = '{$class['class_id']}'");
        $students = [];
        while ($student = $students_result->fetch_assoc()) {
            $students[] = $student;
        }

        echo "<table border='1'>
                <tr><th>Subject</th>";
        foreach ($students as $student) {
            echo "<th>{$student['first_name']} {$student['last_name']}</th>";
        }
        echo "</tr>";

        foreach ($subjects as $subject) {
            echo "<tr><td>$subject</td>";
            foreach ($students as $student) {
                $result_query = "SELECT $subject FROM results WHERE adm_no = '{$student['adm_no']}' AND year = '$year' AND term = '$term'";
                $result = $conn->query($result_query);
                $marks = ($result->num_rows > 0) ? $result->fetch_assoc()[$subject] : '-';

                echo "<td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='adm_no' value='{$student['adm_no']}'>
                            <input type='hidden' name='subject' value='$subject'>
                            <input type='hidden' name='year' value='$year'>
                            <input type='hidden' name='term' value='$term'>
                            <input type='number' name='marks' value='$marks' min='0' max='100' style='width:50px;'>
                            <button type='submit' name='update_result'>Update</button>
                        </form>
                      </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Handle Result Update
if (isset($_POST['update_result'])) {
    $adm_no = $_POST['adm_no'];
    $subject = $_POST['subject'];
    $year = $_POST['year'];
    $term = $_POST['term'];
    $marks = $_POST['marks'];

    $check_result = $conn->query("SELECT * FROM results WHERE adm_no = '$adm_no' AND year = '$year' AND term = '$term'");
    if ($check_result->num_rows > 0) {
        $conn->query("UPDATE results SET $subject = '$marks' WHERE adm_no = '$adm_no' AND year = '$year' AND term = '$term'");
    } else {
        $conn->query("INSERT INTO results (adm_no, year, term, $subject) VALUES ('$adm_no', '$year', '$term', '$marks')");
    }
    echo "<p>Result updated successfully!</p>";
}

$conn->close();
?>
