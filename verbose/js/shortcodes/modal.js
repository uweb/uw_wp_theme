"use strict";

var UWModal = function UWModal() {
  // if default 'uw-modal' on the trigger button, count the number of modals and add -# to the end of each.
  // get all the modals on the page using the default name.
  var defaultModals = document.querySelectorAll('button.uw-modal'); // if there's more than one modal with the default name, let's loop through and add a unique identifier to the end in all the places that need it.

  if (1 < defaultModals.length) {
    for (var m = 0; m < defaultModals.length; m++) {
      // remove default .uw-modal.
      defaultModals[m].classList.remove('uw-modal'); // add unique id to .uw-modal-*.

      defaultModals[m].classList.add('uw-modal-' + m); // set the data-target for the button to match the ID of the modal div.

      defaultModals[m].setAttribute('data-target', '#uw-modal-' + m); // set the modal div ID.

      defaultModals[m].parentElement.nextElementSibling.id = 'uw-modal-' + m; // set the aria-labelledby.

      defaultModals[m].parentElement.nextElementSibling.setAttribute('aria-labelledby', 'uw-modal-' + m + '-title'); // set the h5 modal title ID.

      defaultModals[m].parentElement.nextElementSibling.getElementsByClassName('modal-title')[0].id = 'uw-modal-' + m + '-title';
    }
  } // Now, let's make sure none of the other modals have the same class/ID. If they do, we give them a unique ID, too.


  var allModals = document.querySelectorAll('.modal');

  if (1 < allModals.length) {
    // convert to an array.
    var modalEls = Array.prototype.slice.call(allModals); // map all elements by ID.

    var modalIds = modalEls.map(function (el) {
      return el.id;
    }); // get all IDs with duplicates.

    var modalDups = modalEls.filter(function (el) {
      return 1 < modalIds.filter(function (id) {
        return id === el.id;
      }).length;
    }); // get the duplicated ID.

    var modalDupId = modalDups[0].id; // then add a unique id to the end e.g. -1 (++).

    for (var _m = 0; _m < allModals.length; _m++) {
      if (modalDupId === allModals[_m].id) {
        allModals[_m].id = modalDupId + '-' + _m; // remove the duplicate class from the trigger button.

        allModals[_m].previousElementSibling.querySelector('button').classList.remove(modalDupId); // add the unique class for this trigger button.


        allModals[_m].previousElementSibling.querySelector('button').classList.add(modalDupId + '-' + _m); // set the data-target for the button to match the new ID of the modal div.


        allModals[_m].previousElementSibling.querySelector('button').setAttribute('data-target', '#' + modalDupId + '-' + _m); // set the aria-labelledby.


        allModals[_m].setAttribute('aria-labelledby', modalDupId + '-' + _m + '-title'); // set the h5 modal title ID.


        allModals[_m].getElementsByClassName('modal-title')[0].id = modalDupId + '-' + _m + '-title';
      }
    }
  }
};

new UWModal();