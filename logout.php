<?php
    session_start();
    
    $_SESSION['login'] = false;
    $_SESSION['id_user'] = '';
    $_SESSION['nama_user'] = '';
    $_SESSION['level_user'] = '';
    $_SESSION['email_user'] = '';
    $_SESSION['notelp_user'] = '';
    $_SESSION['status_user'] = '';
    $_SESSION['avatar_user'] = '';
    $_GET['ke']='';


    unset($_SESSION['login']);
    unset($_SESSION['id_user']);
    unset($_SESSION['nama_user']);
    unset($_SESSION['level_user']);
    unset($_SESSION['email_user']);
    unset($_SESSION['notelp_user']);
    unset($_SESSION['status_user']);
    unset($_SESSION['avatar_user']);
    unset($_GET['ke']);

    session_unset();
    session_destroy();
    header("Location: index.php");
?>

