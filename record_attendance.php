<?php
$servername = "localhost";
$username = "abdellah";
$password = "Woed@8485";
$dbname = "getion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all class names for the dropdown
    $stmt = $conn->query("SELECT class_name FROM class");
    $class_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle form submission for recording attendance
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_attendance'])) {
        $student_registration_number = $_POST['student_registration_number'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $class = $_POST['class'];

        $sql = "INSERT INTO attendance (student_registration_number, date, status, class) VALUES (:student_registration_number, :date, :status, :class)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_registration_number', $student_registration_number);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':class', $class);

        if ($stmt->execute()) {
            echo "<script>alert('Attendance recorded successfully'); window.location.href='record_attendance.php';</script>";
        } else {
            echo "<script>alert('Error: Stagiaire introuvable'); window.location.href='record_attendance.php';</script>";
        }
    }

    // Handle form submission for displaying absences
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['display_absences'])) {
        $date = $_POST['date'];
        $class = $_POST['class'];

        $sql = "SELECT * FROM attendance WHERE date = :date AND class = :class";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':class', $class);
        $stmt->execute();
        $absences = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Add column 'class' to 'attendance' table if not exists
    $sql = "SHOW COLUMNS FROM attendance LIKE 'class'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $columnExists = $stmt->fetch();

    if (!$columnExists) {
        $sql = "ALTER TABLE attendance ADD COLUMN class VARCHAR(255) NOT NULL";
        $conn->exec($sql);
    }
} catch(PDOException $e) {
    echo "<script>alert('Error: Stagiaire introuvable'); window.location.href='record_attendance.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Student Attendance Management</title>
    <style>
       body {
    background-color: #fff; /* White background */
    color: #00f; /* Blue text */
}
.container {
    margin-top: 50px;
}
h1, h2 {
    color: #00f; /* Blue headings */
}
.btn-primary {
    background-color: #00f; /* Blue button */
    border: none;
}
.form-control {
    border: 1px solid #00f; /* Blue border */
    background-color: #fff; /* White background */
    color: #00f; /* Blue text */
}
.form-control:focus {
    box-shadow: 0 0 5px #00f;
    border-color: #00f;
}
.form-group label {
    color: #00f; /* Blue labels */
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center" style="color:black;">Student Attendance Management</h1>

        <!-- Record Attendance Form -->
        <form class="mt-5" method="post" action="record_attendance.php">
            <h2>Record Attendance</h2>
            <div class="form-group">
                <label for="student_registration_number">Student Registration Number:</label>
                <input type="text" class="form-control" id="student_registration_number" name="student_registration_number" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
            <div class="form-group">
                <label for="class">Class:</label>
                <select class="form-control" id="class" name="class">
                    <?php
                    foreach ($class_names as $class) {
                        echo '<option value="' . htmlspecialchars($class['class_name']) . '">' . htmlspecialchars($class['class_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="record_attendance">Record Attendance</button>
        </form>

        

       
    </div>
</body>
</html>
