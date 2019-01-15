<?php

require_once __DIR__."/../util/constants.php";

/*
 * $purchase is a Purchase object with ID $id that will be displayed in HTML,
 * omitting printing the delete button if $delete_button is set to false
 * showing text rather than dropdown if $toggle_delivered is set to false
 */
function print_purchase($purchase, $id, $delete_button = true, $toggle_delivered = true) {
    $info = $purchase->getDetails();
    $status = $purchase->getStatusString();
    $days_since_purchase = $purchase->calculateDaysSincePurchase();

    $status_colours = [
        "arrived" => "text-success",
        "waiting" => "text-warning",
        "overdue" => "text-danger"
    ];

    $status_icons = [
        "arrived" => "fas fa-check",
        "waiting" => "far fa-clock",
        "overdue" => "fas fa-flag"
    ];

    $status_internal_to_human = [
        "arrived" => "Arrived",
        "waiting" => "Waiting",
        "overdue" => "Overdue"
    ];
?>
    <div class="card my-3">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                        <i class="big-icon <?=$status_icons[$status]?> <?=$status_colours[$status]?>"></i>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <h4 class="<?=$status_colours[$status]?>"><?=$status_internal_to_human[$status]?></h4>
                        <h3 class="card-title"><?=htmlspecialchars($info["name"])?></h3>
                        <h5 class="card-subtitle text-muted">Sold by <em><?=htmlspecialchars($info["seller_name"])?></em></h5>
                        <h5 class="card-text mt-2">
                            <?php
                            // print price to 2 decimal places
                            printf("$%.2f", $info["price"]);
                            ?>
                        </h5>
                    </div>
                    <div class="col-md mt-3 mt-md-0">
                        <p class="card-text">Purchased <br/><?=$info["purchase_datetime"]->format(OSM_DATE_FORMAT)?></p>
                        <p class="card-text">Delivery estimated <br/><?=$info["estimated_datetime"]->format(OSM_DATE_FORMAT)?></p>
                    </div>
                    <div class="col-md mt-3 mt-md-0">
                        <p class="card-text"><strong><?=$days_since_purchase?> day(s)</strong> since purchase</p>
                        <div class="card-text">Delivered:
                            <?php
                            if ($toggle_delivered) { // allow user to change delivered status through dropdown
                            ?>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$info["arrived"] ? "Yes" : "No"?></button>
                                    <form action="index.php" method="POST" class="dropdown-menu">
                                        <input name="id" type="hidden" value="<?=$id?>"/>
                                        <button name="delivered" value="<?=$info["arrived"] ? "n" : "y"?>" class="dropdown-item" type="submit"><?=$info["arrived"] ? "No" : "Yes"?></button>
                                    </form>
                                </div>
                            <?php
                            } else { // just say if it is delivered or not - do not show a dropdown
                            ?>

                                <strong><?=$info["arrived"] ? "Yes" : "No"?></strong>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    // only print delete button if we want it
                    if ($delete_button) {
                    ?>
                        <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-center align-items-center">
                            <p class="card-text">
                                <a class="btn btn-danger" href="delete.php?id=<?=$id?>"><i class="fas fa-times"></i> Delete</a>
                            </p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php

}
?>
