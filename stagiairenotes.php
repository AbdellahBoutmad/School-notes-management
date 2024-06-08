<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            background-image: url("images/bg.png");
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_POST['submit'])) {
        $servername = "localhost";
        $username = "root";
        $password = "Woed@8485";
        $dbname = "getion";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare('SELECT num_ins, nom_stg, password FROM stagiaire WHERE num_ins = :num_ins AND password = :password');
            $stmt->bindParam(':num_ins', $_POST['num_ins']);
            $stmt->bindParam(':password', $_POST['pass']);
            $stmt->execute();

            $info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($info) {
                $stmt = $conn->prepare('SELECT DISTINCT * FROM exam WHERE num_ins = :num_ins');
                $stmt->bindParam(':num_ins', $_POST['num_ins']);
                $stmt->execute();
                $exam = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $conn->prepare('SELECT * FROM attendance WHERE student_registration_number = :num_ins AND status = "absent"');
                $stmt->bindParam(':num_ins', $_POST['num_ins']);
                $stmt->execute();
                $absences = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>            

    <div class="container">
        <p align="center" style="font-size: xx-large;"><?php echo ($info['nom_stg']); ?>مرحبًا بك في حسابك </p>
        <div class="card">
            <div class="card-header">
                Exam Results
            </div>
            <div class="card-body">
                <?php if ($exam) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Module</th>
                            <th>CC1</th>
                            <th>CC2</th>
                            <th>EFM</th>
                        </tr>
                        <?php 
                        $modulesDisplayed = array();
                        foreach ($exam as $exame) {
                            if (!in_array($exame['code_mode'], $modulesDisplayed)) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($exame['code_mode']); ?></td>
                                    <td><?php echo htmlspecialchars($exame['cc1']); ?></td>
                                    <td><?php echo htmlspecialchars($exame['cc2']); ?></td>
                                    <td><?php echo htmlspecialchars($exame['efm']); ?></td>
                                </tr>
                                <?php 
                                $modulesDisplayed[] = $exame['code_mode'];
                            }
                        } ?>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">
                        No exam results found.
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                Absences
            </div>
            <div class="card-body">
                <?php if ($absences) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Registration Number</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        <?php foreach ($absences as $absence) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($absence['student_registration_number']); ?></td>
                            <td><?php echo htmlspecialchars($absence['date']); ?></td>
                            <td><?php echo htmlspecialchars($absence['status']); ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">
                        No absences recorded.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php
            } else {
                echo "<script>alert('Invalid username or password'); window.location.href = 'login_stg.php';</script>";
                exit;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }               

        $conn = null;
    } 
    ?>
</body>
</html>
