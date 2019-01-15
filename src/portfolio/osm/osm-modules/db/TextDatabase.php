<?php

require_once __DIR__."/Database.php";
require_once __DIR__."/../util/constants.php";
require_once __DIR__."/../purchase/Purchase.php";
require_once __DIR__."/../exceptions/ValidationException.php";
require_once __DIR__."/../exceptions/OSMException.php";

define("OSM_NUM_PROPERTIES_PER_ENTRY", 6);

class TextDatabase extends Database {
    private $file_name;
    private $purchases;

    /*
     * TextDatabase constructor takes $file_name, which is name of database file relative to
     * the document root of the server (i.e. public directory)
     */
    public function __construct($file_name) {
        $this->file_name = $_SERVER["DOCUMENT_ROOT"]."/".$file_name;
        $this->readFile();
    }

    private function readFile() {
        if (!file_exists($this->file_name)) {
            // create the file
            if (touch($this->file_name) == false) {
                throw new OSMException("Could not create a new database file.");
            }
        }

        $fp = fopen($this->file_name, "r");
        if ($fp === false) {
            throw new OSMException("Could not open database file for reading.");
        }

        $purchase_strings = [];
        while (($data = fgetcsv($fp)) !== false) {
            $purchase_strings[] = $data;
        }

        fclose($fp);

        // convert all individual purchase data to Purchase objects
        foreach ($purchase_strings as $purchase_data) {
            $this->stringToPurchase($purchase_data);
        }
    }

    private function stringToPurchase($purchase_data) {
        $actual_prop_count = count($purchase_data);
        if ($actual_prop_count != OSM_NUM_PROPERTIES_PER_ENTRY) {
            throw new ValidationException("Incorrect number of properties: got $actual_prop_count, expected " .
                                          OSM_NUM_PROPERTIES_PER_ENTRY . ".", "actual_prop_count");
        }

        $purchase = new Purchase($purchase_data[0], // name
                                 $purchase_data[1], // seller_name
                                 (float)$purchase_data[2], // price
                                 $purchase_data[3], // purchased_date
                                 $purchase_data[4] // estimated_date
        );
        if ($purchase_data[5] === "true") {
            $purchase->setArrived(true);
        } else if ($purchase_data[5] === "false") {
            $purchase->setArrived(false);
        } else {
            throw new ValidationException("Database invalid: '".$purchase_data[5]."' is neither true or false.", "estimated_date");
        }

        // finally, we can append this valid purchase to our array
        $this->purchases[] = $purchase;
    }

    public function getAllIds() {
        // make an array of numbers from 0 to n-1 where n is number of purchases (i.e. ids are index of purchase in array)
        $num_purchases = count($this->purchases);
        $ids = [];
        for ($id = 0; $id < $num_purchases; $ids[] = $id++);
        return $ids;
    }

    public function getById($id) {
        $this->validateId($id);
        return $this->purchases[$id];
    }

    public function savePurchase($purchase) {
        $details = $this->detailsToStrings($purchase->getDetails());
        $this->purchases[] = $purchase;
        $this->saveAll();
        return count($this->purchases) - 1; // ID of new purchase
    }

    private function detailsToStrings($details) {
        $strings = [];
        $strings["name"] = $details["name"];
        $strings["seller_name"] = $details["seller_name"];
        $strings["price"] = (string)$details["price"];
        $strings["purchase_date"] = $details["purchase_datetime"]->format(OSM_DATE_FORMAT);
        $strings["estimated_date"] = $details["estimated_datetime"]->format(OSM_DATE_FORMAT);
        $strings["arrived"] = $details["arrived"] ? "true" : "false";
        return $strings;
    }

    public function saveAll() {
        $all = [];
        foreach ($this->purchases as $purchase) {
            $details = $this->detailsToStrings($purchase->getDetails());
            $all[] = $details;
        }

        $this->writeFile($all);
    }

    // writeFile($array_of_details) - saves an array of detailsToStrings associative arrays into a text file for reading by readFile
    private function writeFile($array_of_details) {
        $fp = fopen($this->file_name, "w");
        if ($fp === false) {
            throw new OSMException("Could not open database file for writing.");
        }

        foreach ($array_of_details as $purchase) {
            fputcsv($fp, $purchase);
        }

        fclose($fp);
    }

    // validateId($id) - checks if an id exists in the database
    private function validateId($id) {
        if (array_search($id, $this->getAllIds()) === false) {
            throw new ValidationException("ID '$id' does not exist.", "id");
        }
    }

    public function deleteById($id) {
        $this->validateId($id);
        unset($this->purchases[$id]);
        $this->saveAll();
    }
}
?>
