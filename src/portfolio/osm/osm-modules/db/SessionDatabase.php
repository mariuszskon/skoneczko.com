<?php

require_once __DIR__."/Database.php";
require_once __DIR__."/../util/constants.php";
require_once __DIR__."/../purchase/Purchase.php";
require_once __DIR__."/../exceptions/ValidationException.php";
require_once __DIR__."/../exceptions/OSMException.php";

define("OSM_SESSDB_KEY", "OSM_DB");

class SessionDatabase extends Database {
    public function __construct() {
        session_start();

        if (!isset($_SESSION[OSM_SESSDB_KEY])) {
            $_SESSION[OSM_SESSDB_KEY] = [];
        }
    }

    public function getAllIds() {
        $ids = [];
        foreach($_SESSION[OSM_SESSDB_KEY] as $id => $purchase) {
            $ids[] = $id;
        }
        return $ids;
    }

    public function getById($id) {
        $this->validateId($id);
        return $_SESSION[OSM_SESSDB_KEY][$id];
    }

    public function savePurchase($purchase) {
        $_SESSION[OSM_SESSDB_KEY][] = $purchase;
        return max(array_keys($_SESSION[OSM_SESSDB_KEY]));
    }

    public function saveAll() {
        return; // empty because we already edit the values in place directly in the $_SESSION array
    }

    public function deleteById($id) {
        $this->validateId($id);
        unset($_SESSION[OSM_SESSDB_KEY][$id]);
    }

    private function validateId($id) {
        if (!isset($_SESSION[OSM_SESSDB_KEY][$id])) {
            throw new ValidationException("ID '$id' does not exist.", "id");
        }
    }
}

?>
