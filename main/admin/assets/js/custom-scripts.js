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

  $(document).on("change","#payment_mode",function(){
    let ele = document.getElementById("payment_mode").value;
    if(ele=="Credit"){
      document.getElementById("creditpay").style.display = "block";
      document.getElementById("cnopay").style.display = "none";
    }else if(ele=="CnO"){
      document.getElementById("cnopay").style.display = "block";
      document.getElementById("creditpay").style.display = "none";
      document.getElementById("creditpay_val").value = 0;
    }else{
      document.getElementById("creditpay").style.display = "none";
      document.getElementById("creditpay_val").value = 0;
      document.getElementById("cnopay").style.display = "none";
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
      amount_payed:amount_payed,
      online_payed:online_payed,
      cash_payed:cash_payed
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
      for(let i in jsn['message']){
        html+=`<option value=${jsn['message'][i]['typeid']}>${jsn['message'][i]['typename']}</option>`;
      }
      document.getElementById("type_id_prod").innerHTML = html;
    },
    error: function (err) {
      console.log(err);
    }
  });
}


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
      for(let i in jsn){
        html+=`<option value=${jsn['typeid']}>${jsn['typename']}</option>`;
      }
      document.getElementById("type_id_prod").innerHTML = html;
      console.log(jsn);
      
    },
    error: function (err) {
      console.log(err);
    }
  });

});



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