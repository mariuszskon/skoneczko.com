<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title><?php echo $pagetitle; ?></title>
        
        <link href="/css/style.min.css" rel="stylesheet">
        
    </head>
  
    <body>
        
        <header>
            <div class="header-container">
                
                <h1><?php echo $pagetitle; ?></h1>
                <nav>
                    <ul class="desktop-ul">
                        <li><a href="/index.html">Home</a></li>
                        <li><a href="/portfolio/index.html">Portfolio</a></li>
                        <li class="current"><a href="/blog/index.php">Blog</a></li>
                        <li><a href="/contact.html">Contact</a></li>
                    </ul>
                </nav>
                
                <nav class="mobile-nav">
                    <ul>
                        <li><a href="/index.html">Home</a></li>
                        <li><a href="/portfolio/index.html">Portfolio</a></li>
                        <li class="current"><a href="/blog/index.php">Blog</a></li>
                        <li><a href="/contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        

    
        <div id="main-body">
            
            <div class="main-container">
                <!--[if lt IE 9]>
                    <p class="warn">You are using Internet Explorer lower than 9.<br />Please <a href="http://browsehappy.com/">upgrade your browser</a> to make the most of the web.</p>
                <![endif]-->
                <p class="date-posted">Posted on <?php echo $postdate; ?></p>
                <article>
