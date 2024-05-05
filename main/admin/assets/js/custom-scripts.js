$(document).ready(function () {
    alertify.set("notifier", "position", "top-right");

    //
    $(document).on("click", ".increment", function () {
        var $quantityInput = $(this).closest(".qtyBox").find(".qty");
        var $product_id = $(this).closest(".qtyBox").find(".prodId").val();
        var currentValue = parseInt($quantityInput.val());

        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            quantityIncDec($product_id, qtyVal);
        }
    });

    //
    $(document).on("click", ".decrement", function () {
        var $quantityInput = $(this).closest(".qtyBox").find(".qty");
        var $product_id = $(this).closest(".qtyBox").find(".prodId").val();
        var currentValue = parseInt($quantityInput.val());

        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            $quantityInput.val(qtyVal);
            quantityIncDec($product_id, qtyVal);
        }
    });

    //
    function quantityIncDec(prodId, qty) {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                productIncdec: true,
                product_id: prodId,
                quantity: qty,
            },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == 200) {
                    // window.location.reload();
                    // To reload specific area
                    $("#productArea").load(" #productContent");
                    alertify.success(res.message);
                } else {
                    $("#productArea").load(" #productContent");
                    alertify.error(res.message);
                }
            },
        });
    }

    function hidealldivs() {
        document.getElementById("creditpay").style.display = "none";
        document.getElementById("cnopay").style.display = "none";
        document.getElementById("cncpay").style.display = "none";
    }

    $(document).on("change", "#payment_mode", async function () {
        let ele = document.getElementById("payment_mode").value;
        console.log(ele)
        await hidealldivs();
        if (ele == "Credit") {
            document.getElementById("creditpay").style.display = "block";
        } else if (ele == "CnO") {
            document.getElementById("cnopay").style.display = "block";
            document.getElementById("creditpay_val").value = 0;
        } else if (ele == "CnC") {

            document.getElementById("cncpay").style.display = "block";
            document.getElementById("creditpay_val").value = 0;
        } else {

        }
    })

    //settle bill

    // Procced to place order button click
    $(document).on("click", ".proceedToPlace", function () {
        var payment_mode = $("#payment_mode").val();
        var cphone = $("#cphone").val();
        var discount = $("#discount").val();
        var amount_payed = $("#creditpay_val").val();
        var cash_payed = $("#cashpay_val").val();
        var online_payed = $("#onlinepay_val").val();
        var cnccash = $("#cnc_cashpay_val").val();
        var cnccard = $("#cardpay_val").val();

        if (payment_mode == "") {
            swal("Select Payment Mode", "Please select your payment mode", "warning");
            return false;
        }

        if (cphone == "" && !$.isNumeric(cphone)) {
            swal(
                "Enter Phone Number",
                "Please enter a valid phone number",
                "warning"
            );
            return false;
        }

        var data = {
            proccedToPlaceBtn: true,
            payment_mode: payment_mode,
            cphone: cphone,
            discount: discount,
            amount_payed: amount_payed,
            online_payed: online_payed,
            cash_payed: cash_payed,
            cnccash: cnccash,
            cnccard: cnccard
        };
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == 200) {
                    window.location.href = "order-summary.php";
                } else if (res.status == 404) {
                    swal("Customer not found.", res.message, res.status_type, {
                        buttons: {
                            catch: {
                                text: "Add Customer",
                                value: "catch",
                            },
                            cancel: "Cancel",
                        },
                    }).then((value) => {
                        switch (value) {
                            case "catch":
                                // console.log("Modal");
                                $("#c_phone").val(cphone);
                                $("#addCustomerModal").modal("show");
                                break;
                            default:
                        }
                    });
                } else {
                    swal("Something went wrong", res.message, res.status_type);
                }
            },
        });
    });

    $(document).on("change", "#mainscrap", function () {
        var id = document.getElementById("mainscrap").value;
        var data = {
            id: id,
            getSubScrap: true
        };
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {
                var res = JSON.parse(response);
                var items = res['message'];
                console.log(items);
                var html = "";
                for (let i in items) {
                    html += `<option value='${items[i]['id']}-${items[i]['name']}'>${items[i]['name']}</option>`;
                }
                document.getElementById("submain").innerHTML = html;
            },
        });
    });

    $(document).on("change", "#brand_id", function () {
        var id = document.getElementById("brand_id").value;
        var data = {
            id: id,
            getCategoryOpt: true
        };
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {
                var res = JSON.parse(response);
                var items = res['message'];
                console.log(items);
                var html = "";
                for (let i in items) {
                    html += `<option value='${items[i]['id']}'>${items[i]['name']}</option>`;
                }
                document.getElementById("category_id").innerHTML = html;
            },
        });
    });

    $(document).on("change", "#type_id_prod", function () {
        var id = document.getElementById("type_id_prod").value;
        var data = {
            id: id,
            getTypePrice: true
        };
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {
                var res = JSON.parse(response);
                var items = res['message'];
                console.log(items[0]);
                if (items[0]) {
                    document.getElementById('buy_prod').value = items[0]['buying_price'];
                    document.getElementById('by_sell').value = items[0]['selling_price'];
                    document.getElementById('category_id').value = items[0]['category'];

                }
            },
        });
    });


    // Add customer to customer's table
    $(document).on("click", ".saveCustomer", function () {
        var c_name = $("#c_name").val();
        var c_phone = $("#c_phone").val();
        var c_email = $("#c_email").val();
        var c_address = $("#c_address").val();

        if (c_name != "" && c_phone != "") {
            if ($.isNumeric(c_phone)) {
                var data = {
                    saveCustomerBtn: true,
                    name: c_name,
                    phone: c_phone,
                    email: c_email,
                    address: c_address,
                };

                $.ajax({
                    type: "POST",
                    url: "orders-code.php",
                    data: data,
                    success: function (response) {
                        var res = JSON.parse(response);
                        if (res.status == 200) {
                            swal("", res.message, res.status_type);
                            $("#addCustomerModal").modal("hide");
                        } else if (res.status == 500) {
                            swal("Something went wrong.", res.message, res.status_type);
                        } else {
                            swal("Something went wrong.", res.message, res.status_type);
                        }
                    },
                });
            } else {
                swal("Enter valid phone number", "", "warning");
            }
        } else {
            swal("Please fill the required fields", "", "warning");
        }
    });

    // On customer's order save
    $(document).on("click", "#saveOrder", async function () {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                saveOrder: true,
            },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == 200) {
                    swal(res.message, res.message, res.status_type);
                    $("#orderPlaceSuccess").text(res.message);
                    $("#orderSuccessModal").modal("show");
                    // printBillingArea();
                    // window.location.replace('http://localhost/mainpos/main/admin/order-create.php');
                } else {
                    swal(res.message, res.message, res.status_type);
                }
            },
        });
    });
});

