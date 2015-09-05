<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>My Weather Scraper</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
          <h1>My Weather Scraper</h1>
          <p class="lead">Enter your city below to get your weather forecast</p>
          <p class="lead">Using <a href="http://www.weather-forecast.com/">weather-forecast.com</a></p>
        
          <form>
            <div class="form-group">
              <input type="text" class="form-control" name="city" id="city" placeholder="e.g. London, Tokyo, Paris, New York, Sydney..." />
            </div>
        
            <button id="mainButton" class="btn btn-primary btn-lg">Get weather</button>
        
          </form>
        
        
        <div id="success-msg" class="alert alert-success">Success!</div>
        
        <div id="error-msg" class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Could not find city, please try again</div>
        
        <div id="error-msg-city" class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Please enter a city</div>
        
        </div>
      
      </div>

    </div>

    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    <script src="main.js"></script>
  </body>
</html>