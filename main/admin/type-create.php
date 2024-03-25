<?php
include('includes/header.php');
?>

<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add Type
                    <a href="categories.php" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Brand *</label><br>
                            <select name="brand_id" id="brand_id" class="form-control myselect2" required>
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
                            <label for="name">Category *</label><br>
                            <select name="category_id" id="category_id" class="form-control myselect2" required>
                                <option value="not_defined">Select Product</option>
                               
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Type *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Buying Price *</label>
                            <input type="text" name="buy_price" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Selling Price *</label>
                            <input type="text" name="sell_price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" name="saveType" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="type-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Buying(Rs.)</th>
                                        <th>Selling(Rs.)</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT `type`.*, categories.name as cat, brands.name as brand FROM `type` LEFT JOIN `categories` ON `type`.`category`=`categories`.`id` LEFT JOIN `brands` ON `categories`.`brand_id`=`brands`.`id` WHERE `type`.`status`=1;";
                                        $result = mysqli_query($conn, $q);
                                        while($row =  mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row['id']."</td><td>".$row['brand']."</td><td>".$row['cat']."</td><td>".$row['name']."</td><td>".$row['buying_price']."</td><td>".$row['selling_price']."</td><td><a class='btn btn-info' href=./edittype.php?id=".$row['id'].">Edit</a>&nbsp;<a class='btn btn-danger' href=./deletetype.php?id=".$row['id'].">Delete</a></td></tr>";
                                        }
                                    ?>
                                </tbody>    
                            </table>
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