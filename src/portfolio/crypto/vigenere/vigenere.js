// vigenere.js

var alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

function gid(id) {
    return document.getElementById(id);
}

var inputbox = gid("input");

var outputbox = gid("output");

var keybox = gid("key");

var encryptbtn = gid("encryptbtn");

var decryptbtn = gid("decryptbtn");

var input, key;

function updatevars() {
    // strip spaces
    input = inputbox.value.replace(/ /g, "");
    key = keybox.value.replace(/ /g, "");
}

function getKeyLetterAlphabetPosition(number) { // take number as the position of the input letter, so that we can match it with a key letter
    var keyLetterPosition = number % key.length; // % uses modular arithmetic to "loop around", matching a number to the key letter position
    
    var keyLetterAtPosition = key.charAt(keyLetterPosition);
    
    return alphabet.indexOf(keyLetterAtPosition);
}

function crypt(mode) {
    updatevars();
    
    var finaloutput = "";
    
    var beginTime = (new Date()).getTime();
    
    for (var i = 0; i < input.length; i++) {
        
        if (input.charAt(i) == "\n") {
            
            continue; // it's a newline: we don't need to keep going - go straight to the next letter
            
        }
        
        var j = alphabet.indexOf(input.charAt(i));
        
        var finalLetterPosition = "";
        
        if (mode === true) { // encryption mode
            
            finalLetterPosition = (j + getKeyLetterAlphabetPosition(i)) % alphabet.length; // add the position of the original letter witht he alphabet position of the corresponding key letter, and wrap around the alphabet length
            
        } else if (mode === false) { // decryption mode
            
            var possibleLetterPosition = (j - getKeyLetterAlphabetPosition(i));
            
            if (possibleLetterPosition < 0) {
                finalLetterPosition = possibleLetterPosition + alphabet.length; // if the number is negative, "loop around" by adding the length of the alphabet to it
            } else {
                finalLetterPosition = possibleLetterPosition;
            }
            
        }
        
        finaloutput += alphabet[finalLetterPosition]; // get the actual letter and add it to the finaloutput
        
    }
    
    var endTime = (new Date()).getTime();
    
    console.log("Ciphering operation took " + (endTime - beginTime) + " millisecond(s)");
    
    outputbox.innerHTML = finaloutput;
}

function encrypt() {
    crypt(true);
}

function decrypt() {
    crypt(false);
}

encryptbtn.addEventListener("click", encrypt);

decryptbtn.addEventListener("click", decrypt);
