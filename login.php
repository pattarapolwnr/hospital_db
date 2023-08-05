<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="/img/favicon.png"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="custom.css">
</head>
<body>
<div class="container">
        <h2 class="display-4 text-center fw-bold fst-italic">Hospital Database Management System</h2>
        <div class="col -md-10 col-lg-8 col-xl-3  mx-auto">
            <div class="card mt-5 mx-auto rounded-4" style= " text-center ">
                <div class="card-body rounded-4  pt-3 pb-3 bg-secondary bg-gradient" style="--bs-bg-opacity: .2;">
                    <h3 class="mt-4 text-center fw-bold">Login</h3>
                    <hr>
                    <form action="login_db.php" method="post">
                        <?php
                            if (isset($_SESSION['error'])){
                        ?>
                            <div class="alert alert-danger my-3">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']); 
                                ?>
                            </div>
                        <?php } ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col -md-10 col-lg-8 col-xl-3  mx-auto">
                            <button type="submit" name="signin" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</html>