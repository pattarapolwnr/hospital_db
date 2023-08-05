<?php
    session_start();
    if(!isset($_SESSION['user_login'])){
        echo '<script>alert("You have to login first!!")</script>';
        header("refresh:1;login.php");
    }
    require_once("connection.php");

    if(isset($_REQUEST['doctor_id'])) {
        try {
            $id = $_REQUEST['doctor_id'];
            $select_stmt = $db->prepare("SELECT * FROM hospital_db.doctor WHERE doctor_id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO:: FETCH_ASSOC);
            extract($row); 

            $select_stmt2 = $db->prepare("SELECT * FROM hospital_db.department WHERE department_id = :depart");
            $select_stmt2->bindParam(':depart', $department_id);
            $select_stmt2->execute();
            $row2 = $select_stmt2->fetch(PDO:: FETCH_ASSOC);


        } catch(PDOException $e){
            $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor information</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <nav class="navbar navbar-dark bg-dark">
                <a href="#" class="navbar-brand fw-bold fst-italic">Hospital DB Management System
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                        </a>

                        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                            <li><a href="index.php" class="nav-link px-2 text-white">Doctor</a></li>
                            <li><a href="patient.php" class="nav-link px-2 text-white">Patient</a></li>
                            <li><a href="pharmacy.php" class="nav-link px-2 text-white">Pharmacy</a></li>
                        </ul>
                        <div class="text-end">
                            <a href="logout.php" class="btn btn-warning">Logout</a>
                        </div>
                    </div>
                </a>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <h3 class="text-center my-3 display-3">Doctor information</h3>
        </div>
        <div class="card mt-3">
            <div class="card-body rounded-3 pt-5 pb-5 bg-secondary bg-gradient" style="--bs-bg-opacity: .3;">
                <h6 class="display-5 px-3">Fullname : <?php echo $firstname ?>  <?php echo $lastname ?></h6>
                <h6 class="display-5 px-3">Department : <?php echo $row2['name'] ?></h6>
                <h6 class="display-5 px-3">Address : <?php echo $address ?></h6>
                <h6 class="display-5 px-3">Tel : <?php echo $tel ?></h6>
                <h6 class="display-5 px-3">Patient takecare : <?php
                    $select_stmt3 = $db->prepare("SELECT * FROM hospital_db.takecare WHERE doctor_id = :id");
                    $select_stmt3->bindParam(':id', $id);
                    $select_stmt3->execute();
                        while ($row3 = $select_stmt3->fetch(PDO::FETCH_ASSOC)){
                            $select_stmt4 = $db->prepare("SELECT * FROM hospital_db.patient WHERE patient_id = :id");
                            $id4 = $row3['patient_id'];
                            $select_stmt4->bindParam(':id', $id4);
                            $select_stmt4->execute();
                            $row4 = $select_stmt4->fetch(PDO:: FETCH_ASSOC);
                            echo $row4['firstname']." ".$row4['lastname']." , ";
                        }
                ?></h6>
                
            </div>
            </div>
        </div>
        <div class="form-group">
                <div class="col-md-12 mt-5 text-center">
                <a href="edit.php?update_id=<?php echo $row['doctor_id']?>" class="btn btn-primary">Edit</a>
                    <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
    </div>
    
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>