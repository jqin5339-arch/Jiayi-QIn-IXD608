<?php

require_once __DIR__ . "/../../db.php";

function print_p($v) {
    echo "<pre>", print_r($v), "</pre>";
}

function file_get_json($filename) {
    $file = file_get_contents($filename);
    return json_decode($file);
}

function initSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_name("LUMA2SESSID");
        session_set_cookie_params(0, "/");
        session_start();
    }

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }
}

function getCart() {
    initSession();
    return $_SESSION["cart"];
}

function addToCart($id, $amount, $potStyle) {
    initSession();

    foreach ($_SESSION["cart"] as $item) {
        if ($item->id == $id &&
            $item->potStyle == $potStyle) {
            $item->amount += $amount;
            return;
        }
    }

    $_SESSION["cart"][] = (object)[
        "id" => (int)$id,
        "amount" => (int)$amount,
        "potStyle" => $potStyle
    ];
}
