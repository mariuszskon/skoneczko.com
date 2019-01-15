<?php

require_once "osm_modules_dir_const.php";
require_once OSM_MODULES_DIR."/base/base.php";
require_once OSM_MODULES_DIR."/purchase/print_purchase.php";
require_once OSM_MODULES_DIR."/exceptions/OSMException.php";

try {
    $query = "";
    if (isset($_GET["q"])) {
        $query = $_GET["q"];
    }

    // make sure queries with special characters such as < are safe to display
    $display_query = htmlspecialchars($query);

    $purchases = $db->searchByName($query);
} catch (OSMException $e) {
    handle_osmexception($e);
}
print_header("Search results for \"$display_query\"");
?>
<h3>Search results for "<?=$display_query?>"</h3>

<?php
if (count($purchases) === 0) { // array is empty (size 0)
?>
    <p>No results.</p>
<?php
}

// loop through and print all found purchases
foreach ($purchases as $id => $purchase) {
    print_purchase($purchase, $id);
}

print_footer();
?>
