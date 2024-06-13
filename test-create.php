<?php
require_once 'Database.php';
require_once 'ORMInterface.php';
require_once 'ORM.php';
require_once 'Product.php';

$product = new Product([
    'name' => 'test Product ' . uniqid(),
    'price' => 18.99
]);

if ($product->save()) {
    echo "Product created successfully.";
} else {
    echo "Failed to create product.";
}

?>