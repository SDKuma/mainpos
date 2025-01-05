async function getprofit() {
    // var todate = document.getElementById("fromdate").value;
    var fromdate = document.getElementById("fromdate").value;
    let x = $.ajax({
            type: "POST",
            url: "code.php",
            data: {
                fromdate: fromdate,
                getProfit: true
            }, success: async function (response) {
            console.log(response);
                var data = JSON.parse(response)['message'];
                var profit = Number(data['profit'])-Number(data['discount']);
                document.getElementById("completeamount").innerText = `Rs.${profit}`;
                let pro_rows = data["datarows"];
                let tot_profit = 0;
                let tb_html = `<table width="100%" calss="table"><tr style="font-size: 20px;font-weight: bold;background-color: lightgray;"><td></td><td>Item</td><td>Selling</td><td>Buying</td><td>Profit</td></tr>`;
                for(let i in pro_rows){
                    var profit = Number(pro_rows[i]['selling']) - Number(pro_rows[i]['buying']);
                    tot_profit +=profit;
                    tb_html +=`<tr><td></td><td>${pro_rows[i]['item']}</td><td>Rs. ${pro_rows[i]['selling']}</td><td>Rs. ${pro_rows[i]['buying']}</td><td>Rs.${profit}</td></tr>`;
                }
                tb_html +=`<tr style="font-size: 20px;font-weight: bold;background-color: lightgray;"><td colspan="4">Total Profit Before Discount</td><td>Rs. ${tot_profit}</td></tr></table>`;
                document.getElementById("profit-table").innerHTML = tb_html;
            },
        error: async function (err) {
        console.log(err)
    }
        }
    );
}


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
            document.getElementById('getreportid').style.display = await "none";
            document.getElementById('refreshbtn').style.display = await "block";
            var data = JSON.parse(response)['message'];
            const ctx = document.getElementById('myChart');
            let label = [];
            let amount = [];
            let total = 0
            for (let i in data) {
                await label.push(data[i]['order_date']);
                await amount.push(Number(data[i]['SUM(net_total)']));
                total += (Number(data[i]['SUM(net_total)']));
                console.log(total);
            }
            document.getElementById("completeamount").innerText = "Rs." + total;
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