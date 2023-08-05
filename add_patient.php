<?php
    session_start();
    if(!isset($_SESSION['user_login'])){
        echo '<script>alert("You have to login first!!")</script>';
        header("refresh:1;login.php");
    }
    require_once("connection.php");
    
    if(isset($_REQUEST['btn_insert'])) {
        $firstname = $_REQUEST['txt_firstname'];
        $lastname = $_REQUEST['txt_lastname'];
        $age = $_REQUEST['txt_age'];
        $depart = $_REQUEST['txt_depart'];
        $medicine = $_REQUEST['txt_medicine'];
        $room = $_REQUEST['txt_room'];

        if(empty($firstname)){
            $errorMsg = "Please enter the firstname";
        } else if (empty($lastname)){
            $errorMsg = "Please enter the lastname";
        } else if (empty($age)){
            $errorMsg = "Please enter the age";
        } else if (empty($depart)){
            $errorMsg = "Please enter the department id";
        } else if (empty($medicine)){
            $errorMsg = "Please enter the medicine id";
        } else if (empty($room)){
            $errorMsg = "Please enter the room id";
        } else {
            try {
                if (!isset($errorMsg)){
                    $insert_stmt = $db->prepare("INSERT INTO hospital_db.patient(firstname,lastname,age,department_id,medicine_id,room_id) VALUES(:fname, :lname, :age, :depart, :medicine, :room);");
                    $insert_stmt->bindParam(':fname', $firstname);
                    $insert_stmt->bindParam(':lname', $lastname);
                    $insert_stmt->bindParam(':age', $age);
                    $insert_stmt->bindParam(':depart', $depart);
                    $insert_stmt->bindParam(':medicine', $medicine);
                    $insert_stmt->bindParam(':room', $room);
                    if ($insert_stmt->execute()){
                        $insertMsg = "Insert Successfully";
                        header("refresh:2;patient.php");
                    }
                }   
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>

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
        <div class="display-2 text-center mt-5">Add Patient</div>
        <?php
            if (isset($errorMsg)){
        ?>
            <div class="alert alert-danger my-3">
                <strong>Wrong!! <?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php
            if (isset($insertMsg)){
        ?>
            <div class="alert alert-success">
                <strong>Success!! <?php echo $insertMsg; ?></strong>
            </div>
        <?php } ?>

        <div class="card mt-5 mx-5">
            <div class="card-body rounded-3  pt-3 pb-3 bg-secondary bg-gradient" style="--bs-bg-opacity: .2;">
                <form method="post" class="form-horizontal mt-5">
                    <div class="form-group text-center">
                        <div class="row">
                            <label for="firstname" class="col-sm-3 control-label">Firstname</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_firstname" class="form-control" placeholder="Enter the firstname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="lastname" class="col-sm-3 control-label">Lastname</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_lastname" class="form-control" placeholder="Enter the lastname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="age" class="col-sm-3 control-label">Age</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_age" class="form-control" placeholder="Enter the age">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="depart" class="col-sm-3 control-label">Department id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_depart" class="form-control" placeholder="Enter the department id">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="medicine" class="col-sm-3 control-label">Medicine id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_medicine" class="form-control" placeholder="Enter the medicine id">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="room" class="col-sm-3 control-label">Room id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_room" class="form-control" placeholder="Enter the room id">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 mt-5 text-center">
                            <input type="submit" name="btn_insert" class="btn btn-primary" value="Insert">
                            <a href="patient.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>