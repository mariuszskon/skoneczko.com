var time=Math.random()*5000; //define it so we don't have to again

var clickedTime; var createdTime; var reactionTime;

var bestTime=9999999; //make sure initial time is very high

function randomColor() {
  var letters = '0123456789ABCDEF'.split('');
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.round(Math.random() * 15)];
  }
  return color;
}

function circleSquare() {
  var circle=Math.round(Math.random());

  if (circle == 1) {
    document.getElementById("box").style.borderRadius="50px";
  } else {
    document.getElementById("box").style.borderRadius="0";
  }
}

function randomPos() {
  var topPos;
  var leftPos;

  topPos=Math.random() * 300;
  leftPos=Math.random() * 300;

  document.getElementById("box").style.top=topPos + "px";
  document.getElementById("box").style.left=leftPos + "px";
}

function setBestTime() {
  if (reactionTime < bestTime) {
    bestTime=reactionTime;
    document.getElementById("myBestTime").innerHTML=bestTime;
  } 
}

function makeBox() {

  time=Math.random()*5000;

  setTimeout(function() {
    document.getElementById("box").style.backgroundColor=randomColor();

    circleSquare();

    randomPos();

    document.getElementById("box").style.display="block";

    createdTime=Date.now();
  }, time);

}

makeBox(); //make box appear in the first place

document.getElementById("box").onclick=function() {

  clickedTime=Date.now();

  reactionTime=(clickedTime-createdTime)/1000;

  document.getElementById("myTime").innerHTML=reactionTime;

  setBestTime();

  document.getElementById("box").style.display="none";

  makeBox();
} 