// Print billing area
function printBillingArea() {
    var divContents = document.getElementById("myBillingArea").innerHTML;
    var a = window.open("", "");
    a.document.write("<html><title>POS System in PHP</title>");
    a.document.write('<body style="font-family: fangsong;">');
    a.document.write(divContents);
    a.document.write("</body</html>");
    a.document.close();
    a.print();
}

// Downlaod pdf
window.jsPDF = window.jspdf.jsPDF;
var docPDF = new jsPDF();

function downloadPDF(invoiceNo) {
    var elementHTML = document.querySelector("#myBillingArea");
    docPDF.html(elementHTML, {
        callback: function () {
            docPDF.save(invoiceNo + ".pdf");
        },
        x: 15,
        y: 15,
        width: 170,
        windowWidth: 650,
    });
}

async function filterTypes() {
    var brandid = document.getElementById("brand_id_prod").value;
    var data = {
        filterType: true,
        brand: brandid
    }

    $.ajax({
        type: "POST",
        url: "code.php",
        data: data,
        success: async function (response) {
            let jsn = JSON.parse(response);
            var html = "<option>Select Type</option>";
            for (let i in jsn['message']) {
                html += `<option value=${jsn['message'][i]['typeid']}>${jsn['message'][i]['typename']}</option>`;
            }
            document.getElementById("type_id_prod").innerHTML = html;
        },
        error: function (err) {
            console.log(err);
        }
    });
}

if (document.getElementById("brand_id_prod")) {
    document.getElementById("brand_id_prod").addEventListener("change", async (e) => {
        e.preventDefault();
        var brandid = document.getElementById("brand_id_prod").value;
        var data = {
            filterType: true,
            brand: brandid
        }

        $.ajax({
            type: "POST",
            url: "code.php",
            data: data,
            success: async function (response) {
                let jsn = JSON.parse(response);
                var html = "<option>Select Type</option>";
                for (let i in jsn) {
                    html += `<option value=${jsn['typeid']}>${jsn['typename']}</option>`;
                }
                document.getElementById("type_id_prod").innerHTML = html;
                console.log(jsn);

            },
            error: function (err) {
                console.log(err);
            }
        });
    });
}


