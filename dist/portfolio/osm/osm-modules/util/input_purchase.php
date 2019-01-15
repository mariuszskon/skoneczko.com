<?php

require_once __DIR__."/../purchase/Purchase.php";
require_once __DIR__."/../exceptions/ValidationException.php";

define("OSM_SUBMIT_BUTTON_NAME", "add_item");
define("OSM_INVALID_CSS_CLASS", "is-invalid");

/*
 * takes a Database object $db, and an associative array $form_format which is modified (by reference)
 * with is-invalid class if it is invalid
 * returning a string desccription of an error or "" if none
 */
function input_purchase($db, &$form_format) {
    if (!isset($_POST[OSM_SUBMIT_BUTTON_NAME])) { // form was not actually submitted in the first place
        return "";
    }

    $fields = [
        "name",
        "seller_name",
        "price",
        "purchased_date",
        "estimated_date"
    ];

    $error = "";
    $failed_fields = 0;

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== "") { // make sure everything is submitted
            $form_format[$field] = "";
        } else {
            $form_format[$field] = OSM_INVALID_CSS_CLASS;
            $error = "Not all form fields were filled.";
            $failed_fields++;
        }
    }

    // stop here if there was an error
    if ($error !== "") {
        return $error;
    }

    try {
        // both the Purchase class and relevant Database subclass are responsible for further validation
        $purchase = new Purchase($_POST[$fields[0]], $_POST[$fields[1]], $_POST[$fields[2]], $_POST[$fields[3]], $_POST[$fields[4]]);
        $db->savePurchase($purchase);
    } catch (ValidationException $e) {
        $form_format[$e->varname] = OSM_INVALID_CSS_CLASS;
        return $e->getMessage();
    }

    return $error;
}
?>
