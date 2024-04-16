<?php
include("../config/function.php");

if (isset($_GET['getReport'])) {
    $brandQuery = "SELECT * FROM brands;";
    $brandresult = mysqli_query($conn, $brandQuery);
    $brandarray = array();
    $branddataarray = array();
    $today_= date('Y-m-d');

    while ($row = mysqli_fetch_assoc($brandresult)) {
        array_push($brandarray,$row['name']);
        $brandcount = "SELECT COUNT(*) as c FROM order_items LEFT JOIN products ON products.id = order_items.product_id LEFT JOIN `type` ON `type`.id=products.`Type` LEFT JOIN categories ON categories.id=`type`.category WHERE `categories`.brand_id='".$row['id']."' AND order_items.date_trans ='".$today_." ';";
        $brandcountresult = mysqli_query($conn, $brandcount);
        $row1 = mysqli_fetch_assoc($brandcountresult);
        array_push($branddataarray,$row1['c']);
    }

    $branddata = array($brandarray,$branddataarray);

    echo JSON_ENCODE($branddata);
//    echo ;


}
?>