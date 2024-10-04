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
//(function () {
//    document.addEventListener("DOMContentLoaded", function () {
//        const findIcon = document.getElementById("find");
//        const findContainer = document.getElementById("top-mobile-search");
//
//        // Toggle the search form when the search icon is clicked
//        findIcon.addEventListener("click", function (event) {
//            // Prevent event propagation to ensure click event does not trigger the document listener
//            event.stopPropagation();
//            findContainer.style.display = findContainer.style.display === "none" ? "block" : "none";
//        });
//
//        // Hide the search form if clicking outside of it
//        document.addEventListener("click", function (event) {
//            // Check if the clicked element is outside the search container and search icon
//            if (!findContainer.contains(event.target) && !findIcon.contains(event.target)) {
//                findContainer.style.display = "none";
//            }
//        });
//    });
//})();

//// Get the icon and hidden content elements
(function(){
    const toggleIcon = document.getElementById('toggled-icon');
    const hiddenContent = document.getElementById('top-mobile-search');
    
    // Function to toggle the visibility of the hidden content
    toggleIcon.addEventListener('click', function (event) {
        // Toggle display property between 'block' and 'none'
        hiddenContent.style.display = hiddenContent.style.display === 'block' ? 'none' : 'block';
    
        // Stop event propagation to avoid triggering the document click event
        event.stopPropagation();
    });
    
    // Hide hidden content when clicking outside of it
    document.addEventListener('click', function (event) {
        // Check if the click is outside the hidden content and the toggle icon
        if (!hiddenContent.contains(event.target) && !toggleIcon.contains(event.target)) {
            hiddenContent.style.display = 'none';
        }
    });
})();
