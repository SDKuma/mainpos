<?php
include('includes/header.php');
?>
<style>
    ul{
        list-style-type: none;
    }
    .items{
        background-color: lightgray;
        margin: 10px;
        padding: 10px;

    }
</style
<main>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Retail Add Product</h4>
            </div>
            <div class="card-body">
                <?php alertMessage() ?>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="category_id">Invoice Number</label>
                        <input name="orderinvoice" id="orderinvoice" class="form-control"/>
                        <br/>
                        <button class="btn btn-success btn-sm" onclick="getinvoiceitems()">Get Items</button>
                    </div>
                    <div class="col-md-8 mb-3">
                        <div id="items-con">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include('includes/footer.php');
?>
