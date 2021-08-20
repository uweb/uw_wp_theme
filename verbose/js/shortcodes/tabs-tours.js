"use strict";

var UWTabs = function UWTabs() {
  // if default 'tab-tour', count the number of tab sets and add -# to the end of each. (otherwise they will all be unique IDs.).
  // get all the tab sets on the page using the default name.
  var defaultTabTours = document.querySelectorAll('#tabs-tour-container'); // if there's more than one tab set with the default name, let's loop through and add a unique identifier to the end.

  if (1 < defaultTabTours.length) {
    for (var d = 0; d < defaultTabTours.length; d++) {
      defaultTabTours[d].id = 'tabs-tour-container-' + d;
    }
  } // look at tab <ul> to see if it has a duplicate ID (because the user put the same name on multiple tabs).


  var allTabLists = document.querySelectorAll('.tab-tour ul.nav-tabs');

  if (1 < allTabLists.length) {
    // convert to an array.
    var elements = Array.prototype.slice.call(allTabLists); // map all elements by ID.

    var ids = elements.map(function (el) {
      return el.id;
    }); // get all IDs with duplicates.

    var dups = elements.filter(function (el) {
      return 1 < ids.filter(function (id) {
        return id === el.id;
      }).length;
    }); // then add a unique id to the end e.g. -1 (++).

    if (0 !== dups.length) {
      // get the duplicated ID.
      var dupId = dups[0].id;

      for (var _d = 0; _d < allTabLists.length; _d++) {
        if (dupId === allTabLists[_d].id) {
          allTabLists[_d].id = dupId + '-' + _d; // set the IDs and hrefs for the links.

          var dupTabsLinks = allTabLists[_d].getElementsByClassName('nav-link');

          for (var t = 0; t < dupTabsLinks.length; t++) {
            dupTabsLinks[t].id = 'title-' + dupId + '-' + _d + '-' + t;
            dupTabsLinks[t].href = '#content-' + dupId + '-' + _d + '-' + t;
            dupTabsLinks[t].setAttribute('aria-controls', 'content-' + dupId + '-' + _d + '-' + t);
          } // set the content panels to match the IDs.


          allTabLists[_d].parentElement.getElementsByClassName('tab-content')[0].id = 'tab-content-' + dupId + '-' + _d; // set the

          var dupTabsPanes = allTabLists[_d].parentElement.getElementsByClassName('tab-pane');

          for (var p = 0; p < dupTabsPanes.length; p++) {
            dupTabsPanes[p].id = 'content-' + dupId + '-' + _d + '-' + p;
            dupTabsPanes[p].setAttribute('aria-labelledby', 'title-' + dupId + '-' + _d + '-' + p);
          }
        }
      }
    }
  } // Event listeners and key codes for added accessibility. Taken in part from WAI-ARIA example: https://www.w3.org/TR/wai-aria-practices/examples/tabs/tabs-2/js/tabs.js and our accordion JS.


  var allTabs = document.querySelectorAll('.tab-tour');
  allTabs.forEach(function (tab) {
    // convert NodeList to an Array so we can play with it.
    var tabTitles = Array.prototype.slice.call(tab.querySelectorAll('.nav-link'));
    tab.addEventListener('keydown', function (event) {
      var target = event.target;
      var key = event.which; // let's use human-friendly key names.

      var keys = {
        end: 35,
        home: 36,
        left: 37,
        up: 38,
        right: 39,
        down: 40
      }; // if down, right, left, or up key, move one tab down/right or up/left.

      if (keys.down === key || keys.right === key || keys.left === key || keys.up === key) {
        event.preventDefault();
        var index = tabTitles.indexOf(target);
        var direction = keys.right === key || keys.down === key ? 1 : -1;
        var length = tabTitles.length;
        var newIndex = (index + length + direction) % length;
        tabTitles[newIndex].focus();
      } else {
        switch (key) {
          // if the end key, go to the last tab.
          case keys.end:
            event.preventDefault();
            tabTitles[tabTitles.length - 1].focus();
            break;
          // if the home key, go to the first tab.

          case keys.home:
            event.preventDefault();
            tabTitles[0].focus();
            break;
          // if none of the keys match, break out of this!

          default:
            break;
        }
      }
    });
  });
};

new UWTabs();