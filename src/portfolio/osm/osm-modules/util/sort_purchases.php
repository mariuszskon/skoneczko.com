<?php

/*
 * purchase_sort - takes an associative array of purchases by reference (for efficient sorting)
 * $sortby is either "since" or "deliv" to sort by days since purchase or estimated delivery date respectively
 * (else array is simply reversed to make last added purchases appear on top)
 * $ascending is a boolean to determine if sorting should be done in ascending or descending order
 * this uses PHP's uasort which implements the quicksort sorting algorithm with user-defined comparisons
 */
function purchase_sort(&$purchases, $sortby, $ascending) {
    if ($sortby === "since") {
        uasort($purchases, "cmp_purchase_since");
    } else if ($sortby === "deliv") {
        uasort($purchases, "cmp_purchase_deliv");
    } else {
        $ascending = false; // we just want reverse order to make most recently added purchases on top
    }

    if ($ascending === false) {
        $purchases = array_reverse($purchases, true); // true here means we preserve keys in associative array
    }
}

/* the below comparison functions fulfil the php usort specification by returning -1, 0 or 1
   depending on where an element should be relative to another */

function cmp_purchase_since($a, $b) {
    // compare by datetime rather than just days for intuitive sorting (e.g. things purchased at different times in same day sorted correctly)
    $adate = $a->getDetails()["purchase_datetime"];
    $bdate = $b->getDetails()["purchase_datetime"];
    if ($adate === $bdate) {
        return 0;
    }
    // we are comparing by "days since" meaning inequality operator has to be reversed as a higher date means fewer days difference
    return ($adate < $bdate) ? 1 : -1;
}

function cmp_purchase_deliv($a, $b) {
    $adate = $a->getDetails()["estimated_datetime"];
    $bdate = $b->getDetails()["estimated_datetime"];
    if ($adate === $bdate) {
        return 0;
    }
    return ($adate > $bdate) ? 1 : -1;
}
?>
