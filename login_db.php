<?php
    session_start();
    require_once("connection.php");

    if(isset($_POST['signin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username)){
            $_SESSION['error'] = "Please input the username";
            header("location:login.php");
        } else if (empty($password)) {
            $_SESSION['error'] = "Please input the password";
            header("location:login.php");
        } else {
            try {
                $check_username = $db->prepare("SELECT * FROM hospital_db.user WHERE username=:username;"); 
                $check_username->bindParam(":username",$username);
                $check_username->execute();
                $row = $check_username->fetch(PDO::FETCH_ASSOC);
                $row['username'];

                if ($check_username->rowCount() >0){

                    if($username == $row['username']){
                        if ($password == $row['password']){
                            $_SESSION['user_login'] = $row['user_id'];
                            header("location:index.php");
                        }
                        else {
                            $_SESSION['error'] = "Wrong Password";
                            header("location:login.php");
                        }
                    }
                } else {
                    $_SESSION['error'] = "No data in the database!";
                    header("location:login.php");
                }

            } catch (PDOException $e){
                $e->getMessage();
            }
        }
    }
?>