var defaultscraperdata;

$.get("scraper.php", function(data) {
    
  defaultscraperdata=data;
  
});


$("#mainButton").click(function(event) {
  
  event.preventDefault();

  $("#success-msg").hide();
  $("#error-msg-city").hide();
  $("#error-msg").hide();
  
  if ($("#city").val()!="") {

    $("#loading-msg").fadeIn();
  
    $.get("scraper.php?city="+$("#city").val(), function(data) {

      $("#loading-msg").hide();
    
      if (data==defaultscraperdata) {
      
        $("#error-msg").fadeIn();
      
      } else {
      
        $("#success-msg").html(data).fadeIn();
      
      }
    
    });
  
  } else {
    
    $("#error-msg-city").fadeIn();
  
  }
  
});
