<?php

require_once __DIR__."/../util/constants.php";

function print_purchase_input_form($input_error, $form_format) {
    $prefill = [
        "name"=>"",
        "seller_name"=>"",
        "price"=>"",
        "purchased_date"=>"",
        "estimated_date"=>""
    ];
    if ($input_error !== "") {
        // we should pre-fill the form with the user's input so they can correct it without retyping
        foreach (array_keys($prefill) as $varname) {
            $prefill[$varname] = htmlspecialchars($_POST[$varname]);
        }
    }
?>
    <form class="mt-3" action="index.php" method="POST">
        <div class="form-row">
            <?php
            print_single_property_input($form_format, "name", "Product name", $prefill["name"]);
            print_single_property_input($form_format, "seller_name", "Seller", $prefill["seller_name"]);

            // price is numeric and is handled differently
            ?>

            <div class="form-group col-md-2">
                <label class="mb-0" for="price">Price</label>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">$</div>
                    </div>
                    <input id="price" name="price" type="number" class="form-control <?=$form_format["price"]?>" min="0.01" step="0.01" value="<?=$prefill["price"]?>"/>
                </div>
            </div>

            <?php
            print_single_property_input($form_format, "purchased_date", "Purchased",
                                        $prefill["purchased_date"], OSM_DATE_HUMAN_FORMAT);
            print_single_property_input($form_format, "estimated_date", "Estimated arrival",
                                        $prefill["estimated_date"], OSM_DATE_HUMAN_FORMAT);
            ?>
        </div>
        <div class="form-row">
            <div class="col-md">
                <button name="add_item" type="submit" class="btn btn-secondary my-2"><i class="fas fa-plus"></i> Add</button>
            </div>
        </div>
    </form>
    <?php

    if ($input_error !== "") {
    ?>
        <div class="alert alert-warning" role="alert"><?=htmlspecialchars($input_error)?></div>
    <?php
    }
    ?>
<?php
}

/*
 * prints a single text input field for the variable $varname with the displayed name $display_name
 * placeholder $placeholder and pre-filled contents $value
 */
function print_single_property_input($form_format, $varname, $display_name, $value, $placeholder = "") {
?>
    <div class="form-group col-md">
        <label class="mb-0" for="<?=$varname?>"><?=$display_name?></label>
        <input id="<?=$varname?>" name="<?=$varname?>" type="text" class="form-control mt-2 <?=$form_format[$varname]?>" placeholder="<?=$placeholder?>" value="<?=$value?>"/>
    </div>
<?php
}
?>
