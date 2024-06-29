<?php
include('includes/header.php');
?>
    <style>
    
        .tritemslist {
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px;
            border: 1px gray solid;
            border-radius: 16px;
        }

        .tritemslist:hover {
            box-shadow: 2px 2px 5px 0px;
        }
        
       
    </style>
    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Store Transfers
                        <!--                    <a href="categories.php" class="btn btn-primary float-end">Go Back</a>-->
                    </h4>

                </div>
                <div class="card-body">
                    <?php alertMessage() ?>
                    <!--                    <form action="code.php" method="POST">-->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Store Name *</label>
                            <select name="store_id" id="store_id" class="form-control myselect2" required>
                                <option value="not_defined">Select Product</option>

                                <?php
                                $q = "SELECT * FROM stores";

                                $result = mysqli_query($conn, $q);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "-" . $row["address"] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Item</label>
                            <select name="product_id" id="product_id" class="form-control myselect2" required>
                                <option value="not_defined">Select Product</option>

                                <?php
                                $q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.status='1';";

                                $result = mysqli_query($conn, $q);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "|" . $row['brand'] . "-" . $row['amp'] . "AMP-" . $row['name'] . "'>" . $row['brand'] . "-" . $row['amp'] . "AMP-" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                            <button id="addtritem" class="btn btn-info btn-sm" onclick="addtritem()">Add Item</button>
                            <span id="trf-error" style="color:red;font-size:12px"></span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="name" style="font-weight:bold">Transfer Items</label>
                            <div id="tritems"></div>
                            <hr/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button name="saveStore" class="btn btn-primary" onclick="completetransfer()" >Save</button>
                        </div>
                    </div>
                    <!--                    </form>-->
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="type-table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Store</th>
                                    <th>Comment</th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $q = "SELECT transfers.*,stores.name as store,stores.id as storeid FROM transfers LEFT JOIN stores ON transfers.store_id = stores.id;";
                                $result = mysqli_query($conn, $q);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
//                                    echo "<tr><td>" . $i . "</td><td>" . $row['name'] . "</td><td>" . $row['address'] . "</td><td>" . $row['phone'] . "</td><td><a class='btn btn-info' href=./edittype.php?id=" . $row['id'] . ">Edit</a>&nbsp;<a class='btn btn-danger' href=./deletetype.php?id=" . $row['id'] . ">Delete</a></td></tr>";
                                    echo "<tr><td>".$i."</td><td>".$row['date']."</td><td>".$row['store']."</td><td>".$row['comment']."</td><td><a href='./store-transfer-view.php?id=".$row['id']."&storeid=".$row['storeid']."'> View Details </a></td></tr>";
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