<?php $pagetitle = "Web browser support";
$postdate = "15th August 2015";
require "../../../includes/header.php"; ?>
<p>So, as a web developer, the web browsers are the best and worst part of development.<br>
    They are the best, because they render code in a pretty fashion and usually with lots of nice features, but they are the worst when they are outdated. Outdated browsers can't handle awesome shiny new stuff (which is <strong>the</strong> best part of web development), but they also do things differently to modern browsers forcing you to work around issues that you shouldn't have to. Additionally, the old browsers make it a painful to have "mobile first" layouts, because they don't support media queries! Now, you can guess who the offender is. </p>
<p>Internet Explorer<br>
    Don't get me wrong: the modern versions of IE are actually fine at supporting modern web standards. Heck, IE is what forced Netscape out and introduced (albeit primitive versions of) things like AJAX. The problem with Internet Explorer is this: it doesn't update itself, like essentially all of the other browsers. Microsoft is luckily pushing users to upgrade, and the deprecation of Windows XP at least makes IE6 practically dead. The lowest version of IE which is find acceptable to support at this time is IE9. Why? Well, there are many reasons. Firstly, most Windows 7 users at least have IE9 (some which have never connected to the internet might still have 8). Also, IE9 introduces many features which are essential to creating modern websites and web applications. This includes: </p>
    <ul>
        <li>CSS media queries</li>
        <li>CSS3 selector support</li>
        <li>SVG</li>
        <li>EcmaScript 5 (JavaScript)</li>
        <li>Semantic elements (&lt;article&gt;, &lt;header&gt;, &lt;nav&gt; etc.)</li>
    </ul><p>That's cool. I can easily live with that. I can't make shiny CSS animations for everyone, but at least I can use good selectors, make the browser show it's screen size's layout, have nice SVG images, use great HTML5 semantic elements and take advantage of useful JavaScript features.</p>
<p>If you want to compare the features of different IE versions, you can't go wrong with <a href="http://caniuse.com/#compare=ie+7,ie+8,ie+9,ie+10,ie+11">caniuse.com</a>.<br>
    Luckily, you can easily add a warning message to users of browsers you don't like. Simply add a special IE conditional comment: </p>
    <pre>&lt;!--[if lt IE 9]&gt;
    &lt;p class="warn"&gt;You are using Internet Explorer lower than 9.&lt;br /&gt;Please &lt;a href="http://browsehappy.com/"&gt;upgrade your browser&lt;/a&gt; to make the most of the web.&lt;/p&gt;
&lt;![endif]--&gt;
    </pre><p>These conditional comments are simply comments in modern browsers, but IE can interpret them, and if the conditions are met (IE is lower than 9) show the contents. However, you are not limited to simply showing content. You can make old versions of IE load things like <a href="https://github.com/aFarkas/html5shiv">html5shiv</a> to make older browsers more manageable.<br><br>
I hope I taught you something ;)

</p>
<?php require "../../../includes/footer.php" ?>
