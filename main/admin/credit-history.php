<?php
include('includes/header.php');
$order = $_GET['order'];
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
                        <table class="table table-striped table-bordered align-item-center justify-content-center"
                               id="orderstable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount</th>

                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            //$q = "SELECT orders.*,customers.name as customer FROM orders JOIN customers ON orders.customer_id = customers.id WHERE orders.payment_mode='Credit';";
                            $q = "SELECT * FROM `credit_history` WHERE `order_id`='$order';";
                            $orders = mysqli_query($conn, $q);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($orders)) {
                                echo "<tr><td>".$i."</td><td>".$row["date_payed"]."</td><td>".$row["time_payed"]."</td><td>".$row["payed"]."</td></tr>";
                                $i += 1;
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