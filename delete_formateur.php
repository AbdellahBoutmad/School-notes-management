<!DOCTYPE html>
<html lang="en">
<head>
    <style>
              body{
            margin-top: 10%;
            margin-left: 10%;
            margin-right: 10%;
            font-size: xx-large;
            background-image: url("images/bg.png");

        }
    </style>
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
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       

   
    ?>
    <div class="container mt-5">
  

            <div class="result">
                <?php
                       
                  
                    $stmt = $conn->prepare("SELECT * FROM `formateur`");

                    // Execute the statement
                    $stmt->execute();

                    // Fetch all results
                    $formateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Output the results
                    if ($formateurs) {
                        echo "<table class='table' style='border: solid 1px black;'>";
                        echo "<tr><th>Matricule</th><th>Firstname</th><th>Last Name</th><th>Password</th><th>delete</th></tr>";
                        foreach ($formateurs as $formateur) {
                            echo "<tr>";
                            echo "<td>" . $formateur['matricule']. "</td>";
                            echo "<td>" . $formateur['nom']. "</td>";
                            echo "<td>" . $formateur['prenom']. "</td>";
                            echo "<td>" . $formateur['password']. "</td><td><button class='btn btn-danger' ><a name='delete_formateur' style='color:white;' href='confirme_delete_formateur.php?id=".$formateur['matricule']."'>delete formateur</a></button></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo 'No results found for formateur ' ;
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
