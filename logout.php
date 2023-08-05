<?php
    session_start();
    unset($_SESSION['user_login']);
    echo '<script>alert("Logout successfully!!")</script>';
    header("refresh:1;login.php");
?>