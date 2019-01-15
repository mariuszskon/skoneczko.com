<?php

function print_sort_dropdown() {
?>
    <div class="dropdown">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="sortMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sort...
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="?sort=since&order=asc">Purchased date: most recent first</a>
            <a class="dropdown-item" href="?sort=since&order=dsc">Purchased date: oldest first</a>
            <a class="dropdown-item" href="?sort=deliv&order=asc">Estimated delivery: earliest first</a>
            <a class="dropdown-item" href="?sort=deliv&order=dsc">Estimated delivery: latest first</a>
        </div>
    </div>
<?php
}

?>
