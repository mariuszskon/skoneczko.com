<?php

require_once __DIR__."/../util/constants.php";
require_once __DIR__."/../util/valid_date.php";
require_once __DIR__."/../exceptions/ValidationException.php";

class Purchase {
    private $name;
    private $seller_name;
    private $price;
    private $purchase_datetime;
    private $estimated_datetime;
    private $arrived;

    public function __construct($name, $seller_name, $price, $purchased_date, $estimated_date) {
        $this->name = $name;
        $this->seller_name = $seller_name;
        if (!is_numeric($price) || $price <= 0) {
            throw new ValidationException("Price must be a positive, non-zero decimal.", "price");
        }
        $this->price = $price;
        $this->purchase_datetime = valid_date($purchased_date, "purchased_date");
        if ($this->purchase_datetime > new DateTime("now")) {
            throw new ValidationException("Purchased date occurs in the future.", "purchased_date");
        }

        $this->estimated_datetime = valid_date($estimated_date, "estimated_date");

        if ($this->estimated_datetime < $this->purchase_datetime) {
            throw new ValidationException("Estimated arrival date occurs before purchase date.", "estimated_date");
        }
        $this->arrived = false;
    }

    public function getDetails() {
        return [
            "name" => $this->name,
            "seller_name" => $this->seller_name,
            "price" => $this->price,
            "purchase_datetime" => $this->purchase_datetime,
            "estimated_datetime" => $this->estimated_datetime,
            "arrived" => $this->arrived
        ];
    }

    public function setArrived($value) {
        // expected true or false
        $this->arrived = $value;
    }

    // returns either "waiting", "arrived", or "overdue"
    public function getStatusString() {
        if ($this->arrived) {
            return "arrived";
        }

        if ($this->estimated_datetime >= new DateTime("now")) {
            // waiting if estimated arrival is in the future
            return "waiting";
        } else {
            return "overdue";
        }
    }

    public function calculateDaysSincePurchase() {
        return $this->purchase_datetime->diff(new DateTime("now"))->days;
    }
}
?>
