<?php
session_start();

require "dbcon1.php";

// Input field validation
function validate($inputData)
{
    global $conn;
    if ($inputData != NULL) {
        $validateData = mysqli_real_escape_string($conn, $inputData);
        return trim($validateData);
    }
}

// Redirect from one page to another page with the message (status)
function redirect($url, $status)
{
    $_SESSION["status"] = $status;
    header('Location:' . $url);
    exit(0);
}

// Display messages or status after any process
function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
<h6>' . $_SESSION['status'] . '</h6>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        unset($_SESSION['status']);
    }
}

// Insert data using this function
function insert($tableName, $data)
{
    global $conn;

    $table = validate($tableName);

    $columns = array_keys(($data));
    $values = array_values(($data));

    $finalColumns = implode(',', $columns);
    $finalValues = "'" . implode("', '", $values) . "'";

    $query = "INSERT INTO $table ($finalColumns) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

function settleorder($data)
{
    global $conn;
    $orderid = $data['orderid'];
    $amount_ = $data['paying'];

    $query1 = "SELECT * FROM orders WHERE id = '$orderid';";
    $result1 = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result1);
    $pending = $row['pending_amount'];
    $payed = $row['payed_amount'];
    $amount = $row['net_total'];
    //new values
    $pending = (int)$pending - (int)$amount_;
    $payed = (int)$payed + (int)$amount_;
    $status = "Pending";
    if ($pending <= 0) {
        $status = "Booked";
    }

    $query2 = "UPDATE orders SET order_status = '" . $status . "',pending_amount='" . $pending . "',payed_amount='" . $payed . "' WHERE id = '$orderid';";
    $result2 = mysqli_query($conn, $query2);

    $data1 = [
        'order_id' => $orderid,
        'payed' => $amount_,
        'date_payed' => date('Y-m-d'),
        'time_payed' => date('H:i:s')
    ];
    $result = insert("credit_history", $data1);

}

function checkitem($item)
{
    global $conn;
    $q = "SELECT * FROM products WHERE `name`='" . $item . "';";
    $r = mysqli_query($conn, $q);
    $rowcount = mysqli_num_rows($r);

    return $rowcount;
}

function filtertypes($id)
{
    global $conn;
    $q = "SELECT brands.id as brand,`type`.name as typename,`type`.id as typeid  FROM `brands` JOIN categories ON brands.id=categories.brand_id JOIN `type` ON `type`.`category`=categories.id WHERE brands.id = " . $id . ";";
    $r = mysqli_query($conn, $q);
    return $r;
}

// Update data using this function
function update($tableName, $id, $data)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach ($data as $column => $value) {
        $updateDataString .= $column . '=' . "'$value',";
    }

    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id = '$id'";

    $result = mysqli_query($conn, $query);
    return $result;
}

// Get all data using this function
function getAll($tableName, $status = NULL)
{
    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if ($status == "status") {
        $query = "SELECT * FROM $table WHERE $status = '0'";
    } else {
        $query = "SELECT * FROM $table";
    }

    $result = mysqli_query($conn, $query);
    return $result;
}

function getAllProds($tableName, $status = NULL)
{
    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if ($status == "status") {
        $query = "SELECT * FROM $table WHERE $status = '0'";
    } else {
        $query = "SELECT * FROM $table";
    }

    $result = mysqli_query($conn, $query);
    return $result;
}

// Get by id data using this function
function getById($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => "Record found!"
            ];
            return $response;
        } else {
            $response = [
                'status' => 404,
                'message' => "No data found!"
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 500,
            'message' => "Something went wronggg!"
        ];
        return $response;
    }
}

function getProductById($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    // $query = "SELECT * FROM $table LEFT JOIN  WHERE id='$id' LIMIT 1";
    // $q = "SELECT `products`.*,`brands`.`name` as 'brand',`type`.`name` as 'type_' FROM products LEFT JOIN `brands` ON `products`.`Brand`=`brands`.`id` LEFT JOIN `type` ON `type`.`id`=`products`.`Type` WHERE `products`.`id`=".$id." LIMIT 1;"; 
    $q = "SELECT products.*,`Type`.`name` as 'type_',`Type`.`amp` as 'amp',categories.name as cat,brands.name as brand FROM products LEFT JOIN `type` ON `type`.`id` = products.`Type` LEFT JOIN categories ON categories.id=products.category_id LEFT JOIN brands ON brands.id=categories.brand_id WHERE `products`.`id`=" . $id . " LIMIT 1;";
    $result = mysqli_query($conn, $q);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => "Record found!"
            ];
            return $response;
        } else {
            $response = [
                'status' => 404,
                'message' => "No data found!"
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 500,
            'message' => "Something went wronggg!"
        ];
        return $response;
    }
}

function softdelete($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "UPDATE $table SET `status` = 0 WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);
    return $result;

}

function updateretails($tableName, $id,$data){
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

}


// Delete data from db using id
function delete($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Check paramId
function checkParamId($type,)
{
    if (isset($_GET[$type])) {
        if ($_GET[$type] != "") {
            return $_GET[$type];
        } else {
            return '<h5>Id not found!</h5>';
        }
    } else {
        return '<h5>No id given!</h5>';
    }
}

// To logout the user & destroy the session
function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

// To return jsonResponse result
function jsonResponse($status, $status_type, $message,$data=[])
{
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message,
        'data' => $data
    ];
    echo json_encode($response);
    return;
}

// Get counts
function getCount($tableName)
{
    global $conn;
    $table = validate($tableName);
    $query = "SELECT * FROM $table";

    $queryRes = mysqli_query($conn, $query);
    if ($queryRes) {
        $totalCount = mysqli_num_rows($queryRes);
        return $totalCount;
    } else {
        return 'Something went wrong.';
    }
}
