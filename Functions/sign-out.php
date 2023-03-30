<?php 
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();

    header("Location: ../Sign In/sign-in.php");
    exit;
?>