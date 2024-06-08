<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="C:\Users\hp\Desktop\a/bootstrap.min.css">
    <title>Document</title>
    <style>
        .container{
            display: flex;
            justify-content: center;
            margin-top: 2%;
        }
        
    </style>
</head>
<body>





<?php
  $dsn = 'mysql:host=localhost;dbname=getion';
  $username = 'abdellah';
  $password = 'Woed@8485';
  
  try {
      // Create a PDO instance (connect to the database)
      $pdo = new PDO($dsn, $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      // Prepare and execute the SQL statement
      $stmt = $pdo->prepare('SELECT class_name FROM class');
      $stmt->execute();
  
      // Fetch the result as an associative array
      $class_names = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }
?>
  




    <div class="container">
    <form style="width: 26rem;" action="add_stg_php.php" method="post">
        <h1>ajouter un stagiaire</h1>

        <!-- Name input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="class" >class</label>
            <select name="class" class="form-control" id="class">
                <?php
                foreach ($class_names as $class) {
                    echo '<option value="' . htmlspecialchars($class['class_name']) . '">' . htmlspecialchars($class['class_name']) . '</option>';
                }
                ?>
    </select>


        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="nom" >Nom</label>
          <input type="text" id="nom" name="nom" class="form-control" />
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
          <label class="form-label" for="prenom" >prenom</label>
        <input type="text" id="prenom" name="prenom" class="form-control" />
      </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="num_Ins" >numero d'inscreption</label>
          <input type="text" id="num_Ins" name="num_Ins" class="form-control" />
        </div>
        
        <div data-mdb-input-init class="form-outline mb-4">
          <label class="form-label" for="password" >password</label>
        <input type="text" id="password" name="password" class="form-control" />
      </div>

        
        
        
        
        
      
        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Ajouter</button>
      </form>
    </div>
</body>
</html>