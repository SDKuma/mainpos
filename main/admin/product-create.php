<?php
include('includes/header.php');
?>

<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add Product
                    <a href="products.php" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="category_id">Select Category *</label>
                            <select name="category_id" class="form-control" required>
                                <option value="not_defined">Select category</option>
                                <?php
                                $categories = getAll('categories');
                                if (mysqli_num_rows($categories) > 0) {
                                    foreach ($categories as $item) :
                                ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="category_id">Select Brand *</label>
                            <select name="brand_id" class="form-control" required>
                                <option value="not_defined">Select Brand</option>
                                <?php
                                $brands = getAll('brands');
                                if (mysqli_num_rows($brands) > 0) {
                                    foreach ($brands as $item) :
                                ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="category_id">Select Type *</label>
                            <select name="type_id" class="form-control" required>
                                <option value="not_defined">Select Type</option>
                                <?php
                                $types = getAll('type');
                                if (mysqli_num_rows($types) > 0) {
                                    foreach ($types as $item) :
                                ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price">Buying Price *</label>
                            <input type="number" name="buyprice" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price">Selling Price *</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <!-- <label for="quantity">Quantity *</label> -->
                            <input type="hidden" name="quantity" class="form-control" value=1>
                        </div>
                        <div class="col-md-4 mb-3" style="display:none">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="name">Product Barcode *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status (Unchecked = Visible; Checked=Hidden)</label>
                            <br>
                            <input type="checkbox" name="status" style="width: 30px; height:30px;">
                        </div>
                        <div class="col-md-6 mb-3 text-end">
                            <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include('includes/footer.php');
?>