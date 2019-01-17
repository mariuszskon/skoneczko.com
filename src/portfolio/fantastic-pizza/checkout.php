<?php

require_once("tools.php");

redirect_if_cart_empty();

// can't define/const because object
$ONE_MONTH = new DateInterval("P1M"); // period of 1 month http://php.net/manual/en/dateinterval.construct.php


function print_expiry_select($field) { ?>
    <select id="<?=$field?>" name="<?=$field?>">
        <?php
        global $ONE_MONTH;
        $farInTheFuture = (new DateTime("now"))->add(new DateInterval(LONGEST_CARD_VALIDITY));
        $thisMonth = new DateTime("now");
        $thisMonth->modify("first day of this month"); // php understands english https://stackoverflow.com/questions/43863610/round-up-a-date-to-the-beginning-of-the-next-month
        for ($expiryDate = $thisMonth; $expiryDate <= $farInTheFuture; $expiryDate->add($ONE_MONTH)) {
            $printDate = $expiryDate->format(CREDIT_CARD_EXPIRY_FORMAT);
        ?>
            <option value="<?=$printDate?>"<?= $printDate === @$_POST[$field] ? " selected" : "" ?>><?=$printDate?></option>
        <?php
        }
        ?>

    </select>
<?php
}

function checkout_form($checkoutFields, $errors) {
    foreach($checkoutFields as $field => $meta) { ?>
        <div>
            <label for="<?=$field?>"><?=$meta["display"]?></label>
            <?php if ($meta["type"] === "textarea") { ?>
                <textarea id="<?=$field?>" name="<?=$field?>"><?=@htmlspecialchars($_POST[$field])?></textarea>
            <?php } else if ($meta["type"] === "expiry_date") {
                print_expiry_select($field);
                  } else { ?>
                <input id="<?=$field?>" name="<?=$field?>" type="<?=$meta["type"]?>" value="<?=@htmlspecialchars($_POST[$field])?>">
            <?php }
            if (isset($meta["custom_html_after"])) echo $meta["custom_html_after"];
            ?>
            <p class="error"><?php if (isset($errors[$field])) echo $errors[$field] ?></p>
        </div>
<?php
    }
}

function checkout_confirm_page($checkoutFields, $errors) {
    top_module("Fantastic Pizza - Checkout");
?>

    <section>
        <h1>Checkout</h1>
        <form id="checkout-form" method="post" action="checkout.php">
            <?php

            checkout_form($checkoutFields, $errors);

            ?>

            <section>
                <h2>Order summary</h2>

                <?php

                print_cart(get_all_products(), $_SESSION["cart"]);

                ?>

            </section>

            <br/>
            <a class="big-button" href="cart.php?cancel">Cancel</a>
            <button type="submit" class="big-button">Confirm order</button>
        </form>

        <script src="js/checkout-form.js"></script>
    </section>

<?php
}

function print_customer_details($checkoutFields, $details) { ?>
<?php
}

$errors = [];
if (!empty($_POST)) { // checkout form submitted
    // validate
    foreach ($checkoutFields as $field => $meta) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required.";
            continue;
        }

        if ($meta["validate"]($_POST[$field]) === false) {
            $errors[$field] = $meta["invalid_message"];
            continue;
        }
    }
} else {
    $errors["none"] = "Not submitted"; // "hack" to simplify branching logic by using same code as below
}

if (empty($errors)) {
    $_SESSION["last_order"] = [
        "date" => (new DateTime("now"))->format(AUSTRALIAN_DATE_FORMAT),
        "customer" => [],
        "cart" => $_SESSION["cart"]
    ];

    $_SESSION["cart"] = [];

    // POST data already validated (above), so we can store all relevant fields into session
    foreach ($checkoutFields as $field => $meta) {
        $_SESSION["last_order"]["customer"][$field] = $_POST[$field];
    }

    save_order($_SESSION["last_order"]);

    header("Location: receipt.php");
    die();
} else {
    checkout_confirm_page($checkoutFields, $errors);
}

bottom_module();

?>
