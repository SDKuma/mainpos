<?php
include('includes/header.php');
?>

    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">
                        Date wise sales
                    </h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-3">
                        <label for="name">From</label>
                        <input class="form-control" type="date" name="fromdate" id="fromdate"/>
                    </div>
                    <div class="col-md-3">
                        <label for="name">to</label>
                        <input class="form-control" type="date" name="todate" id="todate"/>
                        <br/>
                        <button class="btn btn-primary" onclick="getreport()" id="getreportid">Get Data</button>
                        <button class="btn btn-primary" onclick="location.reload()" id="refreshbtn" style="display: none">Refresh</button>
                    </div>
                    <div class="col-md-3">
                        Income Total
                        <h1 id="completeamount"></h1>
                    </div>
                </div>
            </div>
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Detailed Chart
                        <a href="#" class="btn btn-primary float-end"></a>
                    </h4>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </main>

<?php
include('includes/footer.php');
?>