// A Caesar cipher implementation with support for custom alphabets

var plaintext;
var key;
var illp;
var allp;

var alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
var origalphabet = alphabet;
var upperbet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
var lowandup = origalphabet.concat(upperbet);
var alphanumeric = lowandup.concat(["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]);

function gid(a) {
    return document.getElementById(a);
}

var plaintextbox = gid("plaintextbox");

var keybox = gid("keybox");

var outputbox = gid("outputbox");

function updatevars() {
    
    plaintext = plaintextbox.value;
    key = parseInt(keybox.value);
    illp = plaintext.length - 1; // the position of the last letter in the input
    allp = alphabet.length - 1; // the position of the last letter in the alphabet
    
}

function encrypt() {
    
    updatevars();
    
    var ciphertext = "";
    
    if (key < 1 || key > allp) {
        ciphertext = "Error: key was lower than 1 and greater than " + allp;
        outputbox.innerHTML = ciphertext;
        return; // end the function
    }
    
    for (var i = 0; i <= illp; i++) { // loop through all of the plaintext
        
        for (var j = 0; j <= allp; j++) { // loop through the alphabet
            
            if (plaintext.charAt(i) === alphabet[j]) { // if the letter is the same in the plaintext and in the alphabet
                
                var l = j + key; // the position of the current letter in the alphabet plus the key
                
                if (l > allp) { // if we are further than the alphabet
                    
                    l = l - allp - 1; // aka doing l - alphabet.length
                    
                }
                
                ciphertext += alphabet[l]; // put the ciphertext letter in the ciphertext
                
            }
            
        }
        
    }
    
    outputbox.innerHTML = ciphertext; // finally put it in the output box
    
}

function decrypt() {
    
    updatevars();
    
    var plainoutput = "";
    
    if (key < 1 || key > allp) {
        ciphertext = "Error: key was lower than 1 and greater than " + allp;
        outputbox.innerHTML = ciphertext;
        return; // end the function
    }
    
    for (var i = 0; i <= illp; i++) { // loop through all of the plaintext
        
        for (var j = 0; j <= allp; j++) { // loop through the alphabet
            
            if (plaintext.charAt(i) === alphabet[j]) { // if the letter is the same in the plaintext and in the alphabet
                
                var l = j - key; // the position of the current letter in the alphabet minus the key
                
                if (l < 0) {
                    
                    l = l + allp + 1; // we need to add the length of the alphabet to make it above 0
                    
                }
                
                plainoutput += alphabet[l]; // put the ciphertext letter in the ciphertext
                
            }
            
        }
        
    }
    
    outputbox.innerHTML = plainoutput; // finally put it in the output box
    
}


document.getElementById("encryptbtn").addEventListener("click", encrypt);

document.getElementById("decryptbtn").addEventListener("click", decrypt);
