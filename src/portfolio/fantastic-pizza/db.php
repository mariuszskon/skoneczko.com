<?php

define("PRODUCTS_FILENAME", "products.txt");
define("ORDERS_FILENAME", "orders.txt");
define("CSV_FIELD_DELIMITER", "\t");

function get_csv_headings($file) {
    return fgetcsv($file, 0, CSV_FIELD_DELIMITER);
}

function get_all_products() {
    $products = [];
    $file = fopen(PRODUCTS_FILENAME, "rb"); // read binary - binary to ensure newline consistency regardless of platform

    if ($file === false) {
        die("Could not find " . PRODUCTS_FILENAME);
    }

    flock($file, LOCK_SH);
    $headings = get_csv_headings($file);
    while (($entry = fgetcsv($file, 0, CSV_FIELD_DELIMITER)) !== false) {
        $data = [];
        foreach ($entry as $key => $value) {
            $data[$headings[$key]] = $value;
        }

        $id = $data["id"];
        $oid = $data["oid"];
        unset($data["id"]);
        unset($data["oid"]);

        if (!isset($products[$id])) $products[$id] = [];
        if (!isset($products[$id][$oid])) $products[$id][$oid] = [];

        foreach ($data as $key => $value) {
            $products[$id][$oid][$key] = $value;
        }

    }
    flock($file, LOCK_UN);
    fclose($file);

    return $products;
}

function save_order($order) {
    return; // disable saving to file for public portfolio


    // details which remain the same for every item (i.e. date, mobile phone)
    $flatOrderDetails = array_merge(
        ["date" => $order["date"]],
        $order["customer"]
    );

    // generate array of every option of item (only 2D)
    $items = [];
    foreach ($order["cart"] as $id => $itemGroup) {
        foreach ($itemGroup as $oid => $data) {
            $items[] = array_merge(
                [
                    "id" => $id,
                    "oid" => $oid
                ],
                $data
            );
        }
    }

    // get heading information so we know what to insert
    $file = fopen(ORDERS_FILENAME, "rb");
    flock($file, LOCK_SH);
    $headings = get_csv_headings($file);
    flock($file, LOCK_UN);
    fclose($file);

    // generate the records - 1D numeric index array in order of headings of database
    $records = [];
    foreach ($items as $item) {
        $record = [];
        foreach ($headings as $heading) {
            if (isset($flatOrderDetails[$heading])) {
                $record[] = $flatOrderDetails[$heading];
            } else if (isset($item[$heading])) {
                $record[] = $item[$heading];
            } else {
                // we don't have a heading which the db needs!
            }
        }

        $records[] = $record;
    }

    // open file for writing
    $file = fopen(ORDERS_FILENAME, "ab");
    flock($file, LOCK_EX);

    // write what the database needs
    foreach ($records as $record) {
        fputcsv($file, $record, CSV_FIELD_DELIMITER);
    }

    flock($file, LOCK_UN);
    fclose($file);
}

?>
