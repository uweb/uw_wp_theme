"use strict";

jQuery(document).ready(function () {
  // add your shortcode attribute and its default value to the
  // gallery settings list; $.extend should work as well...
  _.extend(wp.media.galleryDefaults, {
    uw_carousel: '',
    uw_carousel_fullwidth: '',
    uw_carousel_captions: '',
    uw_photo_grid_gap: ''
  }); // merge default gallery settings template with yours


  wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
    template: function template(view) {
      return wp.media.template('gallery-settings')(view) + wp.media.template('uw-gallery-setting')(view);
    }
  });
});