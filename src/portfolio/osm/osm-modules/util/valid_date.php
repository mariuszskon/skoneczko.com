<?php

require_once __DIR__."/../exceptions/ValidationException.php";

function valid_date($date_string, $varname) {
    $dt = DateTime::createFromFormat(OSM_DATE_FORMAT, $date_string);
    if ($dt === false) {
        throw new ValidationException("Date '$date_string' is not in the expected format of '" . OSM_DATE_HUMAN_FORMAT . "'.", $varname);
    }

    /*
     * format method of DateTime always returns a valid date, but the input might not have been valid
     * and DateTime might make some guesses to force it to be valid, which we don't want (e.g. 31/11/2018 becomes 1/12/2018)
     * so to validate, we compare output against input (and print a helpful message)
     * subtly different date formats (e.g. leading zeroes) must also be taken into account to avoid false positives
     */
    $valid = false;
    foreach (OSM_INPUT_DATE_FORMATS as $acceptable_format) {
        if ($dt->format($acceptable_format) === $date_string) {
            $valid = true;
            break; // valid date format found, don't need to try more
        }
    }
    if (!$valid) {
        $definitely_valid = $dt->format(OSM_DATE_FORMAT);
        throw new ValidationException("Date '$date_string' not valid, did you mean '$definitely_valid'?", $varname);
    }

    return $dt; // success! valid date
}

?>
