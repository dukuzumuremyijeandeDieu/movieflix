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

let currentIndex = 0;  // Current starting index of visible slides
        const slidesToShow = 5; // Number of slides to show by default
        const sliderWrapper = document.querySelector('.slider-wrapper');
        const slides = document.querySelectorAll('.slide');

        // Function to slide left or right
        function slide(direction) {
            const totalSlides = slides.length;
            const slideWidth = slides[0].clientWidth + 10; // Get slide width + gap

            // Calculate the max slide position based on the current number of visible slides
            const maxIndex = totalSlides - slidesToShow;

            if (direction === 'next' && currentIndex < maxIndex) {
                currentIndex++;
            } else if (direction === 'prev' && currentIndex > 0) {
                currentIndex--;
            }

            // Move the slider wrapper by adjusting the transform property
            sliderWrapper.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        }