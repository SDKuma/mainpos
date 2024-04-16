<?php
include('includes/header.php');
?>

    <main>
        <div class="container-fluid px-4">
            <br>
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">


                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <canvas id="myChart"></canvas>
                </div>

            </div>
        </div>
    </main>
    <script src="./../admin/assets/js/chart.js" crossorigin="anonymous"></script>

    <script>
        const ctx = document.getElementById('myChart');


        setTimeout(() => {
            getdata();

        }, 2000);

        async function getdata() {
            $.ajax({
                type: 'GET',
                url: 'reportdata.php',
                data: {
                    getReport: true
                },
                success: function (res) {
                    var metadata = JSON.parse(res)

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: metadata[0],
                            datasets: [{
                                label: 'Number of batteries',
                                data: metadata[1],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                },
                error: function (err) {
                    console.log(err);
                }
            });
        }


    </script>
<?php
include('includes/footer.php');
?>