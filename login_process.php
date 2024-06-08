<?php
    $matricle=$_POST['matricule'];
    $password=$_POST['password'];


    $servername = 'localhost';
$dbname = 'getion';
$username = 'abdellah';
$password = 'Woed@8485';


    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement for class
    $info = $pdo->prepare('SELECT matricule ,password FROM formateur');
    $info->execute();
    $list_info = $info->fetchAll(PDO::FETCH_ASSOC);
    echo $list_info;

    ?>