<?php
$servername = "localhost";
$username = "abdellah";
$password = "Woed@8485";
$dbname = "getion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve class names
    $stmt = $conn->query("SELECT class_name FROM class");
    $class_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
} catch (PDOException $e) {
    echo "";
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
    font-family: Arial, sans-serif; /* Use Arial font */
    background-color: #f8f9fa; /* Light gray background */
    color: #333; /* Dark gray text */
}

.container {
    margin-top: 50px;
    padding: 20px;
    border-radius: 5px;
    background-color: #fff; /* White background */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
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
h1 {
    color: #333; /* Dark gray headings */
}
h2 {
    color: #00f;}

.btn-primary {
    background-color: #007bff; /* Blue button */
    border: none;
}

.btn-danger {
    background-color: #dc3545; /* Red button */
    border: none;
}



    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Student Attendance Management</h1>

        <!-- Display Absences Form -->
        <form class="mt-5" method="post" action="display.php">
            <h2>Display Absences</h2>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" >
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
            <button type="submit" class="btn btn-primary" name="display_absences">Display Absences</button>
            <button type="submit" class="btn btn-danger" name="clear_attendance">Clear Attendance</button>
        </form>

        <!-- Display Absences Table -->
        <?php
        if (isset($absences)) {
            echo "<br><h2>Results </h2>";
            echo "<table class='table table-bordered'>
                <tr>
                    <th>Numero d'inscreption</th>
                    <th>nom</th>

                    <th>Date</th>
                    <th>Status</th>
                </tr>";
            foreach ($absences as $absence) {
                $stg = $conn->prepare("SELECT * FROM `stagiaire` WHERE num_ins = :num_ins ");
                $stg->bindParam(':num_ins', $absence['student_registration_number']);
                $stg->execute();
                $stagiaire = $stg->fetch(PDO::FETCH_ASSOC);

                if ($stagiaire) {
                    $student_name = $stagiaire['nom_stg'].' '. $stagiaire['prenom_stg'];
                    echo "<tr>                        
                        <td>".$absence['student_registration_number']."</td>
                        <td>".$student_name."</td>
                        <td>".$absence['date']."</td>
                        <td>".$absence['status']."</td>
                    </tr>";
                }
            }
            echo "</table>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear_attendance'])) {
            $sql = "TRUNCATE TABLE attendance"; // Clear all records from the table
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            echo "<script>alert('Attendance records cleared successfully'); window.location.href='display.php';</script>";
        }
        ?>

    </div>
</body>
</html>
