<?php
    include('includes/header.php');
    $trid = $_GET["id"];
    $storeid = $_GET["id"];
    
    $trq = "SELECT * FROM transfers WHERE id=".$trid.";";
    $trresult = mysqli_query($conn, $trq);
    $trrow = mysqli_fetch_assoc($trresult);

    $sq = "SELECT * FROM stores WHERE id=".$storeid.";";
    $sresult = mysqli_query($conn, $sq);
    $srow = mysqli_fetch_assoc($sresult);


?>
    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Store Transfer Items</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">            
                                <tr>
                                    <td>Store Name</td>
                                    <th><?php echo $srow["name"]; ?></th>
                                    <td>Transfer Date</td>
                                    <th><?php echo $trrow["date"]; ?></th>

                                </tr>    
                            </table>
                        </div>    
                        <hr/>
                        <div class="col-md-12">
                            <table class="table" id="type-table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Item</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $q = "SELECT tr_items.prod_id,products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM tr_items LEFT JOIN products ON tr_items.prod_id = products.id  LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE tr_items.trans_id = ".$trid."; ";
                                    $result = mysqli_query($conn, $q); 
                                    $i = 1;     
                                    while ($row = mysqli_fetch_assoc($result)) {
                                       echo "<tr><td>".$i."</td><td>" . $row['brand'] . "-" . $row['amp'] . "AMP-" . $row['name'] . "</td></tr>";
                                       $i++;
                                    } 
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
include('includes/footer.php');
?>