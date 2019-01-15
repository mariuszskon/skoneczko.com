<?php

require_once "osm_modules_dir_const.php";
require_once OSM_MODULES_DIR."/base/base.php";
require_once OSM_MODULES_DIR."/util/constants.php";
require_once OSM_MODULES_DIR."/purchase/print_purchase.php";
require_once OSM_MODULES_DIR."/util/input_purchase.php";
require_once OSM_MODULES_DIR."/util/purchase_input_form.php";
require_once OSM_MODULES_DIR."/util/delivered_toggle.php";
require_once OSM_MODULES_DIR."/util/sort_dropdown.php";
require_once OSM_MODULES_DIR."/util/sort_purchases.php";
require_once OSM_MODULES_DIR."/exceptions/OSMException.php";
require_once OSM_MODULES_DIR."/exceptions/ValidationException.php";

try {
    $warnings = [];
    // delivered toggle is not critical so it only causes a warning rather than error
    try {
        delivered_toggle($db);
    } catch (ValidationException $e) {
        $warnings[] = $e->getMessage();
    }

    // read input form and make fields appropriately formatted (e.g. red) if there was an issue
    $form_format = [];
    $input_error = input_purchase($db, $form_format);

    // read all purchases from database and load them into our own array
    $ids = $db->getAllIds();
    $purchases = [];
    foreach ($ids as $id) {
        $purchases[$id] = $db->getById($id);
    }

    $sortby = "";
    $ascending = true;
    if (isset($_GET["sort"])) {
        $sortby = $_GET["sort"];
    }
    if (isset($_GET["order"])) {
        $ascending = $_GET["order"] === "asc"; // true is "asc", else false
    }
    purchase_sort($purchases, $sortby, $ascending);
} catch (OSMException $e) {
    handle_osmexception($e);
}

print_header("Home", "", $warnings);
?>
<h3>Add item</h3>

<?php

print_purchase_input_form($input_error, $form_format);

?>

<div class="row">
    <div class="col">
        <h3 class="mt-3">Items</h3>
        <p>Today's date: <?=date(OSM_DATE_FORMAT)?></p>
    </div>

    <div class="col d-flex justify-content-end mt-3">
        <?php print_sort_dropdown(); ?>
    </div>
</div>


<?php
// if purchases array is size 0, nothing input yet!
if (count($purchases) === 0) {
?>
    <p>No purchases in database.</p>
<?php
}

// loop through and print all purchases which we read from database earlier
foreach ($purchases as $id => $purchase) {
    print_purchase($purchase, $id);
}

print_footer();
?>
