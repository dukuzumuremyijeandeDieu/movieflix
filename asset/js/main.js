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
  // JavaScript to manage active state on click
const items = document.querySelectorAll("li");
items.forEach(item => {
    item.addEventListener("click", () => {
        items.forEach(i => i.classList.remove("active"));
        item.classList.add("active");
    });
});
// Optionally add focus event to handle keyboard navigation
items.forEach(item => {
    item.addEventListener("focus", () => {
        items.forEach(i => i.classList.remove("active"));
        item.classList.add("active");
    });
});

//search btn to show form for search
document.addEventListener("DOMContentLoaded", function () {
    const searchIcon = document.querySelector(".search-icon");
    const searchContainer = document.getElementById("top-mobile-search");

    // Toggle the search form when the search icon is clicked
    searchIcon.addEventListener("click", function () {
        searchContainer.style.display = searchContainer.style.display === "none" ? "block" : "none";
    });

    // Hide the search form if clicking outside of it
    document.addEventListener("click", function (event) {
        if (!searchContainer.contains(event.target) && !searchIcon.contains(event.target)) {
            searchContainer.style.display = "none";
        }
    });
});