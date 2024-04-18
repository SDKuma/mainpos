<?php
require '../config/function.php';

$paramResultId = checkParamId('id');

if (is_numeric($paramResultId)) {
    $productId = validate($paramResultId);
    $product = getById('retail_products', $productId);
    if ($product['status'] == 200) {
        $productDeleteRes = softdelete('retail_products', $productId);
        if ($productDeleteRes) {
            $deleteImage = "../" . $product['data']['image'];
            if (file_exists($deleteImage)) {
                unlink($deleteImage);
            }
            redirect('retail-product-create.php', 'Prodcuct deleted successfully.');
        } else {
            redirect('retail-product-create.php', 'Something went wrong1.');
        }
    } else {
        redirect('retail-product-create.php', 'Something went wrong2.');
    }
} else {
    redirect('retail-product-create.php', 'Something went wrong3.');
}
