<?php
require_once 'Database.php';
require_once 'ORMInterface.php';
require_once 'ORM.php';
require_once 'Product.php';

$product = Product::find(1);
if ($product) {
    if ($product->delete()) {
        echo "Product deleted successfully.";
        Product::reorganizeIds(); // Réorganiser les ID après la suppression
    } else {
        echo "Failed to delete product.";
    }
} else {
    echo "Product not found.";
}

?>
