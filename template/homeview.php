<style>
 .button {
  background-color: #4CAF50;
  border: none;
  color: black;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  cursor: pointer;
}   

* {box-sizing: border-box;}
/* body {font-family: Verdana, sans-serif;} */
.mySlides {display: none;position:absolute;left: 3%; top: 3%;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
  height: 400px;
}


/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: yellow;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 2.5s;
  animation-name: fade;
  animation-duration: 6s;
}

@-webkit-keyframes fade {
  from {opacity: .4;left:-1000px;} 
  to {opacity: 1;left: 3%;}
}

@keyframes fade {
  0% {opacity: .4;left: -1000px;transform: scaleY(0.05);} 
  10% {opacity: 1;left: 3%;transform: scaleY(0.05);}
  25% {opacity: 1; left: 3%;transform: scaleY(1);}
  50% {opacity: 1; left: 3%;transform: scaleY(1);}
  60% {opacity: 1; left: 3%;transform: scaleY(1);}
  75% {opacity: 1;left: 3%;transform: scaleY(0.05);}
  100% {opacity: .4;left: 2000px;transform: scaleY(0.05);}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}

.quote{
    font-style: italic;
    font-family: cursive;
}

</style> 
 
 <center>       
<h3>The latest information:</h3>
</center>

<div class="slideshow-container">

<div class="mySlides fade">
  <img alt="student" src="images/APres-960x360-1.png" width="1000px" height="350px;"/>
</div>

<div class="mySlides fade">
  <img alt="result" src="images/Covid-19-Website.jpg" width="1000px" height="350px;"/>
  </div>

<div class="mySlides fade">
  <img alt="math" src="images/relocate-car-park.jpg" width="1000px" height="350px;"/>
  </div>

</div>
<br/>
<br/>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>

<center>
<h3 class='quote'>"Believe you can and you're halfway there"<br/>
~Theodore Roosevelt~</h3>
</center>

<br/><br/>
<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 5000); // Change image every 3 seconds
}
</script>
