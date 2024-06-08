<?php
$servername = "localhost";
$username = "abdellah";
$password = "Woed@8485";
$dbname = "getion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('SELECT code_mode FROM module');
    $stmt->execute();

    // Fetch the result as an associative array
    $code_modes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    background-color: #f0f2f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

form {
padding: auto;  }

.container {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    max-width: 700px; /* Increased width */
    width: 100%;
    border-top: 5px solid #007bff;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #007bff;
    font-weight: 700;
}

.form-outline {
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #333;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%; /* Set width to 100% */
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    background-color: #e9f4ff;
}

.btn {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 5px;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.btn-block {
    margin-top: 20px;
}

footer {
    text-align: center;
    margin-top: 20px;
    color: #777;
}

    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $num_ins = $_GET['id'];
                $cc1 = $_POST['cc1'];
                $cc2 = $_POST['cc2'];
                $efm = $_POST['efm'];
                $code_mode = $_POST['code_mode'];

                // Prepare the SQL statement
                $stmt = $conn->prepare("UPDATE exam SET cc1 = :cc1, cc2 = :cc2, efm = :efm WHERE num_ins = :num_ins AND code_mode = :code_mode");

                // Bind parameters
                $stmt->bindParam(':cc1', $cc1);
                $stmt->bindParam(':cc2', $cc2);
                $stmt->bindParam(':efm', $efm);
                $stmt->bindParam(':num_ins', $num_ins);
                $stmt->bindParam(':code_mode', $code_mode);

                // Execute the statement
                $stmt->execute();

                echo "<div class='alert alert-primary alert-dismissible fade show' role='alert'>
                        Notes added successfully!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            $conn = null;
        }
        ?>
        <form method="post">
            <h2>Change note of stagiaire</h2>
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="module">Module</label>
                <select name="code_mode" class="form-control" id="module" style="height:50px">
                    <?php
                    foreach ($code_modes as $module) {
                        echo '<option value="' . htmlspecialchars($module['code_mode']) . '">' . htmlspecialchars($module['code_mode']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="cc1">CC1</label>
                <input value=0 type="text" id="cc1" name="cc1" id="input" class="form-control"  />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="cc2">CC2</label>
                <input id="input" value=0 type="text" id="cc2" name="cc2" class="form-control"  />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label  class="form-label" for="efm">EFM</label>
                <input id="input" value=0 type="text" id="efm" name="efm" class="form-control"  />
            </div>

            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Change</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
