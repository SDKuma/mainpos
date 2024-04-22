<?php

include("../config/function.php");

if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

if (!isset($_SESSION['retailItemIds'])) {
    $_SESSION['retailItemIds'] = [];
}

if (!isset($_SESSION['retailItems'])) {
    $_SESSION['retailItems'] = [];
}
if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
//retail item
if(isset($_POST["addRetailItem"])){
    $product_id = validate($_POST['retail_product_id']);
    $quantity = validate($_POST['rettail_quantity']);
    if($product_id){
        $row = getById("retail_products", $product_id);
        if($row['data']){
            $item = $row['data'];
            if($quantity<=$item['qty']){
                //saving retail item
                $itemData = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'name' => $item['name']."<br/>".$item['brand'],
                    'price' => $item['price'],
                ];
                //check retail array session
                if(!in_array($row['data']['id'], $_SESSION['retailItemIds'])){
                    array_push($_SESSION['retailItemIds'], $row['data']['id']);
                    array_push($_SESSION['retailItems'], $itemData);
                }else{
                    foreach ($_SESSION['retailItems'] as $key => $prodSessionItem) {
                        if ($prodSessionItem['product_id'] == $row['data']['id']) {
                            $newQuantity = $prodSessionItem['quantity'] + $quantity;

                            $productData = [
                                'product_id' => $row['data']['id'],
                                'name' => $row['data']['brand'].' '.$row['data']['type_'].' '.$row['data']['amp'].'AMP-'.$row['data']['name'],
                                'image' => $row['data']['image'],
                                'price' => $row['data']['price'],
                                'quantity' => $newQuantity
                            ];
                            $_SESSION['retailItems'][$key] = $productData;
                        }
                    }
                }
                redirect('order-create.php', 'Item "' . $row['data']['name'] . '" added in cart.');
            }else{
                redirect('order-create.php', 'Low in Quantity');
            }

        }else{
            redirect('order-create.php', 'No Item found');
        }
    }else{
        redirect('order-create.php', 'Item not defined');
    }
}


// Insert item
if (isset($_POST['addItem'])) {
    $product_id = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);
//    echo $product_id;

    if ($product_id != 'not_defined') {
        $row = getProductById("products", $product_id);
        if ($row) {
            if ($quantity <= $row['data']['quantity']&&$row['data']['quantity']>0) {
                $productData = [
                    'product_id' => $row['data']['id'],
                    'name' => $row['data']['brand'].' '.$row['data']['type_'].' '.$row['data']['amp'].'<br><span style="font-size:12px">'.$row['data']['name'].'<span>',
                    'image' => $row['data']['image'],
                    'price' => $row['data']['price'],
                    'quantity' => $quantity
                ];

                if (!in_array($row['data']['id'], $_SESSION['productItemIds'])) {
                    array_push($_SESSION['productItemIds'], $row['data']['id']);
                    array_push($_SESSION['productItems'], $productData);
                } else {
                    foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                        if ($prodSessionItem['product_id'] == $row['data']['id']) {
                            $newQuantity = $prodSessionItem['quantity'] + 0;

                            $productData = [
                                'product_id' => $row['data']['id'],
                                'name' => $row['data']['brand'].' '.$row['data']['type_'].' '.$row['data']['amp'].'AMP-'.$row['data']['name'],
                                'image' => $row['data']['image'],
                                'price' => $row['data']['price'],
                                'quantity' => $newQuantity
                            ];
                            $_SESSION['productItems'][$key] = $productData;
                        }
                    }
                }
               redirect('order-create.php', 'Item "' . $row['data']['name'] . '" added in cart.');
            } else {
               redirect('order-create.php', 'Only ' . $row['data']['quantity'] . ' products are available.');
            }
        } else {
            redirect('order-create.php', 'No product found.');
        }
    } else {
        redirect('order-create.php', 'Please select a product.');
    }
}

