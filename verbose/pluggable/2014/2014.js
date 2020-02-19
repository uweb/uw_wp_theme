'use strict';

/* eslint-disable camelcase */
/* eslint-disable yoda */

// BASE STUFF FROM 2014. TODO: Get rid of this when you can.
// There's stuff for QUICKLINKS and SEARCH in here.

// Establish the root object `window`.
var root = window.document;

// Create a safe reference to the UW object which will be used to establish the global UW object.
var UW = function UW(obj) {
	if (obj instanceof UW) {
		return obj;
	}

	if (!(this instanceof UW)) {
		return new UW(obj);
	}

	this._wrapped = obj;
};

// Establish the global UW object `window.UW`
root.UW = UW;

// Current version
UW.VERSION = '0.1';

// Constant for legible keycodes
UW.KEYCODES = {
	TAB: 9,
	ENTER: 13,
	ESC: 27
};

UW.elements = {
	alert: '.site-header',
	radio: ':radio',
	checkbox: ':checkbox',
	search: '#uwsearcharea',
	select: '.uw-select',
	quicklinks: '.uw-quicklinks'
};

UW.getBaseUrl = function () {
	var site = _.first(_.compact(Backbone.history.location.pathname.split('/')));
	var url = '';

	if (!Backbone.history.location.origin) {
		Backbone.history.location.origin = Backbone.history.location.protocol + '//' + Backbone.history.location.hostname + (Backbone.history.location.port ? ':' + Backbone.history.location.port : '');
	}

	if (Backbone.history.location.origin.indexOf('www.washington.edu') != -1) {
		url = Backbone.history.location.origin + (site ? '/' + site : '') + '/';
	} else if (Backbone.history.location.origin.indexOf('depts.washington.edu') != -1) {
		url = Backbone.history.location.origin + (site ? '/' + site : '') + '/';
	} else {
		url = Backbone.history.location.origin + '/';
	}
	return url;
};

UW.wpinstance = function () {
	return Backbone.history.location.pathname ? Backbone.history.location.pathname : '';
};

UW.sources = {

	// Note: style_dir is a variable created by the Wordpress' wp_localize_script in class.uw-scripts.php
	quicklinks: typeof style_dir !== 'undefined' ? style_dir + '/wp-admin/admin-ajax.php?action=quicklinks' : UW.getBaseUrl() + 'wp-admin/admin-ajax.php?action=quicklinks',
	search: UW.getBaseUrl() + 'wp-admin/admin-ajax.php'
};

UW.initialize = function ($) {
	UW.$body = $('body');
	UW.$window = $(window);
	UW.baseUrl = UW.getBaseUrl();

	UW.alert = new UW.Alert({ after: UW.elements.alert, model: new UW.Alert.Model() });
	UW.quicklinks = _.map($(UW.elements.quicklinks), function (element) {
		return new UW.QuickLinks({ el: element, url: UW.sources.quicklinks });
	});
	UW.radio = _.map($(UW.elements.radio), function (element) {
		return new UW.Radio({ el: element });
	});
	UW.checkbox = _.map($(UW.elements.checkbox), function (element) {
		return new UW.Radio({ el: element });
	});
	UW.select = _.map($(UW.elements.select), function (element) {
		return new UW.Select({ el: element });
	});
	UW.search = _.map($(UW.elements.search), function (element) {
		return new UW.Search({ el: element });
	});
};

jQuery(document).ready(function () {

	// switching to anonymous function so UW.initialize can be extended before running
	UW.initialize(jQuery);
});