"use strict";

/* eslint-disable camelcase */

/* eslint-disable vars-on-top */

/* eslint-disable yoda */
wprig.Instagram = {};
wprig.Instagram.Image = Backbone.Model.extend({});
wprig.Instagram.Backgrounds = Backbone.Collection.extend({
  model: wprig.Instagram.Image,
  defaults: {
    access_token: '201177297.d9d55d5.ca8b5f2da50f41cab37e85ae80874b3e',
    client_id: 'd9d55d56f8814f8e83b6492803e9b773',
    user_id: 201177297,
    count: 40
  },
  url: function url() {
    return 'https://api.instagram.com/v1/users/' + this.defaults.user_id + '/media/recent';
  },
  initialize: function initialize() {
    this.fetch({
      data: this.defaults,
      dataType: 'jsonp',
      crossDomain: true
    });
  },
  parse: function parse(response) {
    if (response.meta.code != 200) {}

    return response.data;
  }
});
wprig.Instagram.View = Backbone.View.extend({
  last5: [-1, -1, -1, -1, -1],
  //contains indexes of the last 5 selected images
  offLimitsImg: [],
  //contains indexes of images relative to a selected tile
  isRendered: false,
  isVisible: false,
  rotationInterval: false,
  backgroundTiles: [],
  el: $('#social-wrapper'),
  listTemplate: _.template('<div><a href="<%= link %>"><img src="<%= image %>"/><p><%= text %></p></a></div>'),
  initialize: function initialize() {
    _.bindAll(this, 'hideOrShow', 'rotateBackground');

    this.largeTileTemplate = _.template($('#large-background-tile').html());
    this.smallTilesTemplate = _.template($('#small-background-tiles').html());
    this.$list = $('#instagram');
    this.collection.on('sync', this.makeListView, this);
    $(window).resize(this.hideOrShow); //there's got to be a more elegant way to bind window resize
  },
  getRandomImage: function getRandomImage() {
    // Returns a random number in the range of this.collection.models.
    var num = Math.floor(Math.random() * this.collection.models.length);

    if (_.indexOf(this.last5, num) == -1 && _.indexOf(this.off_limits_img, num) == -1) {
      // in here, the number isn't recently chosen and (if rotating) not in a nearby tile
      this.last5.pop();
      this.last5.unshift(num);
      return num;
    } else {
      return this.getRandomImage();
    }
  },
  makeListView: function makeListView() {
    var instagram, atts;
    this.hideOrShow();

    for (var i = 0; i < 5; i++) {
      instagram = this.collection.models[i].toJSON();
      atts = {
        text: wprig.wrapHashtagsLinks(instagram.caption.text),
        link: instagram.link,
        image: instagram.images.standard_resolution.url
      };
      this.$list.append(this.listTemplate(atts));
    }

    this.$list.addClass('show');
  },
  hideOrShow: function hideOrShow() {
    if (window.innerWidth >= 768) {
      //images should be visible
      if (!this.isRendered) {
        this.render();
        this.rotationInterval = setInterval(this.rotateBackground, 500);
      } else if (!this.isVisible) {
        this.$el.show();
        this.rotationInterval = setInterval(this.rotateBackground, 500);
      }

      this.isVisible = true;
    } else if (this.isVisible) {
      //this is mobile and images should not be visible
      this.$el.hide();
      this.isVisible = false;
      clearInterval(this.rotationInterval);
    }
  },
  render: function render() {
    //set new value for length.  Size should be 84 big tiles
    var number;

    for (var index = 0, length = 84; index < length; index++) {
      var image = {};

      if (index % 2 === 0) {
        number = this.getRandomImage();
        image.image = this.collection.models[number].attributes.images;
        image.number = number;
        this.$el.append(this.largeTileTemplate(image));
      } else {
        var imageArray = [];

        for (var i = 0; i < 4; i++) {
          var imgObj = {};
          number = this.getRandomImage();
          imgObj.image = this.collection.models[number].attributes.images;
          imgObj.number = number;
          imageArray.push(imgObj);
        }

        image.image = imageArray;
        this.$el.append(this.smallTilesTemplate(image));
      }
    }

    this.isRendered = true;
    this.backgroundTiles = $('.background-tile');
  },
  rotateBackground: function rotateBackground() {
    var numTiles = this.backgroundTiles.length;
    var number = Math.floor(Math.random() * numTiles);
    var tile = $(this.backgroundTiles[number]);
    this.offLimitsImg = []; //reset list of no-go images

    var lowEnd = Math.max(number - 5, 0),
        highEnd = Math.min(number + 5, numTiles - 1);

    for (var i = lowEnd; i <= highEnd; i++) {
      //new image should be different from 5 on either side of location
      this.offLimitsImg.push(Number($(this.backgroundTiles[i]).attr('data-img')));
    }

    var dataImg = this.getRandomImage();
    var newImage = this.collection.models[dataImg].attributes.images.low_resolution.url;
    tile.animate({
      opacity: 0.1
    }, 250, function () {
      tile.css('background-image', 'url(' + newImage + ')');
      tile.attr('data-img', dataImg);
      tile.animate({
        opacity: 1
      }, 250);
    });
  }
});
$(document).ready(function () {
  wprig.Instagram.backgrounds = new wprig.Instagram.Backgrounds();
  wprig.Instagram.view = new wprig.Instagram.View({
    el: $('#social-wrapper'),
    collection: wprig.Instagram.backgrounds
  });
});