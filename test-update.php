<?php
require_once 'Database.php';
require_once 'ORMInterface.php';
require_once 'ORM.php';
require_once 'Product.php';

$product = Product::find(1);
if ($product) {
    $product->setAttribute('price', 24.99);

    if ($product->update()) {
        echo "Product updated successfully.";
    } else {
        echo "Failed to update product.";
    }
} else {
    echo "Product not found.";
}

?>

