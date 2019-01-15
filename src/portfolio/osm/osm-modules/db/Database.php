<?php

abstract class Database {
    // returns an array of valid IDs each of which can safely be passed to getById
    abstract public function getAllIds();
    // returns Purchase object corresponding to ID
    abstract public function getById($id);
    // writes a Purchase object to the database, returning its new ID
    abstract public function savePurchase($purchase);
    // after modifying a Purchase object, something can call saveAll to flush it to persistent storage
    abstract public function saveAll();
    // deletes the purchase with id $id
    abstract public function deleteById($id);

    // returns an associative array in the form $id => $purchase of purchases whose names match query
    public function searchByName($query) {
        $ids = $this->getAllIds();
        $results = [];
        foreach ($ids as $id) {
            $purchase = $this->getById($id);
            $details = $purchase->getDetails();
            // if $query is a case-insensitive substring of name
            if (stripos($details["name"], $query) !== false) {
                $results[$id] = $purchase;
            }
        }

        return $results;
    }
}

?>
