<?php
require '../config/function.php';

$paramResultId = checkParamId('index');

if (is_numeric($paramResultId)) {
    $indexValue = validate($paramResultId);
    if (isset($_SESSION['retailItemIds']) && isset($_SESSION['retailItems'])) {
        unset($_SESSION['retailItemIds'][$indexValue]);
        unset($_SESSION['retailItems'][$indexValue]);

        redirect('order-create.php', 'Item has been removed.');
    } else {
        redirect('order-create.php', 'This item is not available in the cart.');
    }
} else {
    redirect('order-create.php', 'Something went wrong.');
}
