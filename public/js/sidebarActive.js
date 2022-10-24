// A $( document ).ready() block.
$( document ).ready(function() {
	var pathname = window.location.pathname;

	 var matchingMenuItem = null;
      var ul = document.getElementById("js-nav-menu");
      var items = ul.getElementsByTagName("a");
      for (var i = 0; i < items.length; ++i) {
        if (pathname === items[i].pathname) {
          matchingMenuItem = items[i];
          break;
        }
      }
      if (matchingMenuItem) {
        const parent = matchingMenuItem.parentElement;
      	// console.log(parent);

    if (parent) {
      parent.classList.add("active"); // li
      const parent2 = parent.parentElement;

      if (parent2) {
        parent2.classList.add("active");

        const parent3 = parent2.parentElement;

        if (parent3) {
          parent3.classList.add("active");
          const parent4 = parent3.parentElement;
          if (parent4) {
            parent4.classList.add("active");
             const parent5 = parent4.parentElement;
          if (parent5) {
            parent5.classList.add("active");
          }
          
          return false;
          }

          return false;
        }
          return false;
      }
        return false;
    }
     return false;
   }
});
