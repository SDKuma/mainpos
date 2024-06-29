<?php
include('includes/header.php');
?>
    <main>
        <div class="modal fade" id="paycreditModal" data-bs-backdrop="static" data-bs-keyboards="false" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Settle Credit</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="orders-code.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Amount Pending</label>
                            <input type="text" id="pend_amount" class="form-control" disabled>
                            <input type="hidden" id="orderid" name="orderid" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="phone">Paying Amount</label>
                            <input type="text" id="paying" name="paying" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary confirmSettle" name="confirmSettle">Settle</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="mb-0">Credit Pending Orders</h4>
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

                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Scr. Discount</th>
                                <th>Payed </th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $q = "SELECT orders.*,customers.name as customer FROM orders JOIN customers ON orders.customer_id = customers.id WHERE orders.payment_mode='Credit' AND orders.pending_amount !='0';";
                            $orders = mysqli_query($conn, $q);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($orders)) {
                                echo "<tr><td>" . $row["invoice_no"] . "</td><td>" . $row['customer'] . "</td><td>" . $row['order_date'] . "</td><td>" . $row['total_amount'] . "</td><td>" . $row['discount'] . "</td><td>" . $row['on_scrap_discount'] . "</td><td>Rs. " . number_format((int)$row['payed_amount']) . "</td><td>" . $row['pending_amount'] . "</td><td>" . $row['order_status'] . "</td><td>
                                    <a href='orders-view-print.php?track=" . $row['id'] . "' class='btn btn-primary mb-0 px-2 btn-sm'>Print</a>  <a id='btnsettle' onclick='opensettlemodal(".$row["id"].",".$row["pending_amount"].")' class='btn btn-danger mb-0 px-2 btn-sm'>Settle</a>  <a href='credit-history.php?order=".$row['id']."' class='btn btn-info btn-sm'>View History</a></td></tr>";
                                $i += 1;
                            }
                            ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="mb-0">Credit Payed Orders</h4>
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
                               id="orderstable1">
                            <thead>
                            <tr>

                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Scr. Discount</th>
                                <th>Payed </th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $q = "SELECT orders.*,customers.name as customer FROM orders JOIN customers ON orders.customer_id = customers.id WHERE orders.payment_mode='Credit' AND orders.pending_amount ='0';";
                            $orders = mysqli_query($conn, $q);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($orders)) {
                                echo "<tr><td>" . $row["invoice_no"] . "</td><td>" . $row['customer'] . "</td><td>" . $row['order_date'] . "</td><td>" . $row['total_amount'] . "</td><td>" . $row['discount'] . "</td><td>" . $row['on_scrap_discount'] . "</td><td>Rs. " . number_format((int)$row['payed_amount']) . "</td><td>" . $row['pending_amount'] . "</td><td>" . $row['order_status'] . "</td><td>
                                    <a href='orders-view-print.php?track=" . $row['id'] . "' class='btn btn-primary mb-0 px-2 btn-sm'>Print</a>  <a href='credit-history.php?order=".$row['id']."' class='btn btn-info btn-sm'>View History</a></td></tr>";
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

    <script>
        function opensettlemodal(orderid,pending_){
            $('#paycreditModal').modal('show');
            $('#pend_amount').val(pending_);
            $('#orderid').val(orderid);
        }

        
    </script>

<?php
include('includes/footer.php');
?>