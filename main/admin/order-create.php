<?php
include('includes/header.php');
?>

    <main>
        <div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboards="false" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Customer Name</label>
                            <input type="text" id="c_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone">Customer Phone</label>
                            <input type="text" id="c_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="name">Customer Email (Optional)</label>
                            <input type="email" id="c_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="address">Address (Optional)</label>
                            <textarea name="address" id="c_address" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary saveCustomer">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Create Order
                        <a href="index.php" class="btn btn-primary float-end">Go Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php alertMessage() ?>
                    <form action="orders-code.php" method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="product_id"><b>Select Product *</b></label>
                                <select name="product_id" class="form-control myselect2" required>
                                    <option value="not_defined">Select Product</option>

                                    <?php
                                    $q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE products.status='1';";

                                    $result = mysqli_query($conn, $q);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['brand'] . "-" . $row['amp'] . "AMP-" . $row['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" >
                                <label style="display:none" for="quantity">Quantity *</label>
                                <input type="hidden" name="quantity" class="form-control" value="1">
                            </div>
                            <div class="col-md-3 mb-3 text-end">
                                <br>
                                <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <?php alertMessage() ?>
                    <form action="orders-code.php" method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="product_id"><b>Select Product *</b></label>
                                <select name="retail_product_id" class="form-control myselect2" required>
                                    <option value="not_defined">Select Product</option>

                                    <?php
                                    //$q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id;";
                                    $q = "SELECT * FROM retail_products WHERE status='1';";

                                    $result = mysqli_query($conn, $q);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "-" . $row['type'] . "-" . $row['brand'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" >
                                <label for="quantity">Quantity *</label>
                                <input type="text" name="rettail_quantity" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3 text-end">
                                <br>
                                <button type="submit" name="addRetailItem" class="btn btn-primary">Add Retail Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Products</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['productItems'])) {
                        $sessionProducts = $_SESSION['productItems'];
                        if (empty($sessionProducts)) {
                            unset($_SESSION['productItemIds']);
                            unset($_SESSION['productItems']);
                        }
                        ?>
                        <div class="table-responsive mb-3" id="productArea">
                            <table class="table table-bordered table-striped" id="productContent">
                                <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;

                                foreach ($sessionProducts as $key => $item) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['price'] ?></td>
                                        <td>
                                            <div class="input-group qtyBox">
                                                <input type="hidden" name="product_id"
                                                       value="<?= $item['product_id'] ?>" class="prodId">
                                                <button class="input-group-text decrement">-</button>
                                                <input type="text" value="<?= $item['quantity'] ?>"
                                                       class="qty quantityInput">
                                                <button class="input-group-text increment">+</button>
                                            </div>
                                        </td>
                                        <td><?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                                        <td><a href="order-item-delete.php?index=<?= $key ?>"
                                               class="btn btn-sm btn-danger">Remove</a></td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            <hr>
                            <form action="orders-code.php" method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="forPaymentMode"><b>Scrap Type</b></label>
                                        <select class="form-control" name="mainscrap" id="mainscrap">
                                            <option>Select Scrap</option>
                                            <?php
                                            $query = "SELECT * FROM scrapsmaster";
                                            $scraps = mysqli_query($conn, $query);
                                            foreach ($scraps as $key => $value) {
                                                echo "<option value=" . $value['id'] . "-" . $value['name'] . ">" . $value['name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="forPaymentMode"><b>Scrap weight Type</b></label>
                                        <select class="form-control" id="submain" name="submain">
                                            <option>Select Scrap</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="forPaymentMode"><b>Reduction value</b></label>
                                        <input type="text" placeholder="Discount" id="scrapdiscount"
                                               name="scrapdiscount" class="form-control" value="0"/>
                                    </div>
                                    <div class="col-md-3">
                                        <br>
                                        <button type="submit" class="btn btn-success w-100" id="addScrap"
                                                name="addScrap">ADD SCRAP
                                        </button>
                                    </div>
                                    <table class="table table-stripped">

                                        <?php
                                        if (isset($_SESSION['scrap_items'])) {
                                            $scrapitems = $_SESSION['scrap_items'];
                                            $i = 1;
                                            foreach ($scrapitems as $key => $item) {
                                                echo "<tr><td>" . $i . "</td><td>" . $item['name'] . "</td><td>" . $item['amp'] . "</td><td>" . $item['discount'] . "</td><td><a href='scrap-delete.php?index=" . $key . "' class='btn btn-sm btn-danger'>Remove</a></td></tr>";
                                                $i += 1;
                                            }
                                        }

                                        ?>
                                    </table>
                                </div>
                            </form>
                            <hr/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="forPaymentMode"><b>Discount</b></label>
                                    <input type="number" placeholder="Discount" id="discount" name="discount"
                                           class="form-control" value="0"/>
                                </div>
                            </div>
                            <hr/>
                            <div class="row" id="creditpay" style="display: none">
                                <div class="col-md-4">
                                    <label for="forPaymentMode"><b>Payed Cash</b></label>
                                    <input type="number" placeholder="Cash Pay" id="creditpay_val" name="creditpay_val"
                                           class="form-control" value="0"/>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="forPaymentMode"><b>Select Payment Mode</b></label>
                                    <select class="form-select" id="payment_mode">
                                        <option value="">-- Select Payment --</option>
                                        <option value="Cash Payment">Cash Payment</option>
                                        <option value="Online Payment">Online Payment</option>
                                        <option value="Credit">Credit Payment</option>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="cusNumber"><b>Customer Phone Number</b></label>
                                    <input type="number" id="cphone" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    <button type="button" class="btn btn-warning w-100 proceedToPlace"
                                            id="proceedToPlace">Proceed to place order
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "<h5>No item added.</h5>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>

<?php
include('includes/footer.php');
?>