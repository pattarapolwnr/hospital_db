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
            $select_stmt = $db->prepare("SELECT * FROM hospital_db.doctor WHERE doctor_id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO:: FETCH_ASSOC);
            extract($row);
            $select_stmt2 = $db->prepare("SELECT * FROM hospital_db.takecare WHERE doctor_id = :id");
            $select_stmt2->bindParam(':id', $id);
            $select_stmt2->execute();
            $row2 = $select_stmt2->fetch(PDO:: FETCH_ASSOC);
        } catch(PDOException $e){
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])) {
        $firstname_up = $_REQUEST['txt_firstname'];
        $lastname_up = $_REQUEST['txt_lastname'];
        $address_up = $_REQUEST['txt_address'];
        $depart_up = $_REQUEST['txt_depart'];
        $tel_up = $_REQUEST['txt_tel'];

        if(empty($firstname_up)){
            $errorMsg = "Please enter the firstname";
        } else if (empty($lastname_up)){
            $errorMsg = "Please enter the lastname";
        } else if (empty($address_up)){
            $errorMsg = "Please enter the address";
        } else if (empty($depart_up)){
            $errorMsg = "Please enter the department id";
        } else if (empty($tel_up)){
            $errorMsg = "Please enter the telephone number";
        } else {
            try {
                if (!isset($errorMsg)){
                    $update_stmt = $db->prepare("UPDATE hospital_db.doctor SET firstname = :fname_up, lastname = :lname_up, address = :address_up, department_id = :depart_up, tel = :tel_up WHERE doctor_id = :id;");
                    $update_stmt->bindParam(':fname_up', $firstname_up);
                    $update_stmt->bindParam(':lname_up', $lastname_up);
                    $update_stmt->bindParam(':address_up', $address_up);
                    $update_stmt->bindParam(':depart_up', $depart_up);
                    $update_stmt->bindParam(':tel_up', $tel_up);
                    $update_stmt->bindParam(':id', $id);
                    if ($update_stmt->execute()){
                        $updateMsg = "Update Successfully";
                        header("refresh:2;index.php");
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
                                <input type="text" name="txt_firstname" class="form-control" placeholder="Enter the firstname" value="<?php echo $firstname; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="lastname" class="col-sm-3 control-label">Lastname</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_lastname" class="form-control" placeholder="Enter the lastname" value="<?php echo $lastname; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="Address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-8 mb-3">
                                <textarea name="txt_address" rows="3" cols="25" placeholder="Enter the address" class="form-control"><?php echo $address; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="depart" class="col-sm-3 control-label">Department id</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_depart" class="form-control" placeholder="Enter the department id" value="<?php echo $department_id; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="tel" class="col-sm-3 control-label">Telephone number</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_tel" class="form-control" placeholder="Enter the tel" value="<?php echo $tel; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 mt-5 text-center">
                            <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
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