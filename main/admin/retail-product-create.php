<?php
include('includes/header.php');
?>

    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Retail Add Product

                    </h4>

                </div>
                <div class="card-body">
                    <?php alertMessage() ?>
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="category_id">Item Brand</label>
                                <input name="retailbrand" id="retailbrand" class="form-control"/>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category_id">Item Name</label>
                                <input name="retailitemname" id="retailitemname" class="form-control"/>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category_id">Item type</label>
                                <input name="retailitemtype" id="retailitemtype" class="form-control"/>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price">Buying Price *</label>
                                <input type="number" id="retailbuy_prod" name="retailbuyprice" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price">Selling Price *</label>
                                <input type="number" id="retailby_sell" name="retailprice" class="form-control"
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="name">Quantity</label>
                                <input type="text" id="retailqty" name="retailqty" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name">Unit Size</label>
                                <input type="text" id="retailunitsize" name="retailunitsize" class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <br>
                                <button type="submit" onclick="" name="saveRetailProduct" id="saveRetailProduct"
                                        class="btn btn-primary">Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Products

                    </h4>

                </div>
                <div class="card-body">
                    <?php alertMessage() ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="product-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Buying Price(Rs)</th>
                                <th>Selling Price(Rs)</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // $q = "SELECT `products`.*,`brands`.`name` as 'brand',`type`.`name` as 'type_' FROM products LEFT JOIN `brands` ON `products`.`Brand`=`brands`.`id` LEFT JOIN `type` ON `type`.`id`=`products`.`Type`;";
                            //$q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id;";
                            $q = "SELECT * FROM retail_products WHERE status = 1;";
                            $result = mysqli_query($conn, $q);
                            while ($row = mysqli_fetch_assoc($result)) {
//                                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['brand'] . "</td><td>" . $row['name'] . "-" . $row['type'] . "</td><td>" . $row['price'] . "</td><td>" . $row['price'] . "</td><td>" . $row['quantity'] . "</td><td><a href=product-edit.php?id=" . $row['id'] . " class='btn btn-sm btn-success'>Edit</a>
//                                    <a href=product-delete.php?id=" . $row['id'] . " class='btn btn-sm btn-danger'>Delete</a></td></tr>";
                                echo "<tr><td>".$row['id']."</td><td>".$row['brand']."</td><td>".$row['name']."</td><td>".$row['type']."</td><td>".$row['buy_price']."</td><td>".$row['price']."</td><td>".$row['qty']."</td><td>".$row['unit']."</td><td><a href=retail-product-delete.php?id=" . $row['id'] . " class='btn btn-sm btn-danger'>Delete</a> <a href=retail-product-edit.php?id=" . $row['id'] . " class='btn btn-sm btn-info'>Edit</a></td></tr>";
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

    </script>
<?php
include('includes/footer.php');
?>