<?php
include('includes/header.php');
$typeid= $_GET['id'];
$q = "SELECT * FROM `type` WHERE id = ".$typeid."";
$res =  mysqli_query($conn, $q);
$data = mysqli_fetch_assoc($res);

?>

<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Edit Type
                    <a href="categories.php" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="name">Type *</label>
                            <input type="hidden" name="typeid" class="form-control" value="<?php echo $data['id']; ?>">
                            <input type="text" name="editname" class="form-control" value="<?php echo $data['name']; ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name">Amp</label>
                            <input type="text" name="amp" class="form-control" value="<?php echo $data['amp']; ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name">Buying Price *</label>
                            <input type="text" name="buy_price" class="form-control" value="<?php echo $data['buying_price']; ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name">Selling Price *</label>
                            <input type="text" name="sell_price" class="form-control" value="<?php echo $data['selling_price']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" name="updateType" class="btn btn-primary">Update</button>
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