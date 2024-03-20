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
                            <label for="category_id">Select Type  *</label>
                            <select name="type_id" id="type_id_prod" class="form-control myselect2" required>
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
                           
                            <input type="hidden" id="category_id" name="category_id" class="form-control">
                            <input type="number" id="buy_prod" name="buyprice" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price">Selling Price *</label>
                            <input type="number" id="by_sell" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3" style="display:none">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Product Barcode *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <br>
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