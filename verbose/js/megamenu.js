"use strict";

/**
 * Mega Menu JS.
 * - Adds column classes.
 * - Adds right-aligned class if top-level menus are over 4 items long.
 * - Adds keyboard access (keycodes) not found in default Bootstrap.
*/
(function ($) {
  $(document).ready(function () {
    if (document.querySelectorAll('#mega-menu')) {
      var allDepthZero = document.querySelectorAll('#mega-menu .depth-0');

      if (0 < allDepthZero.length) {
        for (var n = 0; n < allDepthZero.length; n++) {
          var allNavGroups = allDepthZero[n].querySelectorAll('.nav-group');

          if (2 === allNavGroups.length || 4 === allNavGroups.length) {
            // add class to div.row.
            allNavGroups[0].parentNode.classList.add('two-col');
          } else if (3 === allNavGroups.length) {
            // add class to div.row.
            allNavGroups[0].parentNode.classList.add('three-col');
          } else if (4 < allNavGroups.length) {
            // add class to div.row.
            allNavGroups[0].parentNode.classList.add('three-col');
          } else if (0 === allNavGroups.length || null === allNavGroups.length) {
            // add class to div.row.
            allDepthZero[n].querySelector('.row').classList.add('one-col');
          } else {
            // add class to div.row.
            allNavGroups[0].parentNode.classList.add('one-col');
          }
        }
      } // count all top level menu items. If there's more than 4, anything after #4 with a drop-down we add the class that aligns it right.
      // get the mega menu.


      var megaMenu = document.querySelector('#mega-menu ul'); // get only the top-level menu items from the mega menu.

      var allTopLevelNav = megaMenu.querySelectorAll(':scope > li'); // if there are more than 4 items in the mega menu, add .dropdown-menu-right to the ul.dropdown-menu.

      if (4 < allTopLevelNav.length) {
        for (var d = 4; d < allTopLevelNav.length; d++) {
          var allDropDowns = allTopLevelNav[d].querySelectorAll('.dropdown-menu');

          if (allDropDowns.length) {
            for (var dd = 0; dd < allDropDowns.length; dd++) {
              allDropDowns[dd].classList.add('dropdown-menu-right');
            }
          }
        }
      }
    }
  });
})(jQuery);