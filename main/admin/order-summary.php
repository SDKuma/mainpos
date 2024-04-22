<?php
include('includes/header.php');
if (!isset($_SESSION['productItems'])) {
    echo '<script> window.location.href="order-create.php"</script>';
}
date_default_timezone_set('Asia/Colombo');
?>

<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboards="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <h5 id="orderPlaceSuccess"></h5>
                </div>
                <a href="orders.php" class="btn btn-secondary">Close</a>
                <a href="orders-view-print.php" class="btn btn-danger" onclick="printBillingArea()">Print</a>
                <button type="button" class="btn btn-warning" onclick="downloadPDF('<?= $_SESSION['invoice_no']; ?>')">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Order Summary
                            <a href="order-create.php" class="btn btn-danger float-end">Back to create order</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php alertMessage(); ?>
                        <div id="myBillingArea">
                            <?php
                            if (isset($_SESSION['cphone'])) {
                                $phone = validate($_SESSION['cphone']);
                                $invoiceNo = validate($_SESSION['invoice_no']);

                                $customerQuery = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
                                if ($customerQuery) {
                                    if (mysqli_num_rows($customerQuery) > 0) {
                                        $cRowData = mysqli_fetch_assoc($customerQuery);
                            ?>
                                        <table style="width: 100%; margin-bottom: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;" colspan="2">
                                                        <h4 style="font-size: 35px; line-height: 35px; margin: 2px; padding: 0;">J.K Battery Center </h4>
                                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">No:285, Pallimulla, Matara.</p>
                                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">0771852424 | 0711469042 | 0413134034</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Customer Details</h5>
                                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Name: <?= $cRowData['name'] ?> </p>
                                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Phone No: <?= $cRowData['phone'] ?> </p>
                                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Email Id: <?= $cRowData['email'] ?> </p>
                                                    <td align="end">
                                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Invoice Details</h5>
                                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice No: <?= $invoiceNo; ?> </p>
                                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice Date: <?= date('d M Y H:i:s'); ?> </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>

                            <?php
                                    } else {
                                        echo "<h5>No customer data found.</h5>";
                                        return;
                                    }
                                }
                            }
                            $discount = $_SESSION['discount'];

                            ?>
                            <?php
                            if (isset($_SESSION['productItems'])) {
                                $sessionProducts = $_SESSION['productItems'];
                                ?>


                                <div class="table-responsive mb-3">
                                    <table style="width: 100%;" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <th align="start" style="border-bottom: 1px solid #ccc;text-align:left" width="5%">ID</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;text-align:left">Product Name</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;text-align:left" width="12%">Price</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;text-align:left" width="12%">Quantity</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;text-align:left" width="15%">Total Price(Rs.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $totalAmount = 0;
                                            $totalScrap = 0;
                                            foreach ($sessionProducts as $key => $row) :
                                                $totalAmount += $row['price'] * $row['quantity'];
                                            ?>
                                                <tr>
                                                    <td align="start" style="border-bottom: 1px solid #ccc;"><?= $i++ ?></td>
                                                    <td align="start" style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                    <td align="start" style="border-bottom: 1px solid #ccc;"><?= number_format($row['price'], 0) ?></td>
                                                    <td align="start" style="border-bottom: 1px solid #ccc;"><?= $row['quantity']; ?></td>
                                                    <td align="start" style="border-bottom: 1px solid #ccc;" class="fw-bold"><?= number_format($row['price'] * $row['quantity'], 0) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <hr>
                                            <?php
                                                if(isset($_SESSION['retailItems'])){
                                                    $retailItems = $_SESSION['retailItems'];
                                                    foreach ($retailItems as $key => $row1) {
                                                        echo "<tr><td></td><td>".$row1['name']."</td><td>".$row1['price']."</td><td>".$row1['quantity']."</td><td><b>".number_format($row1['price']*$row1['quantity'])."</a></td></tr>";
                                                        $totalAmount += $row1['price'] * $row1['quantity'];
                                                    }
                                                }

                                            ?>

                                            <?php 
                                                if (isset($_SESSION['scrap_items'])){
                                                    $scrapitems = $_SESSION['scrap_items'];

                                                    echo "<tr><th align='start' colspan='5'>Scrap Items(-)</th></tr>";
                                                    echo "<tr><th align='start' colspan='3' style='text-align:left'>Product</th><th style='text-align:left'>Ampier</th><th style='text-align:left'>Discount(Rs.)</th></tr>";
                                                    $y = 0;
                                                    foreach ($scrapitems as $key => $item) {
                                                        $y = $y+1;
                                                        $totalScrap += (int)$item['discount'];
                                                        echo "<tr><td style='border-bottom: 1px solid #ccc;'>".$y."</td><td colspan='2' style='border-bottom: 1px solid #ccc;'>".$item['name']."</td><td style='border-bottom: 1px solid #ccc;'>".$item['amp']."</td><td style='border-bottom: 1px solid #ccc;'>".$item['discount']."</td></tr>";
                                                    }
                                                
                                                }   
                                            ?>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight: bold;">Grand Total:</td>
                                                <td colspan="1" style="font-weight: bold;"><?= number_format($totalAmount, 0) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight: bold;font-size:20px">Discount:</td>
                                                <td colspan="1" style="font-weight: bold;font-size:20px"><?= number_format($discount, 0) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight: bold;font-size:20px">Scrap Discount:</td>
                                                <td colspan="1" style="font-weight: bold;font-size:20px"><?= number_format($totalScrap, 0) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight: bold;font-size:20px">Net Grand Total:</td>
                                                <?php
                                                    $netotal = $totalAmount-$discount-$totalScrap;
                                                
                                                ?>
                                                <td colspan="1" style="font-weight: bold;font-size:20px"><?= number_format($netotal, 0) ?></td>
                                            </tr>
                                            <?php
                                                if($_SESSION['payment_mode']=="Credit"){
                                                    echo "<tr><td colspan='4' style='font-weight: bold;font-size: 20px'>Amount Payed</td><td style='font-weight: bold;font-size: 20px'>".$_SESSION['amount_payed']."</td></tr>";
                                                    echo "<tr><td colspan='4' style='font-weight: bold;font-size: 20px'>Amount Pending</td><td style='font-weight: bold;font-size: 20px'>".number_format($netotal-(int)$_SESSION['amount_payed'])."</td></tr>";
                                                }else if($_SESSION['payment_mode']=="CnO"){
                                                    echo "<tr><td colspan='4' style='font-weight: bold;font-size: 20px'>Cash Amount Payed</td><td style='font-weight: bold;font-size: 20px'>".number_format($_SESSION['online_payed'])."</td></tr>";
                                                    echo "<tr><td colspan='4' style='font-weight: bold;font-size: 20px'>Online Amount Payed</td><td style='font-weight: bold;font-size: 20px'>".number_format($_SESSION['cash_payed'])."</td></tr>";
                                                }
                                            ?>
                                            <tr>
                                                <td colspan="5">Payment Mode: <b><?= $_SESSION['payment_mode'] ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } else {
                                echo '<h5 class="text-center">No ietms added.</h5>';
                            }
                            ?>
                        </div>

                        <?php
                        if (isset($_SESSION['productItems'])) :
                        ?>
                            <div class="mt-4 text-end">
                                <button type="button" id="saveOrder" class="btn btn-primary px-4 mx-1">Save</button>
                               
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>