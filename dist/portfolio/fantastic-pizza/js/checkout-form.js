const VISA_REGEX = /^4(\d ?){12,15}$/;

let creditCardInput = document.getElementById("card");

creditCardInput.oninput = function() {
    let errorMsgs = this.parentElement.getElementsByClassName("error");
    for (let errorMsg of errorMsgs) {
        this.parentElement.removeChild(errorMsg);
    }

    let logo = this.parentElement.getElementsByClassName("visa-small")[0];
    logo.style.display = "inline";

    if (this.value.match(VISA_REGEX)) {
        logo.style.opacity = 1;
    } else {
        logo.style.opacity = 0;
    }

}
