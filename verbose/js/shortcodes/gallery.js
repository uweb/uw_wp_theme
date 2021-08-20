"use strict";

/**
 * TO DO: merge the two different methods for modals into one.
 * Alternatively : figure out how to create modal code only when needed.
 */
jQuery(function ($) {
  $('#photoGridModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var image = button.data('image');
    var caption = button.data('caption');
    var credit = button.data('credit');
    var source = button.data('source');
    var altText = button.attr('alt');
    var modal = $(this);

    if (source) {
      var creditHTML = ' <span class="wp-media-credit">Photo: <a href="' + source + '" target="_blank">' + credit + '</a></span>';
    } else {
      var creditHTML = ' <span class="wp-media-credit">Photo: ' + credit + '</span>';
    } // insert the image and alt text from the clicked image in the modal body.


    modal.find('.modal-body').html('<figure><img src="' + image + '" alt="' + altText + '" />' + '<figcaption>' + caption + creditHTML + '</figcaption>' + '</figure>');
  });
  $('.entry-content').append('<div class="modal fade photo-modal" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">' + '<div class="modal-dialog modal-dialog-centered w-90" role="document">' + '<div class="modal-content"><div class="modal-header">' + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + '</div>' + '<div class="modal-body"></div></div></div></div>');
  $('figure > a > img').on('click', function (e) {
    e.preventDefault();
    var target = $(e.currentTarget);
    var image = target.parent('a').attr('href');
    var altText = target.attr('alt');
    var caption = target.parent('a').siblings('figcaption').html();
    $('#photoModal').find('.modal-body').html('<figure><img src="' + image + '" alt="' + altText + '" />' + '<figcaption>' + caption + '</figcaption>' + '</figure></div></div></div></div>');
    $('#photoModal').modal('show');
  });
});