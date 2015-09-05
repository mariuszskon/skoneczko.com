<link rel="stylesheet" href="scraperstyle.css">

<?php

  $city=$_GET['city'];
  
  $city=str_replace(" ", "", $city);
  
  $contents=file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
  
  preg_match('/1 &ndash; 3 Day Weather Forecast Summary:<\/b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">(.*?)</s', $contents, $matches);
  
  //change it up a bit, but only if it exists!!
  
  $original=$matches[1];
  
  if ($original!="") { //needed to make sure lots of stuff isn't added to nothing

    $originaldays=array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
  
    $fulldays=array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  
    $fulldayresult=str_replace($originaldays, $fulldays, $original);
  
    //do max temp stuff
  
    preg_match('/max .*?&deg;C/', $fulldayresult, $amaxtemp);

    $themaxtemp="/".$amaxtemp[0]."/";

    $newmaxtemp='<span class="maxtemp">'.$amaxtemp[0].'</span>';
  
    $maxtempfulldayresult=preg_replace($themaxtemp, $newmaxtemp, $fulldayresult);
  
    //do min temp stuff
  
    preg_match('/min .*?&deg;C/', $maxtempfulldayresult, $amintemp);
  
    $themintemp="/".$amintemp[0]."/";
  
    $newmintemp='<span class="mintemp">'.$amintemp[0].'</span>';
  
    $alltempfulldayresult=preg_replace($themintemp, $newmintemp, $maxtempfulldayresult);
  
    echo '<p class="results-msg">'.$alltempfulldayresult.'</p>';
  
  } 
  
  //else return nothing so client side knows to show error
  
?>