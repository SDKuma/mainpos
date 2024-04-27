<?php
include('includes/header.php');
?>

    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-4">Dashboard</h1>
                    <?php alertMessage() ?>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body bg-primary p-3">
                        <p class="text-sm mb-0 text-capitalize">Total Category</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('categories'); ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body bg-warning p-3">
                        <p class="text-sm mb-0 text-capitalize">Total Products</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('products'); ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body bg-info p-3">
                        <p class="text-sm mb-0 text-capitalize">Total Admins</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('admins'); ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body bg-danger p-3">
                        <p class="text-sm mb-0 text-capitalize">Total Customers</p>
                        <h5 class="fw-bold mb-0">
                            <?= getCount('customers'); ?>
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <?php
                        $date_ = date("Y-m-d");
                        $qstring = "SELECT * FROM orders WHERE order_date='".$date_."';";
                        $query = mysqli_query($conn, $qstring);
                        $result = mysqli_num_rows($query);
                        $cash = 0;
                        $online = 0;
                        $card=0;
                        $credit = 0;
                        while($row = mysqli_fetch_assoc($query)){
                            if($row['payment_mode'] == "Cash Payment"){
                                $cash +=(int)$row['net_total'];
                            }

                            if($row['payment_mode'] == "Online Payment"){
                                $online +=(int)$row['net_total'];
                            }

                            if($row['payment_mode'] == "Credit"){
                                $cash +=(int)$row['payed_amount'];
                                $credit +=(int)$row['pending_amount'];
                            }

                            if($row['payment_mode'] == "Card Payment"){
                                $card +=(int)$row['net_total'];
                            }

                            if($row['payment_mode'] == "CnO"){
                                $cash +=(int)$row['cash_payed'];
                                $online +=(int)$row['online_payed'];
                            }

                            if($row['payment_mode'] == "CnC"){
                                $cash +=(int)$row['cash_payed'];
                                $card +=(int)$row['card_payed'];
                            }


                        }
                    ?>
                    <table class="table table-striped-columns">
                        <tr>
                            <th style="text-align: center">Cash</th>
                            <th style="text-align: center">Online</th>
                            <th style="text-align: center">Card</th>
                            <th style="text-align: center">Credit</th>
                        </tr>
                        <tr>
                            <td style="text-align: center;font-size: 35px"><?php echo "Rs. ".$cash; ?></td>
                            <td style="text-align: center;font-size: 35px"><?php echo "Rs. ".$online; ?></td>
                            <td style="text-align: center;font-size: 35px"><?php echo "Rs. ".$card; ?></td>
                            <td style="text-align: center;font-size: 35px"><?php echo "Rs. ".$credit; ?></td>
                        </tr>

                    </table>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5> Recents Orders</h5>
                </div>
                <div class="card-body px-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-item-center justify-content-center">
                            <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>C Name</th>
                                <th>C Phone</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC LIMIT 0 , 4";
                            $orders = mysqli_query($conn, $query);
                            if ($orders) {
                                if (mysqli_num_rows($orders)) {
                                    foreach ($orders as $orderItem) :
                                        ?>
                                        <tr>
                                            <td class="fw-bold"><?= $orderItem['tracking_no'] ?></td>
                                            <td><?= $orderItem['name'] ?></td>
                                            <td><?= $orderItem['phone'] ?></td>
                                            <td><?= date('d M, y', strtotime($orderItem['order_date'])) ?></td>
                                            <td><?= $orderItem['order_status'] ?></td>
                                            <td><?= $orderItem['payment_mode'] ?></td>
                                            <td>
                                                <a href="orders-view.php?track=<?= $orderItem['tracking_no'] ?>"
                                                   class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                                <a href="orders-view-print.php?track=<?= $orderItem['tracking_no'] ?>"
                                                   class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No record available.</td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center">Something went wrong.</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
    </main>

<?php
include('includes/footer.php');
?>