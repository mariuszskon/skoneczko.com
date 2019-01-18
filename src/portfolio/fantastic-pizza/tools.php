<?php

error_reporting( E_ERROR | E_WARNING | E_PARSE | E_NOTICE );

require_once("db.php");

session_start();

define("MEDIA_DIR", "img/");
// the following could be define-d constants, if it wasn't for coreteaching's php version...
$NAV_PAGES = [
    "Menu" => "products.php"
];
$CATEGORY_PREFIXES = [
    "pz" => "Pizza",
    "sd" => "Salads"
];
define("UNKNOWN_CATEGORY", "Miscellaneous");
/*
 * formats listed here: http://php.net/manual/en/function.date.php
 * http://php.net/manual/en/datetime.createfromformat.php
 */
define("CREDIT_CARD_EXPIRY_FORMAT", "m-y");
define("AUSTRALIAN_DATE_FORMAT", "d/m/Y");
define("LONGEST_CARD_VALIDITY", "P50Y"); // 50 years http://php.net/manual/en/dateinterval.construct.php
define("EARLIEST_CARD_EXPIRY_INTERVAL", "P1M");

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

function count_cart() {
    $total = 0;

    foreach ($_SESSION["cart"] as $id => $itemGroup) {
        foreach ($itemGroup as $oid => $item) {
            $total++;
        }
    }

    return $total;

}

function top_module($title) {
    global $NAV_PAGES;
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?=$title?></title>

            <link href="//fonts.googleapis.com/css?family=Do+Hyeon|Roboto" rel="stylesheet">
            <link id="stylecss" type="text/css" rel="stylesheet" href="css/style.css">
        </head>

        <body>

            <header>
                <nav>
                    <ul>
                        <!-- must be all on one line to avoid spacing issues (and avoiding floats) -->
                        <li class="brand"><a href="index.php"><img alt="Fantastic Pizza logo" src="<?=MEDIA_DIR?>fantastic-pizza-logo.svg"/> Fantastic Pizza</a></li>
                        <?php
                        foreach ($NAV_PAGES as $page => $href) {
                            $bits = explode("/", $_SERVER["SCRIPT_NAME"]);
                            $filename = $bits[count($bits)-1];
                            // yes the indentation and line separation is bad, but its important to avoid producing spaces in HTML output
                        ?><li><a href="<?=$href?>" class="<?= $filename === $href ? "current" : "" ?>"><?=$page?></a></li><?php
                                                                                                                          }
                                                                                                                          ?><li id="cart-nav"><a href="cart.php">Cart <span><?=count_cart()?></span></a></li>
                    </ul>
                </nav>
            </header>

            <main>

<?php
}


function bottom_module() { ?>
            </main>

            <footer>
                <div>&copy;<script>
                            document.write(new Date().getFullYear());
                </script> Mariusz Skoneczko</div>
                <div>Disclaimer: This website is not a real website. It was made for educational purposes.</div>
            </footer>

            <script src="js/item-add-form.js"></script>

    </body>
</html>
<?php
}

function money($amount, $currency='$') {
    return $currency . sprintf("%.2f", $amount);
}

function categorise_products($products) {
    global $CATEGORY_PREFIXES;
    $categorised = [UNKNOWN_CATEGORY => []];
    foreach ($CATEGORY_PREFIXES as $name) {
        $categorised[$name] = [];
    }

    foreach ($products as $id => $product) {
        $prefix = explode("_", $id)[0];
        if (isset($CATEGORY_PREFIXES[$prefix])) {
            $categorised[$CATEGORY_PREFIXES[$prefix]][$id] = $product;
        } else {
            $categorised[UNKNOWN_CATEGORY][$id] = $product;
        }
    }

    return $categorised;
}

function calculate_total_cart_price($cart) {
    $total = 0;

    foreach ($cart as $itemGroup) {
        foreach ($itemGroup as $item) {
            $total += $item["subtotal"];
        }
    }

    return $total;
}

function print_cart($products, $cart) { ?>
    <table class="cart">
        <thead>
            <tr><th class="title">Item</th><th class="option_human">Option</th><th class="numeric qty">Quantity</th><th class="numeric subtotal">Subtotal</th></tr>
        </thead>
        <tbody>
            <?php
            foreach ($cart as $id => $itemGroup) {
                foreach ($itemGroup as $oid => $item) {
                    $productInfo = $products[$id][$oid];
                    echo "<tr><td class='title'>{$productInfo['title']}</td><td class='option_human'>{$productInfo['option_human']}</td><td class='numeric qty'>{$item['qty']}</td><td class='numeric subtotal'>" . money($item['subtotal']) . "</td></tr>";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr><th>Total</th><th class="numeric" colspan="3"><?= money(calculate_total_cart_price($cart)); ?></th></tr>
        </tfoot>
    </table>
<?php
}

function redirect_if_cart_empty() {
    if (empty($_SESSION["cart"])) {
        header("Location: products.php");
        die();
    }
}

// useful data and code for getting checkout input and validating it
$checkoutFields = [
    "name" => [
        "type" => "text",
        "display" => "Full name",
        "validate" => function($field) { return preg_match('/^[a-zA-Z.,\'-]+ [a-zA-Z .,\'-]+$/', $field) === 1; },
        "invalid_message" => "Please ensure your full name contains at least one space, and only contains alphabetic characters and basic punctuation."
    ],
    "email" => [
        "type" => "email",
        "display" => "Email",
        "validate" => function($field) { return filter_var($field, FILTER_VALIDATE_EMAIL); },
        "invalid_message" => "Please enter a valid email."
    ],
    "address" => [
        "type" => "textarea",
        "display" => "Address",
        "validate" => function($field) { return preg_match('#^[a-zA-Z\d \r\n.,\'/-]+$#', $field) === 1; },
        "invalid_message" => "Please ensure your address contains only alphabetic, numeric and punctuation characters."
    ],
    "mobile" => [
        "type" => "text",
        "display" => "Mobile no.",
        "validate" => function($field) { return preg_match('/^(\(04\)|04|\+614)( ?\d){8} *$/', $field) === 1; },
        "invalid_message" => "Please ensure you enter a valid Australian mobile phone number."
    ],
    "card" => [
        "type" => "text",
        "display" => "Credit card no.",
        "validate" => function($field) { return preg_match('/^(\d ?){12,19}$/', $field) === 1; },
        "invalid_message" => "Invalid credit card number.",
        "custom_html_after" => '<img class="visa-small" src="'.MEDIA_DIR.'visa.svg" alt="Visa logo"> <!-- image used for educational purposes, sourced from https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg -->'
    ],
    "expiry" => [
        "type" => "expiry_date",
        "display" => "Expiry date",
        "validate" => function($field) {
            $date = DateTime::createFromFormat(CREDIT_CARD_EXPIRY_FORMAT, $field);
            if ($date === false) return false;
            $earliestValid = (new DateTime("last day of this month"))->add(new DateInterval(EARLIEST_CARD_EXPIRY_INTERVAL));
            $diff = $earliestValid->diff($date); // $date - $earliestValid
            return !$diff->invert; // invert is 1 on negative value (i.e. our $date came BEFORE $earliestValid) or 0 on positive ($date after $earliestValid)
        },
        "invalid_message" => "Card cannot expire within one month of purchase."
    ]
];

?>
