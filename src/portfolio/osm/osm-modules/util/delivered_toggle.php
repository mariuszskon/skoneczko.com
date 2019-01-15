<?php

function delivered_toggle($db) {
    // check if a request to toggle was actually made
    if (isset($_POST["id"]) && isset($_POST["delivered"])) {
        $purchase = $db->getById($_POST["id"]);

        // set arrived status to true if "y" is sent, else set it to false
        $purchase->setArrived($_POST["delivered"] === "y");

        $db->saveAll(); // make sure change persists
    }
}
?>
