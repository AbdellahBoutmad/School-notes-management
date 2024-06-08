<?php
$servername = "localhost";
$username = "root";
$password = "Woed@8485";
$dbname = "getion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Your form data
        $class = $_POST["class"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $password = $_POST["password"];
        $num_Ins = $_POST["num_Ins"];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO stagiaire (num_ins, nom_stg, prenom_stg, class_stg, `password`) VALUES (:num_ins, :nom_stg, :prenom_stg, :class_stg, :password)");

        // Bind parameters
        $stmt->bindParam(':class_stg', $class);
        $stmt->bindParam(':num_ins', $num_Ins);
        $stmt->bindParam(':prenom_stg', $prenom);
        $stmt->bindParam(':nom_stg', $nom);
        $stmt->bindParam(':password', $password);

        // Execute the statement
        $stmt->execute();

        // Redirect and display success message
        echo "<script>
                alert('Stagiaire added successfully');
                window.location.href='add_stg.php';
              </script>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: stagiaire not added " ;

}

$conn = null;
?>
