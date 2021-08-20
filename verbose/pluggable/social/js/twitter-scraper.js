"use strict";

/* eslint-disable camelcase */

/* eslint-disable yoda */

/* eslint-disable vars-on-top */
wprig.Twitter = {};
$(document).ready(function () {
  // var twitterProxy = 'https://www.washington.edu/wp-content/themes/social-2014/twitter-proxy.php?user=uw&count=10'; // CHANGE ME.
  var twitterProxy = '/wp-content/themes/wprig/pluggable/social/twitter-proxy.php?user=uw&count=10'; // CHANGE ME.

  wprig.Twitter.tweets = new wprig.Twitter.Tweets();
  $.ajax({
    url: twitterProxy,
    success: wprig.Twitter.tweets.parse,
    error: wprig.Twitter.twitter_failure
  });
});

wprig.Twitter.twitter_failure = function (error) {
  console.log(error);
};

wprig.Twitter.Tweet = Backbone.Model.extend({
  initialize: function initialize() {
    this.view = new wprig.Twitter.View({
      model: this
    });
    this.view.render();
  }
});
wprig.Twitter.View = Backbone.View.extend({
  template: _.template('<div><a href="<%= link %>"><p><%= text %></p><% if (image){ %><img src="<%= image %>"/><% } %></a></div>'),
  el: '#twitter',
  initialize: function initialize(args) {
    this.model = args.model;
  },
  render: function render() {
    var atts = this.model.toJSON();
    this.$el.append(this.template(atts));
    this.$el.addClass('show');
  }
});
wprig.Twitter.Tweets = Backbone.Collection.extend({
  model: wprig.Twitter.Tweet,
  initialize: function initialize() {
    _.bindAll(this, 'parse');
  },
  parse: function parse(response) {
    var tweetArray = [],
        tweet; //console.log( 'response: ' + JSON.stringify( response ) );

    for (var i = 0; i < response.length; i++) {
      tweet = response[i];

      if (tweet.hasOwnProperty('text')) {
        var image = false;

        if (tweet.entities.hasOwnProperty('media')) {
          if (tweet.entities.media[0].type == 'photo') {
            image = tweet.entities.media[0].media_url;
          }
        }

        tweetArray.push({
          text: wprig.wrapHashtagsLinks(tweet.text),
          image: image,
          link: 'https://www.twitter.com/UW/status/' + tweet.id_str
        });
      }
    }

    this.add(tweetArray);
  }
});