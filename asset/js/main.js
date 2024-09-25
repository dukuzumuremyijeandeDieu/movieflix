// Automatic Slideshow - change image every 3 seconds
// var myIndex = 0;
// carousel();

// function carousel() {
//   var i;
//   var x = document.getElementsByClassName("myImages");
//   for (i = 0; i < x.length; i++) {
//      x[i].style.display = "none";
//   }
//   myIndex++;
//   if (myIndex > x.length) {myIndex = 1}
//   x[myIndex-1].style.display = "block";
//   setTimeout(carousel, 3000);
// }

/*sidebar*/
let romanceSection = document.getElementById("romance-movie-section");
let dramaSection = document.getElementById("drama-movie-section");
let horroSection = document.getElementById("horro-movie-section");
let actionSection = document.getElementById("action-movie-section");
let allMovieSection = document.getElementById("all-movie-section");

let romanceMovieBtn = document.getElementById("rommance-movie-btn");
let dramaMovieBtn = document.getElementById("drama-movie-btn");
let horroMovieBtn = document.getElementById("horro-movie-btn");
let actionMovieBtn = document.getElementById("action-movie-btn");
let allMoviesBtn = document.getElementById("all-movie-btn");

romanceMovieBtn.addEventListener("click", function(){
  romanceSection.style.display = "block";
  dramaSection.style.display = "none";
  horroSection.style.display = "none";
  actionSection.style.display = "none";
  allMovieSection.style.display = "none";
})
dramaMovieBtn.addEventListener("click", function(){
  romanceSection.style.display = "none";
  dramaSection.style.display = "block";
  horroSection.style.display = "none";
  actionSection.style.display = "none";
  allMovieSection.style.display = "none";
})
horroMovieBtn.addEventListener("click", function(){
  romanceSection.style.display = "none";
  dramaSection.style.display = "none";
  horroSection.style.display = "block";
  actionSection.style.display = "none";
  allMovieSection.style.display = "none";
})
actionMovieBtn.addEventListener("click", function(){
  romanceSection.style.display = "none";
  dramaSection.style.display = "none";
  horroSection.style.display = "none";
  actionSection.style.display = "block";
  allMovieSection.style.display = "none";
})
allMoviesBtn.addEventListener("click", function(){
  romanceSection.style.display = "none";
  dramaSection.style.display = "none";
  horroSection.style.display = "none";
  actionSection.style.display = "none";
  allMovieSection.style.display = "block";
})
