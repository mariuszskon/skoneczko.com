<?php
require_once("tools.php");

define("THUMB_IMAGE_SUFFIX", "-thumb.jpg");
define("IMAGE_SUFFIX", ".jpg");

function print_short_product($product, $id) {
    $details = $product[array_keys($product)[0]]; // print details for first option of a product
?>
    <li class="menu-item">
        <img alt="<?=htmlspecialchars("Photo of \"{$details['title']}\". See description for details.")?>" src="<?=MEDIA_DIR.$id.THUMB_IMAGE_SUFFIX?>"/>
        <div class="menu-item-content">
            <h3><a href="products.php?id=<?=$id?>"><?=$details["title"]?></a></h3>
            <p class="description"><?=$details["description"]?></p>
        </div>
        <ol class="prices">
            <?php
            foreach($product as $oid => $data) { ?>
                <li><?=money($data["price"])?></li>
            <?php
            }
            ?>
        </ol>
    </li>
<?php
}

$products = get_all_products();

if (isset($_GET["id"]) && isset($products[$_GET["id"]])) {
    // display one product's information
    $id = $_GET["id"];
    $product = $products[$id];
    $details = $product[array_keys($product)[0]]; // only read first option for description etc. (default)

    top_module("Fantastic Pizza - {$details['title']}");
?>

<section>
    <h1><?=$details["title"]?></h1>
    <div class="detail">
        <img class="detail-image" alt="<?=htmlspecialchars("Photo of \"{$details['title']}\". See description for details.")?>" src="<?=MEDIA_DIR.$id.IMAGE_SUFFIX?>"/>
        <p class="detail-description"><?=$details["description"]?></p>
        <p class="nutritional-info">Nutritional information: Approximate total energy content provided upon request. May contain traces of nuts, gluten, and dairy.</p>
    </div>
    <form class="item-add" action="cart.php" method="post">
        <div>
            <h3>Order now</h3>
        </div>
        <input name="id" type="hidden" value="<?=$id?>"/>
        <div>
            <label for="<?=$id?>_option">Size</label>
            <select id=<?=$id?>_option" class="size-option" name="option">
                <?php
                foreach ($product as $oid => $data) { ?>
                    <option value="<?=$oid?>"><?=$data["option_human"]?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label for="<?=$id?>_qty">Quantity</label>
            <div class="qty-group">
                <button type="button">-</button>
                <input id="<?=$id?>_qty" name="qty" type="number" value="0" min="0" step="1" />
                <button type="button">+</button>
            </div>
        </div>
        <div class="price-list" title="Price in dollars, for one unit of each size.">
                <?php
                foreach ($product as $oid => $data) { ?>
                    <p class="<?=$oid?>"><?=money($data["price"], '') // currency of '' so $ is omitted (value used by javascript only)?></p>
                <?php
                }
                ?>
        </div>
        <div>
            <p class="calculated-price">Price: <span class="item-price"></span></p>
        </div>
        <button class="big-button" type="submit">Add</button>
    </form>
</section>

<?php
} else { // display the entire menu as no (valid) id was given
    top_module("Fantastic Pizza - Menu");
    $categorised = categorise_products($products);

?>

    <article>
        <h1>Menu</h1>
        <!-- IMAGE SOURCES -->
        <!-- CC BY-SA 2.0 image used for educational purposes from https://www.flickr.com/photos/pjlewis/57033748 -->
        <!-- CC BY 3.0 image used for educational purposes from https://commons.wikimedia.org/wiki/File:Pizza_Hut_Meat_Lover%27s_pizza_2.JPG -->
        <!-- public domain image used for educational purposes from https://pixnio.com/food-and-drink/pizza/home-made-vegetarian-pizza-with-olives-and-capsicum -->
        <!-- CC0 image used for educational purposes from https://www.maxpixel.net/Cucumber-Radishes-Salad-Tomato-Mixed-Salad-Healthy-609666 -->
        <!-- CC0 image used for educational purposes from https://www.publicdomainpictures.net/en/view-image.php?image=9035&picture=greek-salad-on-plate -->

        <?php
        foreach($categorised as $category => $subproducts) {
            if (count($subproducts) < 1) continue; // skip empty categories (e.g. fallback "Miscellaneous" category)
        ?>
            <section>
                <h2><?=$category?></h2>
                <ol class="menu">
                    <?php
                    foreach ($subproducts as $id => $product) {
                        print_short_product($product, $id);
                    } ?>
                </ol>
            </section>
        <?php
        }
        ?>
    </article>
<?php
} // end else (printing whole menu because no specific item selected)

bottom_module();
?>
