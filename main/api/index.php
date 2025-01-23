<?php
$headers = getallheaders();
if ($headers['Authorization'] == '58874sad558asdasc65asd58asqw4d') {
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_DATABASE", "mainpos2");

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $d = date('Y-m-d');

    $q = "SELECT * FROM orders WHERE order_date = '".$d."';";
    $orders = mysqli_query($conn, $q);
    $today_total = 0;
    $month_total = 0;
    $today_orders = array();
    while ($order = mysqli_fetch_assoc($orders)) {
        $today_total += (int)$order['net_total'];
        array_push($today_orders, $order);
    }

    $d1 = date('Y-m');
    //$d1 = "2024-12";
    $q1 = "SELECT * FROM orders WHERE order_date LIKE '%".$d1."%';";
    $orders1 = mysqli_query($conn, $q1);
    while ($order1 = mysqli_fetch_assoc($orders1)) {
        $month_total += (int)$order1['net_total'];
    }


    $data = array("today_total"=>$today_total,"month_total"=>$month_total,"orders_today"=>$today_orders);




    echo json_encode(["status"=>true,"data"=>$data]);
} else {

}


?>