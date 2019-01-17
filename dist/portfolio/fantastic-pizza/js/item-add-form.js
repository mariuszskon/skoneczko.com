const MIN_INPUT_QUANTITY = 0;
const MIN_SUBMIT_QUANTITY = 1;

// get first sub-element with class name
function gc(element, className) {
    return element.getElementsByClassName(className)[0];
}

/*
 * the following helper functions are designed with flexibility in mind
 * i.e. to allow for multiple item add forms on the same page
 */
function getItemAddForms() {
    return document.getElementsByClassName("item-add");
}

function getQuantityGroup(element) {
    return gc(element, "qty-group");
}

function getQuantityInput(quantityGroup) {
    // there should only be one, so assume so
    return quantityGroup.querySelector("input[name='qty']");
}

function getSizeOption(element) {
    return gc(element, "size-option").value;
}

function getPriceList(element) {
    return gc(element, "price-list");
}

function getPriceOutput(element) {
    return gc(element, "item-price");
}

function resetQuantityGroupValidity() {
    this.setCustomValidity(""); // clear/remove invalid message
}

function getPrices(priceList) {
    const priceCategories = ["s", "m", "l", "r"]; // small, medium, large, regular (regular when only one option)
    let priceListPrices = {};
    for (let priceCategory of priceCategories) {
        let matching = gc(priceList, priceCategory);
        if (matching !== undefined) {
            priceListPrices[priceCategory] = parseFloat(matching.innerHTML);
        }
    }

    return priceListPrices;
}

function updatePrice() {
    let prices = getPrices(getPriceList(this));
    let sizeOption = getSizeOption(this);
    let quantity = parseInt(getQuantityInput(getQuantityGroup(this)).value);

    let price = quantity * prices[sizeOption];
    price = isNaN(price) ? 0 : price; // fix case where input is empty/non-numeric

    let output = getPriceOutput(this);
    output.innerHTML = "$" + price.toFixed(2);
}

function attachOninput(quantityGroup) {
    let quantityInput = getQuantityInput(quantityGroup);
    quantityInput.oninput = resetQuantityGroupValidity;
}

function attachOnclick(quantityGroup) {
    let minusButton = quantityGroup.querySelector("button:first-child");
    let plusButton = quantityGroup.querySelector("button:last-child");
    let inputField = quantityGroup.querySelector("input[name='qty']");

    // use an IIFE to ensure fired functions target the right elements
    (function(minusBtn, plusBtn, inField) {
        minusBtn.onclick = function() {
            if (inField.value > MIN_INPUT_QUANTITY) {
                inField.value--;
                // forcing everything to update done by forcing an event as per this post:
                // https://stackoverflow.com/questions/136617/how-do-i-programmatically-force-an-onchange-event-on-an-input
                inField.dispatchEvent(new Event("input", {bubbles: true}));
            }
        };

        plusBtn.onclick = function() {
            inField.value++;
            inField.dispatchEvent(new Event("input", {bubbles: true}));
        };
    })(minusButton, plusButton, inputField);
}

function itemAddFormValidate(event) {
    let group = getQuantityGroup(event.target);
    let quantityInput = getQuantityInput(group);
    // utilises the HTML5 Constraint Validation API
    // https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation#Validating_forms_using_JavaScript
    if (quantityInput.value >= MIN_SUBMIT_QUANTITY) {
        quantityInput.setCustomValidity(""); // valid
        return true; // all good, value is minimum required
    } else {
        // setCustomValidity allows for the use of the :invalid pseudo-class
        quantityInput.setCustomValidity("Must order " + MIN_SUBMIT_QUANTITY + " or more.");
        quantityInput.reportValidity();
        return false;
    }
}

let itemAddForms = getItemAddForms();
for (let form of itemAddForms) {
    let group = getQuantityGroup(form);
    attachOnclick(group);
    attachOninput(group);
    form.oninput = updatePrice;
    form.dispatchEvent(new Event("input"));
    form.onsubmit = itemAddFormValidate;
}
