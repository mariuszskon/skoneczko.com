<?php

require_once __DIR__."/print_header_footer.php";
require_once __DIR__."/handle_osmexception.php";
// require_once __DIR__."/../db/TextDatabase.php";
require_once __DIR__."/../db/SessionDatabase.php";
require_once __DIR__."/../exceptions/OSMException.php";

$db = null;

try {
    // $db = new TextDatabase(OSM_DEFAULT_FILE);
    $db = new SessionDatabase();
} catch (OSMException $e) {
    handle_osmexception($e);
}
?>
