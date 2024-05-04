<?php
include('includes/header.php');
date_default_timezone_set('Asia/Colombo');
?>

    <div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboards="false" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mb-3 p-4">
                        <h5 id="orderPlaceSuccess">Return Note Created...</h5>
                    </div>
                    <a href="grn.php" class="btn btn-secondary">Close</a>
                    <a href="orders-view-print.php" class="btn btn-danger" onclick="printBillingArea()">Print</a>

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
                            <h4 class="mb-0">Return Summary
<!--                            <a href="order-create.php" class="btn btn-danger float-end">Back to create order</a>-->
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php

                            if(isset($_GET['recid'])){
                                $invoice_no = $_GET['recid'];
                                $querystr = "SELECT * FROM `returns` WHERE id= '".$invoice_no."';";
                                $result = mysqli_query($conn, $querystr);
                                $headdetails = mysqli_fetch_assoc($result);
                            }else{
                                $querystr = "SELECT * FROM `returns` ORDER BY id DESC LIMIT 1;";
                                $result = mysqli_query($conn, $querystr);
                                $headdetails = mysqli_fetch_assoc($result);
                                $invoice_no = $headdetails['id'];
                            }



                            $oldbattery = $headdetails['received_item'];
                            $newattery = $headdetails['released_item'];
                            $reason = $headdetails['return_comment'];
                            $date = $headdetails['tr_date'];

//                            $oldbatdet = "SELECT products.name,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.id='" . $oldbattery . "';";
//                            $olddetails = mysqli_query($conn, $oldbatdet);
//                            $olddetails_ = mysqli_fetch_assoc($olddetails);

                            $newbatdet = "SELECT products.name,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.id='" . $newattery . "';";
                            $newdetails = mysqli_query($conn, $newbatdet);
                            $newdetails_ = mysqli_fetch_assoc($newdetails);
                            ?>
                            <div id="myBillingArea">
                                <table style="width: 100%; margin-bottom: 20px;">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: center;" colspan="2">
                                            <h4 style="font-size: 35px; line-height: 35px; margin: 2px; padding: 0;">J.K
                                                Battery Center </h4>
                                            <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">
                                                No:285, Pallimulla, Matara.</p>
                                            <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">
                                                0771852424 | 0711469042 | 0413134034</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                        <td align="end">
                                            <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">
                                               Return Item Note</h5>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">
                                                Invoice No: <?php echo "return-00".$invoice_no; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">
                                                Return Note Date: <?= date('d M Y H:i:s'); ?> </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="table-responsive mb-3">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td>
                                                <?php
                                                echo "Return reason : ".$reason;
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 align="left">Returned Battery</h4>
                                                <hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                    echo "<h5>".$oldbattery."</h5>";
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 align="left">Released Battery</h4>
                                                <hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<h5>".$newdetails_["brand"]." ".$newdetails_["cat"]." ".$newdetails_["type_"]."</h5>".$newdetails_['name'];
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        setTimeout(async ()=>{
            launchmodal();

        },1000);

    </script>
<?php include('includes/footer.php'); ?>