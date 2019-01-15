<?php

define("OSM_INPUT_DATE_FORMATS", ["d/m/Y", "j/m/Y", "d/n/Y", "j/n/Y"]);
define("OSM_DATE_FORMAT", OSM_INPUT_DATE_FORMATS[1]);
define("OSM_DATE_HUMAN_FORMAT", "dd/mm/yyyy");
// store file outside of document directory to prevent unwanted access
define("OSM_DEFAULT_FILE", "../osm_db.txt");
?>
