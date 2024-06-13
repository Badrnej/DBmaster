<?php
require_once 'Database.php';
require_once 'ORMInterface.php';
require_once 'ORM.php';
require_once 'Product.php';

$db = Database::getInstance()->getConnection();

// Supprimer les enregistrements de la table 'orders' qui référencent les produits
$stmt = $db->prepare("DELETE FROM orders WHERE product_id IN (SELECT id FROM products)");
$stmt->execute();

if (Product::dropTable()) {
    echo "Table 'products' dropped successfully.";
} else {
    echo "Failed to drop table 'products'.";
}


?>