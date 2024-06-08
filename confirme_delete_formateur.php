<?php
$servername = "localhost";
$username = "abdellah";
$password = "Woed@8485";
$dbname = "getion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
    
    // Handle deletion
if (isset($_GET['id'])) {
        $matricule = $_GET['id'];
if(isset($_POST['yes'])){
    
        // Begin a transaction
        $conn->beginTransaction();

        // Delete from exam table
        $stmt = $conn->prepare("DELETE FROM formateur WHERE matricule=:matricule;");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();


        // Commit the transaction
        $conn->commit();

        echo "<h1 align='center' style='color:green;'>Stagiaire deleted successfully!</h1>";
        header("location:delete_formateur.php");

}
elseif(isset($_POST['no'])){
    header("location:delete_formateur.php");
}
    }
} catch (PDOException $e) {
    // Rollback the transaction if something failed
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo 'Connection failed: ' . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                
                    <link rel="stylesheet" href="C:\Users\hp\Desktop\a/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin-top: 10%;
            margin-left: 10%;
            margin-right: 10%;
            font-size: xx-large;
            background-image: url("images/bg.png");

        }
        button{
            margin: 30px;
            width: 150px;
            border-radius: 20px;
            padding: auto;
        }
    </style>
</head>
<body>
    <div class="cotainer">
        
   <form method="post">
   <div class="alert alert-danger  " role="alert">
        Are you sure you want to delete formateur! <button class="btn-danger" name="yes">YES</button><button  class="btn-success"name="no">NO</button>
      </div>

   </form>
      </div>
</body>
</html>
