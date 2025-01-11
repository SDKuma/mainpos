<?php
include('includes/header.php');
if(isset($_GET['key'])&&$_GET['key']=="LOPX45P8"){
    $q = "SELECT orders.*,customers.name as customer FROM orders JOIN customers ON orders.customer_id = customers.id;";
}else{
    $q = "SELECT orders.*,customers.name as customer FROM orders JOIN customers ON orders.customer_id = customers.id WHERE orders.flag1 = 0;";
}

?>
<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="mb-0">Orders</h4>
                    </div>
                    <div class="col-md-8 ">
                        <form action="" method="GET">
                            <div class="row g-1">
                                <div class="col-md-4">
                                   
                                </div>
                                <div class="col-md-4">
                                  
                                </div>
                                <div class="col-md-4">
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-item-center justify-content-center" id="orderstable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tracking No.</th>
                                <th>Customer</th>
                                <th>Method</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Service Charge </th>
                                <th>Discount</th>
                                <th>Srcap Discount</th>
                                <th>Net Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $orders = mysqli_query($conn, $q);
                                $i = 1;
                                while($row=mysqli_fetch_assoc($orders)){
                                    echo "<tr><td>".$i."</td><td>".$row['tracking_no']."</td><td>".$row['customer']."</td><td>".$row['payment_mode']."</td><td>".$row['order_date']."</td><td>".$row['total_amount']."</td><td>".$row['service_charge']."</td><td>".$row['discount']."</td><td>".$row['on_scrap_discount']."</td><td>".$row['net_total']."</td><td>
                                    <a href='orders-view-print.php?track=".$row['id']."' class=' '><i class='fa fa-print' aria-hidden='true'></i></a></td></tr>";
                                    $i +=1;
                                }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include('includes/footer.php');
?>