<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "Woed@8485";
    $dbname = "getion";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare('SELECT class_name FROM class');
        $stmt->execute();

        // Fetch the result as an associative array
        $class_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    ?>
    <div class="container mt-5">
        <form method="post" action="add_notes.php">
            <div class="form-group">
                <label for="class">Select Class:</label>
                <select name="class" id="class" class="form-control">
                    <?php
                    foreach ($class_names as $class) {
                        echo '<option value="' . htmlspecialchars($class['class_name']) . '">' . htmlspecialchars($class['class_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Submit</button>

            <div class="result">
                <?php
                        if(isset($_POST['submit'])){
                        $class = $_POST['class'];
                       
                  
                    $stmt = $conn->prepare("SELECT * FROM `stagiaire` WHERE class_stg = :class ");
                    $stmt->bindParam(':class', $class);

                    // Execute the statement
                    $stmt->execute();

                    // Fetch all results
                    $stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Output the results
                    if ($stagiaires) {
                        echo "<table class='table' style='border: solid 1px black;'>";
                        echo "<tr><th>Num</th><th>Firstname</th><th>Last Name</th><th>Class</th><th>add</th><th>change</th></tr>";
                        foreach ($stagiaires as $stagiaire) {
                            echo "<tr>";
                            echo "<td>" . $stagiaire['num_ins']. "</td>";
                            echo "<td>" . $stagiaire['nom_stg']. "</td>";
                            echo "<td>" . $stagiaire['prenom_stg']. "</td>";
                            echo "<td>" . $stagiaire['class_stg']. "</td><td><button class='btn btn-success'><a  style='color:white;' href='add_note2.php?id=".$stagiaire['num_ins']."'>add notes</a></button></td><td><button class='btn btn-warning' ><a style='color:white;' href='change_note.php?id=".$stagiaire['num_ins']."'>change notes</a></button></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo 'No results found for class ' . $class;
                    }
                        }
                ?>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
