<?php

require_once __DIR__."/print_header_footer.php";

function handle_osmexception($e) {
    print_header("Error", $e->getMessage());
    print_footer();
    die(); // prevent the application from continuing, since we have an irrecoverable error
}
?>
