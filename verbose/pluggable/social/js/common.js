"use strict";

var wprig = {};

wprig.wrapHashtagsLinks = function (text) {
  var hashTagRegexp = /#([a-zA-Z0-9]+)/g;
  var linkRegexp = /https([^ ]+)/g;
  text = text.replace(hashTagRegexp, '<span class="hash">#$1</span>');
  text = text.replace(linkRegexp, '<span class="link">https$1</span>');
  return text;
};