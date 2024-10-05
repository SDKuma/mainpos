<?php
    require '../config/function.php';
    $query_1 = "SELECT COUNT(*) as c FROM `melimit`";
    $result_1 = mysqli_query($conn, $query_1);
    $row_1 = mysqli_fetch_assoc($result_1);
    if($row_1['c']== 0){
        $query = "INSERT INTO `melimit` (`id`, `val_1`) VALUES (NULL, '".$_POST['amount']."'); ";
        $result2 = mysqli_query($conn, $query);
    }else{
        $query = "UPDATE `melimit` SET `val_1`= ".$_POST['amount']." WHERE id = 1;";
        $result2 = mysqli_query($conn, $query);
    }


    header('location:melimits.php');
//EMTRAC EMTRAC-EFB50B20L 40 AH
?>