<?php include('includes/header.php'); ?>

    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="mb-0">Print Order
                                <a href="orders.php" class="btn btn-danger float-end">Go Back</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php alertMessage(); ?>
                            <div id="myBillingArea">
                                <?php
                                if (isset($_GET['track'])) {
                                    if ($_GET['track'] == "") {
                                        echo '<div class="text-center py-5"><h5>No tracking number found!</h5><div><a href="orders.php" class="btn btn-primary">Go back to orders</a></div></div>';
                                    } else {
                                        $trackingNo = validate($_GET['track']);
                                        //getting main details
                                        $orderquery = "SELECT orders.*,customers.name,customers.email,customers.phone,customers.address FROM `orders` LEFT JOIN `customers` ON orders.customer_id = customers.id WHERE orders.id = '" . $trackingNo . "' LIMIT 1;";
                                        $result = mysqli_query($conn, $orderquery);
                                        $order = mysqli_fetch_assoc($result);
                                        $orderId = $order['id'];
                                        $discount = $order['discount'];
                                        $scrapdiscount = $order['on_scrap_discount'];
                                        $netTotal = $order['net_total'];
                                        echo '<table style="width: 100%; margin-bottom: 20px;"><tbody><tr><td style="text-align: center;" colspan="2"><h4 style="font-size: 35px; line-height: 30px; margin: 2px; padding: 0;">J.K.Battery Center </h4><p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">No:285,Pallimulla,Matara.</p> <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">0771852424 | 0711469042 | 0413134034</p></td></tr><tr><td> <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Customer Details</h5><p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Name:' . $order['name'] . '</p><p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Phone:' . $order['phone'] . ' </p> <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Email Id:' . $order['email'] . '</p></td><td align="end" style="align-content: end;text-align: right"> <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Invoice Details</h5><p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice No:' . $order['invoice_no'] . '</p> <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice Date: ' . $order["order_date"] . ' </p><p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Address:No:285,Pallimulla,Matara.</p></td></tr></tbody></table>';

                                        $itemsquery = "SELECT * FROM order_items WHERE order_id ='" . $orderId . "';";
                                        $itemsresult = mysqli_query($conn, $itemsquery);
                                        echo ' <div class="table-responsive mb-3"> <table style="width: 100%;" cellpadding="5"> <thead><tr><th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th><th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th> <th align="start" style="border-bottom: 1px solid #ccc;" width="12%">Price</th><th align="start" style="border-bottom: 1px solid #ccc;" width="12%">Quantity</th><th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th></tr>';
                                        $i = 1;
                                        while ($orderitem = mysqli_fetch_assoc($itemsresult)) {
                                            $itemsquery = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.id='" . $orderitem['product_id'] . "' LIMIT 1;";
                                            $itemresult = mysqli_query($conn, $itemsquery);
                                            $row = mysqli_fetch_assoc($itemresult);
                                            if($row){
                                                echo '<tr><td align="start" style="border-bottom: 1px solid #ccc;">' . $i . '</td><td align="start" style="border-bottom: 1px solid #ccc;">' . $row['brand'] . ' ' . $row['type_'] . ' ' . $row['amp'] . '<br>' . $row['name'] . '</td> <td align="start" style="border-bottom: 1px solid #ccc;">Rs. ' . number_format($orderitem['price']) . '</td><td align="start" style="border-bottom: 1px solid #ccc;">' . $orderitem['quantity'] . '</td><td  align="start" style="border-bottom: 1px solid #ccc;" class="fw-bold">Rs. ' . number_format($orderitem['quantity'] * $orderitem['price']) . '</td></tr>';
                                            }else{
                                                echo 'No Item found';
                                            }
                                            //echo '<tr><td align="start" style="border-bottom: 1px solid #ccc;">' . $i . '</td><td align="start" style="border-bottom: 1px solid #ccc;">' . $row['brand'] . ' ' . $row['type_'] . ' ' . $row['amp'] . '<br>' . $row['name'] . '</td> <td align="start" style="border-bottom: 1px solid #ccc;">Rs. ' . number_format($orderitem['price']) . '</td><td align="start" style="border-bottom: 1px solid #ccc;">' . $orderitem['quantity'] . '</td><td  align="start" style="border-bottom: 1px solid #ccc;" class="fw-bold">Rs. ' . number_format($orderitem['quantity'] * $orderitem['price']) . '</td></tr>';
                                            $i++;
                                        }
                                        $retail = "SELECT * FROM order_retail WHERE order_id ='" . $orderId . "';";
                                        $retailresult = mysqli_query($conn, $retail);
                                        $y = 1;
                                        $rowscount = mysqli_num_rows($retailresult);
                                        if($rowscount > 0){
                                            echo "<tr><td colspan='5'><b>Retail Items</b></td>tr>";
                                        }

                                        while ($item = mysqli_fetch_assoc($retailresult)){
                                            $retailProd = "SELECT * FROM retail_products WHERE id='" . $item['product_id'] . "';";
                                            $retailProdresult = mysqli_query($conn, $retailProd);
                                            $row1 = mysqli_fetch_assoc($retailProdresult);
                                            echo "<tr><td>".$y."</td><td>".$row1['name']."<br>".$row1['brand']."</td><td>".$item['price']."</td><td>".$item['quantity']."</td><td><b>".number_format($item['price']*$item['quantity'])."</b></td></tr>";
                                            $y++;
                                        }

                                        $scrapq = "SELECT * FROM order_scrap WHERE order_id ='" . $orderId . "';";
                                        $scrapresult = mysqli_query($conn, $scrapq);
                                        echo "<tr><td colspan='5'><br/></td></tr>";
                                        echo "<tr><td colspan='5'><b>Scraps</b></td></tr>";
                                        $a = 1;
                                        while ($row2 = mysqli_fetch_assoc($scrapresult)){
                                            echo "<tr><td>".$a."</td><td colspan='2'>".$row2["scrapname"]."</td><td>".$row2["amp"]."</td><td>".$row2["discount"]."</td></tr>";
                                            $a++;
                                        }


                                        echo "<tr><td colspan='4'  style='font-weight: bold;'>Grand Total:</td><td style='font-weight: bold;font-size:20px'>Rs." . number_format($order['total_amount']) . "</td></tr>";
                                        echo "<tr><td colspan='4'  style='font-weight: bold;'>Discount:</td><td style='font-weight: bold;font-size:20px'>Rs." . number_format($order['discount']) . "</td></tr>";
                                        echo "<tr><td colspan='4'  style='font-weight: bold;'>Scrap Discount:</td><td style='font-weight: bold;font-size:20px'>Rs." . number_format($order['on_scrap_discount']) . "</td></tr>";
                                        echo "<tr><td colspan='4'  style='font-weight: bold;'>Net Grand Total:</td><td style='font-weight: bold;font-size:20px'>Rs. " . number_format($order['net_total']) . "</td></tr>";
                                        echo "<tr><td colspan='5'>Payment type".$order['payment_mode']."</td></tr>";
                                        echo '</table> </div>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="mt-4 text-end">
                                <button class="btn btn-info px-4 mx-1" onclick="printBillingArea()">Print</button>
                                <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF()">Download PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

<?php include('includes/footer.php'); ?>