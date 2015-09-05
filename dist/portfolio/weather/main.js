var defaultscraperdata;

$.get("scraper.php", function(data) {
    
  defaultscraperdata=data;
  
});


$("#mainButton").click(function(event) {
  
  event.preventDefault();
  
  if ($("#city").val()!="") {
  
    $.get("scraper.php?city="+$("#city").val(), function(data) {
    
      if (data==defaultscraperdata) {
      
        $("#success-msg").hide();
        $("#error-msg-city").hide();
        $("#error-msg").fadeIn();
      
      } else {
      
        $("#error-msg").hide();
        $("#error-msg-city").hide();
        $("#success-msg").html(data).fadeIn();
      
      }
    
    });
  
  } else {
    
    $("#success-msg").hide();
    $("#error-msg").hide();
    $("#error-msg-city").fadeIn();
  
  }
  
});