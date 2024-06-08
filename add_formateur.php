<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
$servername = 'localhost';
$dbname = 'getion';
$username = 'abdellah';
$password = 'Woed@8485';

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement for class
    $stmt_class = $pdo->prepare('SELECT class_name FROM class');
    $stmt_class->execute();
    $class_names = $stmt_class->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute the SQL statement for module
    $stmt_module = $pdo->prepare('SELECT code_mode FROM module');
    $stmt_module->execute();
    $code_modes = $stmt_module->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<div class="container">
    <form style="width: 26rem;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h1>ajouter un formateur</h1>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="class">Class</label>
            <select name="class[]" class="form-control" id="class" multiple>
                <?php
                foreach ($class_names as $class) {
                    echo '<option value="' . htmlspecialchars($class['class_name']) . '">' . htmlspecialchars($class['class_name']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="module">Module</label>
            <select name="module[]" class="form-control" id="module" multiple>
                <?php
                foreach ($code_modes as $module) {
                    echo '<option value="' . htmlspecialchars($module['code_mode']) . '">' . htmlspecialchars($module['code_mode']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" />
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="prenom">Prenom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" />
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="matricule">Matricule</label>
            <input type="text" id="matricule" name="matricule" class="form-control" />
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="text" id="password" name="password" class="form-control" />
        </div>

        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Ajouter</button>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your form data
    $class = $_POST["class"];
    $module = $_POST["module"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $password = $_POST["password"];
    $num_Ins = $_POST["matricule"];

    // Prepare the SQL statement
    $stmt_insert = $pdo->prepare("INSERT INTO formateur (matricule, nom, prenom, class, password, module) VALUES (:matricule, :nom, :prenom, :class, :password, :module)");

    // Convert the array to string for class
    $class_str = implode(',', $class);
    $module_str = implode(',', $module);

    // Bind parameters
    $stmt_insert->bindParam(':class', $class_str);
    $stmt_insert->bindParam(':module', $module_str);
    $stmt_insert->bindParam(':matricule', $num_Ins);
    $stmt_insert->bindParam(':prenom', $prenom);
    $stmt_insert->bindParam(':nom', $nom);
    $stmt_insert->bindParam(':password', $password);

    // Execute the statement
    $stmt_insert->execute();

    // Redirect and display success message
    echo "<script>
                alert('Formateur added successfully');
                window.location.href='add_formateur'.php';
              </script>";
    exit;
}
else{
    echo "<script>
                alert('erroor not added');
                window.location.href='add_formateur'.php';
              </script>";
}

$pdo = null;
?>

</body>
</html>
