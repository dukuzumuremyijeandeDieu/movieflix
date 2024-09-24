// Automatic Slideshow - change image every 3 seconds
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("myImages");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}
  x[myIndex-1].style.display = "block";
  setTimeout(carousel, 3000);
}

/*sidebar*/
let horroMovies = document.getElementById("horro-movies");
let allMovies = document.getElementById("all-movies");
let allMovieBtn = document.getElementById("all-movie-btn");
let horroMovieBtn = document.getElementById("horro-movie-btn");

allMovieBtn.addEventListener('click', function(){
  allMovies.style.display = "block";
  horroMovies.style.display = "none";
});
horroMovieBtn.addEventListener('click', function(){
  allMovies.style.display = "none";
  horroMovies.style.display = "block";
});