//add scrap
if(isset($_POST['addScrap'])){
    $scrp_ar = explode("-",$_POST['mainscrap']);
    $subscrp_ar = explode("-",$_POST['submain']);



    $scrapname = validate($scrp_ar[1]);
    $ampvalue = validate($subscrp_ar[1]);
    $scrapdiscount = validate($_POST['scrapdiscount']);

    if(isset($_SESSION['scrap_items'])){
        $oldscrap = $_SESSION['scrap_items'];
        $row = array('name'=>$scrapname,'amp'=>$ampvalue,'discount'=>$scrapdiscount);
        array_push($oldscrap,$row);
        $_SESSION['scrap_items'] = $oldscrap;
        redirect('order-create.php', 'Scrap Item Added.');
    }else{
        $row = array('name'=>$scrapname,'amp'=>$ampvalue,'discount'=>$scrapdiscount);
        $scraparray = array();
        array_push($scraparray,$row);
        $_SESSION['scrap_items'] = $scraparray;
        redirect('order-create.php', 'Scrap Item Added.');
    }

}

// IncDec
if (isset($_POST['productIncdec'])) {
    $product_id = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }
    if ($flag) {
        jsonResponse(200, 'success', 'Quantity Updated.');
    } else {
        jsonResponse(500, 'error', 'Something went wrong, Please refresh the page.');
    }
}

// Procced to place order
if (isset($_POST['proccedToPlaceBtn'])) {
    $phone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);
    $discount = validate($_POST['discount']);
    $payed_amount = validate($_POST['amount_payed']);//amount that user paid when it is a credit bill

    // Checking for customer
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");

    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = "INV-" . rand(111111, 999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment_mode;
            $_SESSION['discount'] = $discount;
            $_SESSION['amount_payed'] = $payed_amount;

            jsonResponse(200, "success", 'Customer found with this phone number.');
        } else {
            $_SESSION['cphone'] = $phone;
            jsonResponse(404, "warning", 'Customer not found with this phone number.');
        }
    } else {
        jsonResponse(500, "error", 'Something went wrong.');
    }
}
//settle credit
if(isset($_POST['confirmSettle'])){
    $orderid = validate($_POST['orderid']);
    $paying_amount = validate($_POST['paying']);

    $data = [
        'paying' => $paying_amount,
        'orderid' => $orderid
    ];
    $result = settleorder($data);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}



// Add customer to customer's table
if (isset($_POST['saveCustomerBtn'])) {
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    $address = validate($_POST['email']);

    if ($name != "" && $phone != "") {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
        ];
        $result = insert("customers", $data);
        if ($result) {
            jsonResponse(200, 'success', 'Customer has been created successfully.');
        } else {
            jsonResponse(500, 'error', 'Something went wrong.');
        }
    } else {
        jsonResponse(422, 'warning', 'Please fill the required fields.');
    }
}

