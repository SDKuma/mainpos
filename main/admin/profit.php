<?php
include('includes/header.php');
?>
<main>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-4">Admin Dashboard</h1>
                <?php alertMessage() ?>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body bg-info p-3">
                    <p class="text-sm mb-0 text-capitalize">Scrap Profit</p>
                    <h5 class="fw-bold mb-0">
                        <?php
                            $dt = date('Y-m-d');
                            $q = "SELECT * FROM `order_scrap` WHERE date_trans='".$dt."'; ";
                            $r =  mysqli_query($conn, $q);
                            $scrap_tot = 0;
                            while($row = mysqli_fetch_assoc($r)){
                                $scrap_tot +=$row['profit'];
                            }
                            echo $scrap_tot;
                        ?>   
                    </h5>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-body bg-info p-3">
                    <p class="text-sm mb-0 text-capitalize">Item Profit</p>
                    <h5 class="fw-bold mb-0">
                    <?php
                            $dt = date('Y-m-d');
                            $q = "SELECT * FROM `order_items` WHERE date_trans='".$dt."'; ";
                            $r =  mysqli_query($conn, $q);
                            $item_tot = 0;
                            while($row = mysqli_fetch_assoc($r)){
                                // print_r($row);
                                $prod = $row['product_id'];
                                $q2 = "SELECT * FROM `products` WHERE `id`='".$prod."'; ";
                                $r2 =  mysqli_query($conn, $q2);
                                $row1 = mysqli_fetch_assoc($r2);
                                if($row1){
                                //if($row1['price']&&$row1['buying_price']&&$row['quantity']){
                                    $subprofit = ((int)$row1['price']-(int)$row1['buying_price'])*(int)$row['quantity'];
                                }
                                $item_tot +=$subprofit;
                            }

                        $q1 = "SELECT * FROM `orders` WHERE `order_date`='".$dt."'; ";
                        $r1 =  mysqli_query($conn, $q1);
                        $discount_value = 0;
                        while($row1 = mysqli_fetch_assoc($r1)){
                            $discount_value +=($row1['discount']+$row1['on_scrap_discount']);
                        }
                        $final_value = $item_tot - $discount_value;


                            echo $final_value;
                        ?> 
                    </h5>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body bg-info p-3">
                    <p class="text-sm mb-0 text-capitalize">Invoice Total discounts(Scrap Discount + Discount)</p>
                    <h5 class="fw-bold mb-0">
                        <?php echo $discount_value  ?>
                    </h5>

            </div>
        </div>    
    </div>
</main>


<?php
include('includes/footer.php');
?>

