<?php
require_once __DIR__ . "/lib/php/functions.php";
initSession(); 

$action = $_POST["action"] ?? $_GET["action"] ?? "";

// 智能容错：如果没有传 action 但传了 product-id，自动识别为加购
if (empty($action) && isset($_POST["product-id"])) {
    $action = "add-to-cart";
}

switch ($action) {
    case "add-to-cart":
        $id = isset($_POST["product-id"]) ? (int)$_POST["product-id"] : 0;
        $amount = isset($_POST["product-amount"]) ? (int)$_POST["product-amount"] : 1;
        $potStyle = $_POST["product-pot-style"] ?? "Ceramic";

        if ($id > 0 && $amount > 0) {
            addToCart($id, $amount, $potStyle);
        }

        header("Location: cart.php");
        exit;

    default:
        header("Location: products.php");
        exit;
}