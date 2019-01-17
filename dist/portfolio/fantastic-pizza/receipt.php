<?php

require_once("tools.php");

// just as in tools.php, we can't "define" this as a constant because of older php version on server
$CENSOR_DETAILS = ["card", "expiry"];

if (!isset($_SESSION["last_order"])) {
    header("Location: cart.php");
    die();
}

top_module("Fantastic Pizza - Receipt");
?>
<section>

    <h1><img alt="Fantastic Pizza logo" src="<?=MEDIA_DIR?>fantastic-pizza-logo.svg"/> Fantastic Pizza - Receipt</h1>
    <p>Your order was successful. Please retain the following information for your records.</p>
    <button class="big-button print-button" onclick="window.print()">Print receipt</button>
    <section class="tax-invoice-header">
        <section class="from">
            <h2>From</h2>
            <p>Fantastic Pizza Pty Ltd<br/>
                1234 Awesome Road<br/>
                FantasticVille, 56789
            </p>
        </section>
        <section class="to">
            <h2>To</h2>
            <p>
                <?php
                foreach ($checkoutFields as $field => $meta) {
                    if (in_array($field, $CENSOR_DETAILS)) { ?>
                    <?=$meta["display"]?>: &lt;redacted&gt;<br/>
                <?php } else { ?>
                    <?=$meta["display"]?>: <?=htmlspecialchars($_SESSION["last_order"]["customer"][$field])?><br/>
                <?php
                    }
                }
                ?>
            </p>
        </section>
    </section>

    <section class="tax-invoice-body">
        <h2>Order</h2>
        <section class="date"><strong>Date: </strong><?=$_SESSION["last_order"]["date"]?><br/><br/></section>
        <?=print_cart(get_all_products(), $_SESSION["last_order"]["cart"])?>
    </section>
</section>

<?php

bottom_module();

?>
