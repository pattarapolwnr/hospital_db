<?php
    session_start();
    if(!isset($_SESSION['user_login'])){
        echo '<script>alert("You have to login first!!")</script>';
        header("refresh:1;login.php");
    }
    require_once("connection.php");

    if (isset($_REQUEST['delete_id'])){
        $id = $_REQUEST['delete_id'];
        $select_stmt = $db->prepare("SELECT * FROM hospital_db.doctor WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $delete_stmt = $db->prepare("DELETE FROM hospital_db.takecare WHERE doctor_id = :id"); 
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        $delete_stmt2 = $db->prepare("DELETE FROM hospital_db.user WHERE user_id = :id"); 
        $delete_stmt2->bindParam(':id', $id);
        $delete_stmt2->execute();

        $delete_stmt3 = $db->prepare("DELETE FROM hospital_db.doctor WHERE doctor_id = :id"); 
        $delete_stmt3->bindParam(':id', $id);
        $delete_stmt3->execute();

        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>
    <link rel="icon" type="image/png" href="/img/favicon.png"/>
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
        <div class="display-3 text-center mt-5">Doctor Table</div>
        <a href="add.php" class="btn btn-primary my-3 ">Add Doctor +</a>
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fullname</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                
            </thead>
        
            <tbody>
                <?php
                    $select_stmt = $db->prepare("SELECT * FROM hospital_db.doctor"); 
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)){
                ?>
                        <tr>
                            <td><?php echo $row["doctor_id"] ?></td>
                            <td><a href="doctor_info.php?doctor_id=<?php echo $row["doctor_id"]?>" class="text-decoration-none"><?php echo $row["firstname"] ?> <?php echo $row["lastname"] ?></a></td>
                            <td><a href="edit.php?update_id=<?php echo $row['doctor_id']?>" class="btn btn-primary">Edit</a></td>
                            <td><a href="?delete_id=<?php echo $row['doctor_id'] ?>" class="btn btn-secondary" onclick="return confirm('Please confirm your deleted action?')">Delete</a></td>
                        </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
    
    <script src="js/slim.js"></>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>