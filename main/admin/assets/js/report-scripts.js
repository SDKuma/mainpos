async function getreport() {
    var todate = document.getElementById("todate").value;
    var fromdate = document.getElementById("fromdate").value;

    let x = $.ajax({
        type: "POST",
        url: "code.php",
        data: {
            todate: todate,
            fromdate: fromdate,
            getReports: true
        },
        success: async function (response) {
            document.getElementById('getreportid').style.display =await "none";
            document.getElementById('refreshbtn').style.display =await "block";
            var data = JSON.parse(response)['message'];
            const ctx = document.getElementById('myChart');
            let label = [];
            let amount = [];
            for (let i in data) {
                await label.push(data[i]['order_date']);
                await amount.push(Number(data[i]['SUM(net_total)']));
            }
            setTimeout(async () => {

                if (ctx.$chartjs) {
                    ctx.destroy();
                    await new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: label,
                            datasets: [{
                                label: '# of Votes',
                                data: amount,
                                borderWidth: 1,
                                borderColor: '#FF6384',
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
                } else {
                    await new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: label,
                            datasets: [{
                                label: '# of Votes',
                                data: amount,
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
                }

                console.log(2, ctx.$chartjs);

            }, 2000)

            // let res = JSON.parse(response);
            // console.log()
            // console.log(res)
            // if(res['status']){
            //     // window.open(`./return-summary.php?invoice_no=${res['message']}`);
            //     location.reload();
            // }
        },
        error: async function (err) {
            console.log(err)
        }
    });

}