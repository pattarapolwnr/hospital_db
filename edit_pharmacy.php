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
            $select_stmt = $db->prepare("SELECT * FROM hospital_db.pharmacy WHERE medicine_id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO:: FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e){
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])) {
        $medicine_up = $_REQUEST['txt_medicine'];
        $name_up = $_REQUEST['txt_name'];
        $amount_up = $_REQUEST['txt_amount'];

        if(empty($medicine_up)){
            $errorMsg = "Please enter the medicine id";
        } else if (empty($name_up)){
            $errorMsg = "Please enter the name";
        } else if (empty($amount_up)){
            $errorMsg = "Please enter the amount";
        } else {
            try {
                if (!isset($errorMsg)){
                    $update_stmt = $db->prepare("UPDATE hospital_db.pharmacy SET medicine_id = :medicine_up, name = :name_up, amount = :amount_up WHERE medicine_id = :id;");
                    $update_stmt->bindParam(':medicine_up', $medicine_up);
                    $update_stmt->bindParam(':name_up', $name_up);
                    $update_stmt->bindParam(':amount_up', $amount_up);
                    $update_stmt->bindParam(':id', $id);
                    if ($update_stmt->execute()){
                        $updateMsg = "Update Successfully";
                        header("refresh:2;pharmacy.php");
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
                            <label for="medicine_id" class="col-sm-3 control-label">Medicine ID</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_medicine" class="form-control" placeholder="Enter the medicine ID" value="<?php echo $medicine_id ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_name" class="form-control" placeholder="Enter the name" value="<?php echo $name ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <label for="amount" class="col-sm-3 control-label">Amount</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" name="txt_amount" class="form-control" placeholder="Enter the amount" value="<?php echo $amount ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 mt-5 text-center">
                            <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
                            <a href="pharmacy.php" class="btn btn-secondary">Cancel</a>
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