if (document.getElementById("saveProduct")) {
    document.getElementById("saveProduct").addEventListener("click", async (e) => {
        e.preventDefault();
        var name = document.getElementById('name_').value;
        var price = document.getElementById('by_sell').value;
        var buyprice = document.getElementById('buy_prod').value;
        var type_id = document.getElementById('type_id_prod').value;
        var category_id = document.getElementById('category_id').value;

        var data = {
            saveProduct: true,
            name: name,
            price: price,
            buyprice: buyprice,
            type_id: type_id,
            category_id: category_id,
        };

        let resc = await checkforitem(name);
        if (resc == '0') {
            $.ajax({
                type: "POST",
                url: "code.php",
                data: data,
                success: async function (response) {
                    console.log(response);
                    var res = JSON.parse(response);
                    if (res.status == 200) {
                        console.log(res);
                        // await swal(res.message, res.message, res.status_type);
                        document.getElementById('name_').value = "";
                    } else {
                        swal("Error", "Product create Error", 'error');
                    }
                },
            });
        } else {
            swal("Error", "Product already exist", 'error');
        }

    });
}


async function checkforitem(code) {

    let x = $.ajax({
        type: "POST",
        url: "code.php",
        data: {
            item: code,
            isItemCheck: true
        },
        success: async function (response) {
            return response;
        },
    });
    return x;
}

async function getinvoiceitems(){
    var invoice = document.getElementById('orderinvoice').value;
    let x = $.ajax({
        type: "POST",
        url: "code.php",
        data: {
            invoice: invoice,
            isInvoiceItem: true
        },
        success: async function (response) {
            // console.log(response)
            if(JSON.parse(response)['status']==200){
                var items = JSON.parse(response)['message'];
                var ht = "<ul>";
                for(let i in items){
                    ht +=`<li id="item${items[i]['id']}" class="items" onclick="selectitem(${items[i]['id']})"><b>${items[i]['br']} ${items[i]['ca']} - ${items[i]['ty']}</b>  <br/> ${items[i]['name']}</li>`
                }
                ht +="</ul>"
                document.getElementById('items-con').innerHTML = ht;
            }

        },
        error:async function (err){
            console.log(err)
        }
    });
}
var returnitems = [];
async function selectitem(itemid) {
    unselect();
    returnitems = [];
    if(checkrow_(itemid)==0){
        returnitems.push(itemid);
        document.getElementById(`item${itemid}`).style.backgroundColor = 'lightgreen';
    }else{
        returnitems = removerow_(itemid);
        document.getElementById(`item${itemid}`).style.backgroundColor = 'lightgray';
    }
    console.log(returnitems);
}

async function genreturns(){
    //var invo = document.getElementById("orderinvoice").value;
    var newbattery = document.getElementById("product_id").value;
    var reason = document.getElementById("reason").value;
    var returned = document.getElementById("oldbattery").value;
    var wrdate = document.getElementById("warrntydate").value;
    // for(let i in returnitems){
    //     returned +=returnitems[i]+",";
    // }
    let x = $.ajax({
        type: "POST",
        url: "code.php",
        data: {
            invoice:"None",
            newbatid:newbattery,
            oldbat:returned,
            reason:reason,
            wrdate:wrdate,
            returnItem: true
        },
        success: async function (response) {
            let res = JSON.parse(response);
            console.log(res)
            if(res['status']){
                window.open(`./return-summary.php?invoice_no=${res['message']}`);
                location.reload();
            }
        },
        error:async function (err){
            console.log(err)
        }
    });

}

var trnasitems = [];
async function addtritem(){
    var store = document.getElementById("store_id").value;
    var item = document.getElementById("product_id").value.split("|");
    var itemval = item[0];
    var itemname = item[1];
    let x = {id:itemval,name:itemname,store:store}
    await trnasitems.push(x)
    renderitems();

}

function renderitems(){
    let ht = '';
    var a = 1
    for(let i in trnasitems){
        ht +=  `<div class="tritemslist" onclick="removetritem(${trnasitems[i].id})">${a}.  ${trnasitems[i].name}</div>`;
        a++;
    }
    document.getElementById("tritems").innerHTML = ht;
}

function completetransfer(){
    var store = document.getElementById("store_id").value;

}

async function removetritem(id){
    trnasitems = trnasitems.filter(item => item.id != id)
    renderitems();
}

async function launchmodal(){
    $("#orderSuccessModal").modal("show");
}

function checkrow_(row){
    let temp = returnitems.filter((item)=>item==row);
    console.log(temp)
    return temp.length;
}

function removerow_(row){
    let temp = returnitems.filter((item)=>item!=row);
    return temp;
}

function unselect(){
    for (const key in returnitems) {
        console.log(key)
        document.getElementById(`item${returnitems[key]}`).style.backgroundColor = 'lightgray';
    }
}