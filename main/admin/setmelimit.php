<?php
    require '../config/function.php';
    $query = "INSERT INTO `melimit` (`id`, `val_1`) VALUES (NULL, '".$_POST['amount']."'); ";
    $result2 = mysqli_query($conn, $query);

    header('location:melimits.php');




?>