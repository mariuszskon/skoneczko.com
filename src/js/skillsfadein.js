// fade in each item in the "skills" list one after the other

(function() {
    var sli = document.querySelectorAll(".skills > li");
    for (var i = 0; i < sli.length; i++) {
        sli[i].classList.add("anim-skill-item", "anim-skill-left");

        (function(index, skillli) {
            setTimeout(function() {
            skillli[index].classList.remove("anim-skill-left");
            }, index * 500 + 1200);
        })(i, sli);
    }
})();
