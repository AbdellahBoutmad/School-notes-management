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

        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 100%;
            border-top: 5px solid #007bff;
            position: relative;
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

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-block {
            margin-top: 20px;
        }

        .alert {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .alert .close {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 1.5rem;
            line-height: 1;
            background: none;
            border: none;
            color: #000;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajoute note of stagiaire</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                $stmt = $conn->prepare("INSERT INTO exam (cc1, cc2, efm, num_ins, code_mode) VALUES (:cc1, :cc2, :efm, :num_ins, :code_mode)");

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
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Error: " . $e->getMessage() . "
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
            }
            $conn = null;
        }
        ?>
        <form method="post">
            <h2>Ajoute note of stagiaire</h2>
            <div class="form-outline mb-4">
                <label class="form-label" for="module">Module</label>
                <select name="code_mode" class="form-control" id="module">
                    <?php
                    foreach ($code_modes as $module) {
                        echo '<option value="' . htmlspecialchars($module['code_mode']) . '">' . htmlspecialchars($module['code_mode']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="cc1">CC1</label>
                <input type="text" id="cc1" name="cc1" class="form-control" value="0"/>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="cc2">CC2</label>
                <input type="text" id="cc2" name="cc2" class="form-control" value="0"/>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="efm">EFM</label>
                <input type="text" id="efm" name="efm" class="form-control" value="0"/>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4">Ajouter</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
