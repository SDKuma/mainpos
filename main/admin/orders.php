<?php
include('includes/header.php');
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
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Srcap Discount</th>
                                <th>Net Total</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $q = "SELECT orders.*,customers.name as customer FROM orders JOIN customers ON orders.customer_id = customers.id;";
                                $orders = mysqli_query($conn, $q);
                                $i = 1;
                                while($row=mysqli_fetch_assoc($orders)){
                                    echo "<tr><td>".$i."</td><td>".$row['tracking_no']."</td><td>".$row['customer']."</td><td>".$row['order_date']."</td><td>".$row['total_amount']."</td><td>".$row['discount']."</td><td>".$row['on_scrap_discount']."</td><td>".$row['net_total']."</td><td>".$row['payment_mode']."</td><td>
                                    <a href='orders-view-print.php?track=".$row['id']."' class='btn btn-primary mb-0 px-2 btn-sm'>Print</a></td></tr>";    
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