<?php
    session_start();
    if(!isset($_SESSION['user_login'])){
        echo '<script>alert("You have to login first!!")</script>';
        header("refresh:1;login.php");
    }
    require_once("connection.php");

    if(isset($_REQUEST['btn_insert'])) {
        $username = $_REQUEST['txt_username'];
        $password = $_REQUEST['txt_password'];
        $firstname = $_REQUEST['txt_firstname'];
        $lastname = $_REQUEST['txt_lastname'];
        $address = $_REQUEST['txt_address'];
        $depart = $_REQUEST['txt_depart'];
        $tel = $_REQUEST['txt_tel'];
        $patient_id = $_REQUEST['txt_patient'];

        if (empty($username)){
            $errorMsg = "Please enter the username";
        } else if(empty($password)){
            $errorMsg = "Please enter the password";
        } else if(empty($firstname)){
            $errorMsg = "Please enter the firstname";
        } else if (empty($lastname)){
            $errorMsg = "Please enter the lastname";
        } else if (empty($address)){
            $errorMsg = "Please enter the address";
        } else if (empty($depart)){
            $errorMsg = "Please enter the department id";
        } else if (empty($tel)){
            $errorMsg = "Please enter the telephone number";
        } else if (empty($patient_id)){
            $errorMsg = "Please enter the patient_id";
        } else {
            try {
                if (!isset($errorMsg)){
                    $insert_stmt = $db->prepare("INSERT INTO hospital_db.doctor(firstname,lastname,address,department_id,tel) VALUES(:fname, :lname, :addres, :depart, :tel);");
                    $insert_stmt->bindParam(':fname', $firstname);
                    $insert_stmt->bindParam(':lname', $lastname);
                    $insert_stmt->bindParam(':addres', $address);
                    $insert_stmt->bindParam(':depart', $depart);
                    $insert_stmt->bindParam(':tel', $tel);
                    if ($insert_stmt->execute()){
                        $insertMsg = "Insert Successfully";
                        $select_stmt = $db->prepare("SELECT * from hospital_db.doctor WHERE lastname= :lname ");
                        $select_stmt->bindParam(':lname',$lastname);
                        $select_stmt->execute();
                        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                        $insert_stmt2 = $db->prepare("INSERT INTO hospital_db.takecare(doctor_id,patient_id) VALUES(:doctor,:patient)");
                        $insert_stmt2->bindParam(':doctor',$row['doctor_id']);
                        $insert_stmt2->bindParam(':patient',$patient_id);
                        $insert_stmt2->execute();
                        $insert_stmt3 = $db->prepare("INSERT INTO hospital_db.user(user_id,username,password) VALUES(:userid,:username,:passwor)");
                        $insert_stmt3->bindParam(':userid',$row['doctor_id']);
                        $insert_stmt3->bindParam(':username',$username);
                        $insert_stmt3->bindParam(':passwor',$password);
                        $insert_stmt3->execute();
                        header("refresh:2;index.php");
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
    <title>Add Doctor</title>

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
        <div class="display-2 text-center mt-5">Add Doctor</div>
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
            <div class="card-body rounded-3  pt-3 pb-3 bg-secondary bg-gradient" style="--bs-bg-opacity: .3;">
                <form method="post" class="form-horizontal mt-5">
                    <div class="form-group text-center">
                        <div class="row">
                            <label for="username" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_username" class="form-control" placeholder="Enter the username">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="row">
                            <label for="password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_password" class="form-control" placeholder="Enter the password">
                            </div>
                        </div>
                    </div>
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
                            <label for="Address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-8 mb-3">
                                <textarea name="txt_address" rows="3" cols="25" placeholder="Enter the address" class="form-control"></textarea>
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
                            <label for="tel" class="col-sm-3 control-label">Telephone number</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_tel" class="form-control" placeholder="Enter the tel">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="tel" class="col-sm-3 control-label">Patient takecare</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_patient" class="form-control" placeholder="Enter the patient id">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 mt-5 text-center">
                            <input type="submit" name="btn_insert" class="btn btn-primary" value="Insert"></input>
                            <a href="index.php" class="btn btn-secondary">Cancel</a>
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