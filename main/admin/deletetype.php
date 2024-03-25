<?php
    // include('includes/header.php');
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_DATABASE", "mainpos");

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }
    
    $typeid= $_GET['id'];
    $q = "UPDATE `type` SET `status`=0 WHERE id = ".$typeid."";
    $res =  mysqli_query($conn, $q);
    // $data = mysqli_fetch_assoc($res);

    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit;
?>