<?php

/*
 * print_header($subtitle, $db_error, $warnings) - print the common first lines of each webpage, inserting $subtitle into the title tag
 * displaying $db_error if non-empty and displaying all warnings
 */
function print_header($subtitle, $db_error = "", $warnings = []) {
?><!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="vendor/css/bootstrap-4.1.1.min.css">
            <link rel="stylesheet" href="vendor/css/fontawesome-all-5.1.0.css">
            <link href="css/styles.css" rel="stylesheet">

            <title>Online Shopping Manager - <?=$subtitle?></title>
        </head>
        <body>
            <nav class="navbar navbar-dark bg-secondary mb-3">
                <div class="container">
                    <a class="navbar-brand mb-0 h1" href="index.php"><i class="fas fa-home"></i> <span class="d-inline-block d-md-none">OSM</span> <span class="d-none d-md-inline-block">Online Shopping Manager</span></a>
                    <form action="search.php" class="form-inline">
                        <div class="input-group">
                            <input name="q" class="form-control" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i> <strong>Search</strong></button>
                            </div>
                        </div>
                    </form>
                </div>
            </nav>

            <div class="container">
                <?php
                foreach ($warnings as $warning) {
                ?>
                    <div class="alert alert-warning" role="alert">Warning - <?=htmlspecialchars($warning)?></div>
                <?php
                }
                if ($db_error !== "") {
                ?>
                    <div class="alert alert-danger" role="alert">Irrecoverable database error - <?=htmlspecialchars($db_error)?></div>
                <?php
                }
                ?>
<?php
}

// print_footer() - print the common last lines of each webpage
function print_footer() {
?>
            </div>

            <script src="vendor/js/jquery-3.3.1.slim.min.js"></script>
            <script src="vendor/js/bootstrap-4.1.1.bundle.min.js"></script>
        </body>
    </html>
<?php
}

?>
