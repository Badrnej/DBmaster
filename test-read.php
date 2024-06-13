<?php
require_once 'Database.php';
require_once 'ORMInterface.php';
require_once 'ORM.php';
require_once 'Product.php';

$product = Product::find(1);
if ($product) {
    print_r($product);
} else {
    echo "Product not found.";
}

?>