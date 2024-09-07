<?php
include('includes/header.php');
?>
<?php
$query = "SELECT type.id as id, type.name as typename,type.tbatch,categories.name as catname,brands.name as brname FROM type JOIN categories ON categories.id = type.category JOIN brands ON brands.id = categories.brand_id;";
$result = mysqli_query($conn, $query);
$typearr = array();
while ($row = mysqli_fetch_assoc($result)) {
    $countquery = "SELECT count(*) as count FROM products WHERE `Type` = '" . $row['id'] . "' AND quantity > 0;";
    $res = mysqli_query($conn, $countquery);
    $count = mysqli_fetch_assoc($res);
    $item = array("type" => $row['typename'], "category" => $row['catname'], "brand" => $row['brname'], "batch" => $row['tbatch'], "quantity" => $count['count']);
    array_push($typearr, $item);
}

?>
    <main>
        <div class="container-fluid px-4">

            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Stock Report
                        <a href="#" class="btn btn-primary float-end"></a>
                    </h4>
                </div>
                <div class="card-body">
                    <div>
                        <table id="orderstable1">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Type / Batch</th>
                                <th>Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($typearr as $type) {
                                echo "<tr><td>".$i."</td><td>".$type['brand']."</td><td>".$type['category']."</td><td>".$type['type']." / ".$type['batch']. "</td><td>".$type['quantity']."</td></tr>";
                                $i++;
                            }

                            ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

<?php
include('includes/footer.php');
?>