// On customer's order save
if (isset($_POST['saveOrder'])) {
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $discount = validate($_SESSION['discount']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];
    $amount_payed = $_SESSION['amount_payed'];

    $totalScrap = 0;

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");

    if (!$checkCustomer) {
        jsonResponse(500, "error", 'Something went wrong(Customer not found).');
    }


    if (isset($_SESSION['scrap_items'])){
        $scrapitems = $_SESSION['scrap_items'];       
        foreach ($scrapitems as $key => $item) {
            $totalScrap += (int)$item['discount'];
        }
    } 

    if (mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);
        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, "warning", "No item to place the order.");
        }

        $sessionProducts = $_SESSION['productItems'];
        $sessionRetail = $_SESSION['retailItems'];

        $totalAmount = 0;

        foreach ($sessionProducts as $amtItem) {
            $totalAmount +=  $amtItem['price'] * $amtItem['quantity'];
        }

        foreach ($sessionRetail as $retailItem) {
            $totalAmount +=  $retailItem['price'] * $retailItem['quantity'];
        }


        if((int)$discount>0){
            $netTotal = (int)$totalAmount - (int)$discount-$totalScrap; 
        }else{
            $netTotal = $totalAmount-$totalScrap;
        }

        $status_ = "Booked";
        $payed = $netTotal;
        $pending_amount = 0;
        if($payment_mode=="Credit"&&($netTotal>$amount_payed)){
            $status_ = "Pending";
            $payed = $amount_payed;
            $pending_amount = $netTotal-$payed;
        }

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(11111, 99999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => $status_,
            'payment_mode' => $payment_mode,
            'order_placed_by_id' => $order_placed_by_id,
            'discount'=>$discount,
            'net_total'=>$netTotal,
            'on_scrap_discount'=>$totalScrap,
            'payed_amount'=>$payed,
            'pending_amount'=>$pending_amount
        ];

        $result = insert('orders', $data);
        $lastOrderId = mysqli_insert_id($conn);

        $data1 = [
            'order_id' => $lastOrderId,
            'payed'=>$payed,
            'date_payed'=>date('Y-m-d'),
            'time_payed'=>date('H:i:s')
        ];
        $result = insert("credit_history", $data1);

        if (isset($_SESSION['scrap_items'])){
            $scrapitems = $_SESSION['scrap_items']; 
            foreach ($scrapitems as $key => $item) {
                //get scrap master
                $q1 = "SELECT * FROM `scrapsmaster` WHERE `name`='".$item['name']."';";
                $r1 =  mysqli_query($conn, $q1);
                $rw1 = mysqli_fetch_assoc($r1);

                //scrap rate
                $q2 = "SELECT * FROM `scrap_rate` WHERE `id`='".$rw1['rate_type']."';";
                $r2 = mysqli_query($conn, $q2);
                $rw2 = mysqli_fetch_assoc($r2);

                //get weight
                $q3 = "SELECT * FROM `scrap_weights` WHERE `name`='".$item['amp']."' AND `scrap_id`='".$rw1['id']."'  ;";
                $r3 = mysqli_query($conn, $q3);
                $rw3 = mysqli_fetch_assoc($r3);

                $preprofit = (int)$rw3['weight']*(int)$rw2['rate_'];
                $profit = $preprofit-(int)$item['discount'];

                $dataOrderItem = [
                    'order_id' => $lastOrderId,
                    'scrapname' => $item['name'],
                    'amp' => $item['amp'],
                    'discount' => $item['discount'],
                    'profit'=>$profit,
                    'date_trans'=>date('Y-m-d'),
                    'unit_price'=>$rw2['rate_']
                ];
                $orderScrapItemQuery = insert('order_scrap', $dataOrderItem);    
            }
        } 


        foreach ($sessionProducts as $prodItem) {
            $productId = $prodItem['product_id'];
            $price = $prodItem['price'];
            $quantity = $prodItem['quantity'];

            // Inserting order items
            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
                'date_trans'=>date('Y-m-d')
            ];

            $orderItemQuery = insert('order_items', $dataOrderItem);

            // Product quantity update
            $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'");
            $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);

            $totalProductQuantity = $productQtyData['quantity'] - $quantity;

            $dataUpdate = [
                'quantity' => $totalProductQuantity
            ];

            $updateProductQty = update('products', $productId, $dataUpdate);
        }

        foreach ($sessionRetail as $retailItem) {
            $productId = $retailItem['product_id'];
            $price = $retailItem['price'];
            $quantity = $retailItem['quantity'];
            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
                'date'=>date('Y-m-d')
            ];

            $record = "SELECT * FROM retail_products WHERE id='$productId' LIMIT 1;";
            $result = mysqli_query($conn, $record);
            $retail_product = mysqli_fetch_assoc($result);

            $updatedata = [
                'qty' => (int)$retail_product['qty'] - (int)$quantity
            ];

            $orderItemQuery = insert('order_retail', $dataOrderItem);
            $updateonred = update('retail_products', $productId, $updatedata);
        }

        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);
        unset($_SESSION['scrap_items']);
        unset($_SESSION['amount_payed']);
        unset($_SESSION['retailItems']);
        unset($_SESSION['retailItemIds']);


        jsonResponse(200, 'success', 'Order placed successfully.');
    } else {
        jsonResponse(404, 'warning', 'Customer not found.');
    }
}

if (isset($_POST['getSubScrap'])) {
    $id = $_POST['id'];
    $arr_scrap = explode("-",$id);
    $query = "SELECT * FROM `scrap_weights` WHERE `scrap_id`='$arr_scrap[0]';";
    $result = mysqli_query($conn,$query);
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($data,$row);
    }
    jsonResponse(200,$query,$data);
    // return ["came"];
}

if (isset($_POST['getCategoryOpt'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM `categories` WHERE `brand_id`='$id';";
    $result = mysqli_query($conn,$query);
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($data,$row);
    }
    jsonResponse(200,$query,$data);
    // return ["came"];
}

if (isset($_POST['getTypePrice'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM `type` WHERE `id`='$id' LIMIT 1;";
    $result = mysqli_query($conn,$query);
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($data,$row);
    }
    jsonResponse(200,$query,$data);
    // return ["came"];
}