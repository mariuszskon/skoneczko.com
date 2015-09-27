<?php $pagetitle = "Do You Need jQuery?";
$postdate = "27th September 2015";
require "../../../includes/header.php"; ?>
<p>jQuery. The JavaScript library that has improved the lives of web developers around the world. But it is also the library which makes new web developers scared of <a href="http://vanilla-js.com/">vanilla JS</a>. Back when IE6 still needed to be supported, jQuery truly shined. It allowed the use of fancy CSS selectors, using Ajax in a cross-browser way, having nice animations, and in general giving a layer that saved time because we didn't need to write tons of if statements and weird hacks. However, those days are over.</p>
<p>Modern browsers can do all of the things that jQuery does, and more. After all, jQuery is simply a JavaScript library. The problem which arises these days is that some developers don't know how to do things that jQuery does with plain JavaScript! So I got a list of things which everyone should know how to do <strong>without</strong> jQuery. In this blog post, I use some code from <a href="http://youmightnotneedjquery.com/">You Might Not Need jQuery</a>.</p>
<h2>Selecting elements with CSS3 Selectors</h2>
<p>If you want to get an element by it's ID, instead of <code>$("#id")</code> just use <code>document.getElementById("id")</code>. If you want to use more advanced selector, for example if you want to select the last <code>li</code> element inside a <code>ul</code> with the id <code>mylist</code>, you would use <code>document.querySelector("ul#mylist > li:last-child")</code>. You can obviously make a shorthand, like so:</p>
<pre><code>function getEl(query) {
    return document.querySelector(query);
}
</code></pre>
<h2>AJAX</h2>
<p>I must admit, for someone coming from a jQuery background, vanilla AJAX does look quite scary. It also makes you think about the type of request you need. If you need to do a GET request:</p>
<pre><code>var request = new XMLHttpRequest();
request.open('GET', '/my/url', true);

request.onload = function() {
  if (request.status &gt;= 200 && request.status &lt; 400) {
    // Success!
    var resp = request.responseText;
  } else {
    // We reached our target server, but it returned an error

  }
};

request.onerror = function() {
  // There was a connection error of some sort
};

request.send();
</code></pre>
<p>A POST request is a bit different:</p>
<pre><code>var request = new XMLHttpRequest();
request.open('POST', '/my/url', true);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

// if you want to get the responseText, include the onload and onerror functions, otherwise you can simply leave them out!
request.onload = function() {
  if (request.status &gt;= 200 && request.status &lt; 400) {
    // Success!
    var resp = request.responseText;
  } else {
    // We reached our target server, but it returned an error

  }
};

request.onerror = function() {
  // There was a connection error of some sort
};

request.send(data);
</code></pre>
<h2>Animations</h2>
<p>If you still need to support IE9 or lower, you should probably stick with jQuery or some other JavaScript library for animations. However, if you don't (or you can get away with it), you can use CSS animations! The only reason you will still need to use JavaScript is if you want the animations to trigger at a specific point in time or from an event (e.g. if the user scrolls down the page). Do yourself a favour and get some animations from <a href="https://daneden.github.io/animate.css/">animate.css</a> so that you don't have to reinvent the wheel.</p>
<h2>Conclusion</h2>
<p>jQuery is an amazing library that makes cross-browser JavaScript a pleasure. However, modern browsers are no longer as problematic, and web developers need to learn to use vanilla JS. For a nice list of how to do things in vanilla JS, I recommend <a href="http://youmightnotneedjquery.com/">You Might Not Need jQuery</a>. It really is a whole new world. </p>
<?php require "../../../includes/footer.php" ?>
