<?php

require_once "osm_modules_dir_const.php";
require_once OSM_MODULES_DIR."/base/base.php";
require_once OSM_MODULES_DIR."/purchase/print_purchase.php";
require_once OSM_MODULES_DIR."/exceptions/OSMException.php";

try {
    if (isset($_GET["id"])) { // if we came here from pressing the delete button
        $id = $_GET["id"];
        $purchase = $db->getById($id);
        $details = $purchase->getDetails();
        // make sure special characters such as < can be shown safely
        $display_name = htmlspecialchars($details["name"]);
    } else if (isset($_POST["id"]) && isset($_POST["confirm"])) { // we are here because user confirmed or denied deletion
        $id = $_POST["id"];
        if ($_POST["confirm"] === "y") {
            $db->deleteById($id);
        }
        // since user pressed either the confirmation or deny button, we should redirect them to the home page
        header("Location: index.php");
        die(); // stop execution to prevent strange bugs
    } else {
        // this is only possible if the URL was manually manipulated
        throw new OSMException("Insufficient input for deletion provided.");
    }
} catch (OSMException $e) {
    handle_osmexception($e);
}

print_header("Delete \"$display_name\"?");
?>
<h3>Are you sure you want to delete the item "<?=$display_name?>"?</h3>
<?php
print_purchase($purchase, $id, false, false);
?>
<div class="mt-3 d-flex justify-content-center">
    <form action="delete.php" method="POST">
        <input name="id" type="hidden" value="<?=htmlspecialchars($id)?>">
        <button class="btn btn-lg btn-danger" type="submit" name="confirm" value="y">Yes, delete it</button>
        <button class="btn btn-lg btn-success" type="submit" name="confirm" value="n">Don't delete</button>
    </form>
</div>

<?php
print_footer();
?>
