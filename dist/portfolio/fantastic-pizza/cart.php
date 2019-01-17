<?php

require_once("tools.php");

if (isset($_GET["cancel"])) {
    unset($_SESSION["cart"]);
    header("Location: products.php");
    die();
}

$products = get_all_products();

function validate_and_add_item($id, $oid, $qty) {
    global $products;
    if ($qty <= 0 || !isset($products[$id]) || !isset($products[$id][$oid])) {
        return false;
    }

    if (!isset($_SESSION["cart"][$id])) {
        $_SESSION["cart"][$id] = [];
    }
    $_SESSION["cart"][$id][$oid]["qty"] = $qty;
    $_SESSION["cart"][$id][$oid]["unit_price"] = money($products[$id][$oid]["price"], "");
    $_SESSION["cart"][$id][$oid]["subtotal"] = money($products[$id][$oid]["price"] * $qty, "");

    return true;
}

$message = "";
if (isset($_POST["id"], $_POST["option"], $_POST["qty"])) {
    $result = validate_and_add_item($_POST["id"], $_POST["option"], $_POST["qty"]);

    if ($result === false) {
        $message = "Invalid order. Please try again.";
    }
}

redirect_if_cart_empty();

top_module("Fantastic Pizza - Cart");
?>

<section>
    <h1>Cart</h1>
    <p class="error"><?=$message?></p>
    <?php print_cart($products, $_SESSION["cart"]); ?>
    <br/>
    <a class="big-button" href="?cancel">Clear cart</a>
    <a class="big-button" href="checkout.php">Proceed to checkout</a>
</section>

<?php
bottom_module();
?>
