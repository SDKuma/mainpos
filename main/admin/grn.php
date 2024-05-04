<?php
include('includes/header.php');
?>
<style>
    ul {
        list-style-type: none;
    }

    .items {
        background-color: lightgray;
        margin: 10px;
        padding: 10px;

    }
</style
<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Item Return Note</h4>
            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="category_id">Invoice Number</label>
                        <input name="orderinvoice" id="orderinvoice" class="form-control"/>
                        <br/>
                        <button class="btn btn-success btn-sm" onclick="getinvoiceitems()">Get Items</button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div id="items-con">

                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <div id="items-con">
                            <label for="product_id"><b>Select Product *</b></label>
                            <select name="product_id" class="form-control myselect2" required id="product_id">
                                <option value="not_defined">Select Product</option>

                                <?php
                                $q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.quantity!='0';";

                                $result = mysqli_query($conn, $q);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['brand'] . "-" . $row['amp'] . "AMP-" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="product"><b>Return reason</b></label>
                            <textarea class="form-control" id="reason"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button id="genreturn" class="btn btn-warning btn-sm" onclick="genreturns()">Generate Return
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Item Returns</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="product-table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Returned Invoice</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `returns` ORDER BY `id` DESC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td>".$row['id']."</td><td>".$row['invoice']."</td><td><a href='./return-summary.php?invoice_no=".$row['invoice']."'>View</td></tr>";
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
