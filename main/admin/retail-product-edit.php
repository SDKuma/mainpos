<?php
include('includes/header.php');

$id = $_GET['id'];
$q ="SELECT * FROM retail_products WHERE id=".$id." LIMIT 1;";
$result = mysqli_query($conn,$q);
$row = mysqli_fetch_array($result);

?>

    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Update Retail Product

                    </h4>

                </div>
                <div class="card-body">
                    <?php alertMessage() ?>
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="category_id">Item Brand</label>
                                <input name="id" id="id" class="form-control" type="hidden" value=<?php echo $id; ?> />
                                <input name="retailbrand" id="retailbrand" class="form-control" value=<?php echo $row['brand']; ?> />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category_id">Item Name</label>
                                <input name="retailitemname" id="retailitemname" class="form-control" value=<?php echo $row['name']; ?> />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category_id">Item type</label>
                                <input name="retailitemtype" id="retailitemtype" class="form-control" value=<?php echo $row['type']; ?> />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price">Buying Price *</label>
                                <input type="number" id="retailbuy_prod" name="retailbuyprice" class="form-control" value=<?php echo $row['buy_price']; ?> />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price">Selling Price *</label>
                                <input type="number" id="retailby_sell" name="retailprice" class="form-control" value=<?php echo $row['price']; ?> required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="name">Quantity</label>
                                <input type="text" id="retailqty" name="retailqty" class="form-control" value=<?php echo $row['qty']; ?> required>
                                <input type="hidden"  name="oldretailqty" class="form-control" value=<?php echo $row['qty']; ?>>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name">Unit Size</label>
                                <input type="text" id="retailunitsize" name="retailunitsize" class="form-control" value=<?php echo $row['unit']; ?> required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <br>
                                <button type="submit" onclick="" name="updateRetailProduct" id="UpdateRetailProduct"
                                        class="btn btn-primary">Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <script>

    </script>
<?php
include('includes/footer.php');
?>