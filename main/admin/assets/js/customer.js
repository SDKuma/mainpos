console.log("customer loaded!!!");
async function viewhistory(id){
    let x = $.ajax({
        type: "POST",
        url: "code.php",
        data: {
            customer: id,
            getHistory: true
        }, success: async function (res) {
            var res = JSON.parse(res);
            var data = res['data'];
            document.getElementById('history-modal').style.display = "block";
            let cus_det = `<h5>${data['customer']['name']}</h5><h5>${data['customer']['phone']}</h5><hr/><p>Total Order Value</p><h2>Rs. ${data['total']}</h2>`;
            document.getElementById("customer-detail").innerHTML = cus_det;
            let orders = data['orders'];
            let html_ = "";
            for(let i in orders){
                html_ += `<tr><td>${orders[i]['id']}</td><td>${orders[i]['order_date']}</td><td>Rs. ${orders[i]['net_total']}</td></tr>`;
            }
            document.getElementById("order-rows-con").innerHTML = html_;
            console.log(data)
        },error:async function (res){
            console.log(res);
        }
    })
}
function close_modal(){
    document.getElementById('history-modal').style.display = "none";
}
