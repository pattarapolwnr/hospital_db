<?php
    session_start();
    if(!isset($_SESSION['user_login'])){
        echo '<script>alert("You have to login first!!")</script>';
        header("refresh:1;login.php");
    }
    require_once("connection.php");

    if(isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM hospital_db.patient WHERE patient_id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO:: FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e){
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])) {
        $firstname_up = $_REQUEST['txt_firstname'];
        $lastname_up = $_REQUEST['txt_lastname'];
        $age_up = $_REQUEST['txt_age'];
        $depart_up = $_REQUEST['txt_depart'];
        $medicine_up = $_REQUEST['txt_medicine'];
        $room_up = $_REQUEST['txt_room'];

         if(empty($firstname_up)){
            $errorMsg = "Please enter the firstname";
        } else if (empty($lastname_up)){
            $errorMsg = "Please enter the lastname";
        } else if (empty($age_up)){
            $errorMsg = "Please enter the age";
        } else if (empty($depart_up)){
            $errorMsg = "Please enter the department id";
        } else if (empty($medicine_up)){
            $errorMsg = "Please enter the medicine id";
        } else if (empty($room_up)){
            $errorMsg = "Please enter the room id";
        } else {
            try {
                if (!isset($errorMsg)){
                    $update_stmt = $db->prepare("UPDATE hospital_db.patient SET firstname = :fname_up, lastname = :lname_up, age = :age_up, department_id = :depart_up, medicine_id = :medicine_up, room_id = :room_up WHERE patient_id = :id;");
                    $update_stmt->bindParam(':fname_up', $firstname_up);
                    $update_stmt->bindParam(':lname_up', $lastname_up);
                    $update_stmt->bindParam(':age_up', $age_up);
                    $update_stmt->bindParam(':depart_up', $depart_up);
                    $update_stmt->bindParam(':medicine_up', $medicine_up);
                    $update_stmt->bindParam(':room_up', $room_up);
                    $update_stmt->bindParam(':id', $id);
                    if ($update_stmt->execute()){
                        $updateMsg = "Update Successfully";
                        header("refresh:2;patient.php");
                    }
                }
            } catch (PDOException $e){
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
    <title>Edit the information</title>

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
        <div class="display-2 text-center mt-5">Edit</div>
        <?php
            if (isset($errorMsg)){
        ?>
            <div class="alert alert-danger my-3">
                <strong>Error!! <?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php
            if (isset($updateMsg)){
        ?>
            <div class="alert alert-success">
                <strong>Success!! <?php echo $updateMsg; ?></strong>
            </div>
        <?php } ?>

        <div class="card mt-3 mx-5">
            <div class="card-body rounded-3  pt-3 pb-3 bg-secondary bg-gradient" style="--bs-bg-opacity: .3;">
                <form method="post" class="form-horizontal mt-5">
                    <div class="form-group text-center">
                        <div class="row">
                            <label for="firstname" class="col-sm-3 control-label">Firstname</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_firstname" class="form-control" placeholder="Enter the firstname" value="<?php echo $firstname ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="lastname" class="col-sm-3 control-label">Lastname</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_lastname" class="form-control" placeholder="Enter the lastname" value="<?php echo $lastname ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="age" class="col-sm-3 control-label">Age</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_age" class="form-control" placeholder="Enter the age" value="<?php echo $age ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="depart" class="col-sm-3 control-label">Department id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_depart" class="form-control" placeholder="Enter the department id" value="<?php echo $department_id ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="medicine" class="col-sm-3 control-label">Medicine id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_medicine" class="form-control" placeholder="Enter the medicine id" value="<?php echo $medicine_id ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="room" class="col-sm-3 control-label">Room id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_room" class="form-control" placeholder="Enter the room id" value="<?php echo $room_id ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 mt-5 text-center">
                            <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
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