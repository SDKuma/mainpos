<?php
include('includes/header.php');
?>

<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add Scrap
                    <a href="#" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Name *</label>
                            <input type="text" name="scrap" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Rate Category</label>
                            <select name="rateid" class="form-control myselect2">
                                <option value="0">Select Category</option>
                            <?php
                                $scraps = getAll('scrap_rate');
                                if (mysqli_num_rows($scraps) > 0) {
                                    foreach($scraps as $scrap){
                                        echo "<option value=".$scrap['id'].">".$scrap['rateType']."</option>";
                                    }
                                }   
                            ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <br>
                            <button type="submit" name="saveScrap" class="btn btn-primary">Save</button>
                        </div>
                        <div class="col-md-6">
                            <table class="table" style="border:1px solid black">
                                <tr>
                                    <td></td>
                                    <th>Scrap Type</th>
                                    <th>Rate Type</th>
                                </tr>
                                <?php
                                    $scraps = getAll('scrapsmaster');
                                    if (mysqli_num_rows($scraps) > 0) {
                                        foreach($scraps as $scrap){
                                            if((int)$scrap['rate_type']==1){
                                                $lable = "Main";
                                            }else{
                                                $lable = "Bike";
                                            }

                                            echo "<tr><td></td><td>".$scrap['name']."</td><td>".$lable."</td></tr>";
                                        }
                                    } 
                                ?>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add Scrap Category
                    <a href="#" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                    <div class="col-md-4 mb-3">
                            <label for="name">Scrap</label>
                            <select name="scrap" class="form-control myselect2">
                                <option value="0">Select Scrap</option>
                            <?php
                                $scraps = getAll('scrapsmaster');
                                if (mysqli_num_rows($scraps) > 0) {
                                    foreach($scraps as $scrap){
                                        echo "<option value=".$scrap['id'].">".$scrap['name']."</option>";
                                    }
                                }   
                            ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Name *</label>
                            <input type="text" name="subname" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Weight *</label>
                            <input type="text" name="weight" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <br>
                            <button type="submit" name="saveSubScrap" class="btn btn-primary">Save</button>
                        </div>
                        <div class="col-md-12">
                            <div style="">
                            <table class="" style="border:1px solid black" id="scrap-table">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>Main Scrap</th>
                                    <th>Name</th>
                                    <th>Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $scraps = getAll('scrap_weights');
                                    if (mysqli_num_rows($scraps) > 0) {
                                        foreach($scraps as $scrap){
                                            if((int)$scrap['scrap_id']==1){
                                                $lable = "H";
                                            }else if((int)$scrap['scrap_id']==2){
                                                $lable = "IM";
                                            }else{
                                                $lable = "2W";
                                            }

                                            echo "<tr><td>".$scrap['id']."</td><td>".$lable."</td><td>".$scrap['name']."</td><td>".$scrap['weight']."</td></tr>";
                                        }
                                    } 
                                ?>
                            </tbody>
                            </table>
                            </div>    
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Scrap Rate
                    <a href="categories.php" class="btn btn-primary float-end">Go Back</a>
                </h4>

            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <form action="code.php" method="POST">
                    <div class="row">
                    <div class="col-md-4 mb-3">
                            <label for="name">Rate Category</label>
                            <select name="rateid" class="form-control myselect2">
                                <option value="0">Select Category</option>
                            <?php
                                $scraps = getAll('scrap_rate');
                                if (mysqli_num_rows($scraps) > 0) {
                                    foreach($scraps as $scrap){
                                        echo "<option value=".$scrap['id'].">".$scrap['rateType']."</option>";
                                    }
                                }   
                            ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Rate(Rs.) *</label>
                            <input type="text" name="rate" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <br>
                            <button type="submit" name="updateRate" class="btn btn-primary">Save</button>
                        </div>
                        <div class="col-md-6 mb-3">
                           <table class="table" style="border:1px solid black">
                                <tr>
                                    <td></td>
                                    <th>Type</th>
                                    <th>Rate</th>
                                </tr>
                                <?php
                                    $scraps = getAll('scrap_rate');
                                    if (mysqli_num_rows($scraps) > 0) {
                                        foreach($scraps as $scrap){
                                            echo "<tr><td></td><td>".$scrap['rateType']."</td><td>".$scrap['rate_']."</td></tr>";
                                        }
                                    } 
                                ?>
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