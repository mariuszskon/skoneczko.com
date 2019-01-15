<?php

require_once __DIR__."/OSMException.php";

class ValidationException extends OSMException {
    public $varname;
    // not only do we take a message like normal Exceptions, but also the variable name to ensure we know exactly what is invalid
    public function __construct($message, $varname) {
        parent::__construct($message);
        $this->varname = $varname;
    }
}

?>
