<?php
require "../config/functions.php";
date_default_timezone_set('Asia/Colombo');
?>
<html>
<head>
<style>
    th,td{
        text-align: left;
        border-bottom: 3px solid gray;
        padding: 5px;
    }

</style>
</head>
<body>
<h2>Added Stock on : <?php echo date('Y-m-d') ?></h2>
<table class="table table-striped table-bordered" id="product-table" width="80%">
    <thead>
    <tr>
        <th></th>
        <th>ID</th>
        <th>Brand</th>
        <th>Name</th>
        <th>Amp</th>
        <th>Price(Rs)</th>
        <th>Quantity</th>

    </tr>
    </thead>
    <tbody>
    <?php
    // $q = "SELECT `products`.*,`brands`.`name` as 'brand',`type`.`name` as 'type_' FROM products LEFT JOIN `brands` ON `products`.`Brand`=`brands`.`id` LEFT JOIN `type` ON `type`.`id`=`products`.`Type`;";
    $q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.exactdate='".date('Y-m-d')."' ORDER BY products.id DESC;";
    $result = mysqli_query($conn, $q);
    $a = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $cre =explode(" ",$row['created_at']);
        //echo "----".$cre[0].'///'.date('Y-m-d');
        if($cre[0]==date("Y-m-d")){
            $style = 'style="background-color:lightgreen;"';
        }else{
            $style = 'style="background-color:none;"';
        }

        echo "<tr ".$style." id='prodrw" . $row['id'] . "' onclick='selectthis(" . $row['id'] . ")'><td>".$a."</td><td>" . $row['id'] . "</td><td>" . $row['brand'] . "</td><td>" . $row['type_'] . "-" . $row['name'] . "</td><td>" . $row['amp'] . "</td><td>" . $row['price'] . "</td><td>" . $row['quantity'] . "</td></tr>";
        $a++;
    }
    ?>

    </tbody>
</table>

<script>
    window.print();
</script>
</body>

</html>