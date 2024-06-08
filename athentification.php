<?php
$servername = "localhost";
$username = "root";
$password = "Woed@8485";
$dbname = "getion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('SELECT matricule, password FROM formateur WHERE matricule = :matricule AND password = :password');
    
    $stmt->bindParam(':matricule', $_POST['matricule']);
    $stmt->bindParam(':password', $_POST['pass']);
    $stmt->execute();

    $info = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($info) {
        header('Location: login_formateur.html');
        exit;

    } else {
        echo "<script>alert('Invalid username or password'); window.location.href = 'login_format.php';</script>";


    }

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
