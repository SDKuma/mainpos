<?php
include('includes/header.php');
?>

<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add Store
<!--                    <a href="categories.php" class="btn btn-primary float-end">Go Back</a>-->
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Store Name *</label>
                            <input type="text" name="name" class="form-control" required>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Store Address*</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Store Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <button type="submit" name="saveStore" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="type-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT * FROM stores";
                                        $result = mysqli_query($conn, $q);
                                        $i = 1;
                                        while($row =  mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$i."</td><td>".$row['name']."</td><td>".$row['address']."</td><td>".$row['phone']."</td><td><a class='btn btn-info' href=./edittype.php?id=".$row['id'].">Edit</a>&nbsp;<a class='btn btn-danger' href=./deletetype.php?id=".$row['id'].">Delete</a></td></tr>";
                                            $i++;
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