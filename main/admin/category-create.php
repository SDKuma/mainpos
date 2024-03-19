<?php
include('includes/header.php');
?>

<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add Category
                    <a href="categories.php" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="product_id">Select Brand *</label>
                            <select name="brand_id" class="form-control myselect2" required>
                                <option value="not_defined">Select Product</option>
                                <?php
                                $products = getAll('brands');
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $item) :
                                ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" name="saveCategory" class="btn btn-primary">Save</button>
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