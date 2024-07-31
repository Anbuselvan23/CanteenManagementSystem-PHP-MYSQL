const menuToggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');
const menuLinks = document.querySelectorAll('.menu a');

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('active');
  menu.classList.toggle('active');
});

menuLinks.forEach(link => {
  link.addEventListener('click', () => {
    menuToggle.classList.remove('active');
    menu.classList.remove('active');
  });
});

// set a CSS class that hides the body element
document.documentElement.classList.add("page-loading");

// use document.body instead of window object for events
document.body.onbeforeunload = function() {
  // check if scrollPos already exists before writing to localStorage
  if (localStorage.getItem("scrollPos") === null) {
    localStorage.setItem("scrollPos", window.scrollY);
  }
};

// retrieve the stored scroll position from sessionStorage after page reloads
document.body.onload = function() {
  var scrollPos = sessionStorage.getItem("scrollPos");
  if (scrollPos !== null) {
    window.scrollTo(0, scrollPos);
    // clear sessionStorage after reading the value
    sessionStorage.removeItem("scrollPos");
    // remove the CSS class that hides the body element
    document.documentElement.classList.remove("page-loading");
  }
};

// use an optimized debounce function to limit the frequency of the event triggers
function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) {
        func.apply(context, args);
      }
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) {
      func.apply(context, args);
    }
  };
}

// attach the debounce function to the window scroll event
window.addEventListener("scroll", debounce(function() {
  sessionStorage.setItem("scrollPos", window.scrollY);
  // remove the CSS class that hides the body element
  document.documentElement.classList.remove("page-loading");
}, 100, true));

// define a function to handle the visibility change event
function handleVisibilityChange() {
  // check the visibility value
  if (visibilityValueHasChanged()) {
    // refresh the screen
    refreshScreen();
  }
}

// listen for the visibility change event
document.addEventListener('visibilitychange', handleVisibilityChange);


