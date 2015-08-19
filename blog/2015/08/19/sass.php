<?php $pagetitle = "Sass is awesome" ?>
<?php $postdate = "19th August 2015" ?>
<?php require "../../../includes/header.php" ?>
<p>Recently, I started using <a href="http://sass-lang.com">Sass</a> (the SCSS flavour). Now I simply cannot go back.</p>
<p>For the uninitiated, Sass is a CSS preprocessor. That means you write Sass code, and it "complies" into standard, old-fashioned CSS. If you would like an easy way to tryout Sass, I recommend <a href="http://sassmeister.com/">Sassmeister</a>. So what are some killer features of Sass?</p>
<h2>Nesting</h2>
<p>A straightforward yet powerful feature:</p>
<pre><code>ul {
    list-style: none;
    li {
        float: right;
        a {
            display: inline-block;
        }
    }
}
</code></pre>
<p>Gets converted into:</p>
<pre><code>ul {
  list-style: none;
}

ul li {
  float: right;
}

ul li a {
  display: inline-block;
}
</code></pre>

<h2>Variables</h2>
<p>That's right, you can have variables in Sass. This makes it really easy to change colours site-wide. Here is an awesome example of the power of Sass variables when it comes to colours:</p>
<pre><code>$mycolor: #F5F5F5;

ul {
    background-color: $mycolor;
    li {
        background-color: darken($mycolor, 15%);
    }
}
</code></pre>
<p>Yup, we can darken, lighten, saturate etc. colours in Sass and refer to the variable! This gets converted into:</p>
<pre><code>ul {
  background-color: #F5F5F5;
}

ul li {
  background-color: #cfcfcf;
}
</code></pre>
<p>And suppose we decide that blue is more our thing and set <code>$mycolor: blue</code>:</p>
<pre><code>ul {
  background-color: blue;
}

ul li {
  background-color: #0000b3;
}
</code></pre>
<p>Nice automatic colour schemes.</p>
<h2>Partials and imports</h2>
<p>When I use <code>@import</code> in Sass, I usually use it with partials, that's why they are in the same category. Partials and imports allow your code to be organised into different files. A partial is defined by making the filename start with an underscore (_) and makes sure that Sass doesn't generate a standalone CSS file out of it. For example, if we had a file <code>_vars.scss</code> with the following contents:</p>
<pre><code>$mycolor: orange;</code></pre>
<p>And a <code>base.scss</code> file like this:</p>
<pre><code>@import "vars"; // we drop the _ and .scss when @import-ing
ul {
    background-color: $mycolor;
}
</code></pre>
<p>It would be compiled into one nice ready to use CSS file.</p>
<h2>Mixins</h2>
<p>Mixins are an extremely useful feature that saves time and maintenance.</p>
<pre><code>@mixin colors($color, $backgroundcolor, $bordercolor) {
    color: $color;
    background-color: $backgroundcolor;
    border: 1px solid $bordercolor;
}

ul {
    width: 100%;
    @include colors(green, orange, red);
    li {
        @include colors(blue, orange, green);
    }
}
</code></pre>
<p>Is converted into: </p>
<pre><code>ul {
  width: 100%;
  color: green;
  background-color: orange;
  border: 1px solid red;
}

ul li {
  color: blue;
  background-color: orange;
  border: 1px solid green;
}
</code></pre>
<p>Of course mixins can be more simple and more complex than that and even include mixins inside them! If you were paying careful attention, you would notice that Sass also allows us to use <code>// comment</code> syntax for comments and are compiled out of the final CSS.</p>
<h2>Conclusion</h2>
<p>Sass is awesome. It provides amazing features that make your programming in CSS more enjoyable and maintainable. However, I would not recommend it to a complete CSS newbie. Learn CSS first, and enjoy the power of Sass later. You will find yourself actually using Sass better that way and appreciating its features. If you are interested in more features in Sass, I recommend you check out their <a href="http://sass-lang.com/documentation/file.SASS_REFERENCE.html">documentation</a>. Enjoy using Sass!</p>
<?php require "../../../includes/footer.php" ?>
