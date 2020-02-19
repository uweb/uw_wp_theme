'use strict';

jQuery(document).ready(function () {

	// cover photo - arts
	jQuery('#arts #cover-popover-trigger').popover({
		container: 'body',
		placement: 'left',
		trigger: 'focus'
	});

	jQuery('#arts #cover-popover-trigger').click(function () {
		jQuery('#arts #cover-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#arts .callout-button-1').css('z-index', '999999');
		jQuery('#arts #social-overlay').fadeIn(300);
	});

	// cover photo - business
	jQuery('#business #cover-popover-trigger').popover({
		container: 'body',
		placement: 'left',
		trigger: 'focus'
	});

	jQuery('#business #cover-popover-trigger').click(function () {
		jQuery('#business #cover-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#business .callout-button-1').css('z-index', '999999');
		jQuery('#business #social-overlay').fadeIn(300);
	});

	// cover photo - communications
	jQuery('#communications #cover-popover-trigger').popover({
		container: 'body',
		placement: 'left',
		trigger: 'focus'
	});

	jQuery('#communications #cover-popover-trigger').click(function () {
		jQuery('#communications #cover-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#communications .callout-button-1').css('z-index', '999999');
		jQuery('#communications #social-overlay').fadeIn(300);
	});

	// cover photo - engineering
	jQuery('#engineering #cover-popover-trigger').popover({
		container: 'body',
		placement: 'left',
		trigger: 'focus'
	});

	jQuery('#engineering #cover-popover-trigger').click(function () {
		jQuery('#engineering #cover-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#engineering .callout-button-1').css('z-index', '999999');
		jQuery('#engineering #social-overlay').fadeIn(300);
	});

	// cover photo - research
	jQuery('#research #cover-popover-trigger').popover({
		container: 'body',
		placement: 'left',
		trigger: 'focus'
	});

	jQuery('#research #cover-popover-trigger').click(function () {
		jQuery('#research #cover-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#research .callout-button-1').css('z-index', '999999');
		jQuery('#research #social-overlay').fadeIn(300);
	});

	// profile icon - arts
	jQuery('#arts #profile-popover-trigger').popover({
		container: 'body',
		placement: 'bottom',
		trigger: 'focus'
	});

	jQuery('#arts #profile-popover-trigger').click(function () {
		jQuery('#arts #profile-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#arts .callout-button-2').css('z-index', '999999');
		jQuery('#arts #social-overlay').fadeIn(300);
	});

	// profile icon - business
	jQuery('#business #profile-popover-trigger').popover({
		container: 'body',
		placement: 'bottom',
		trigger: 'focus'
	});

	jQuery('#business #profile-popover-trigger').click(function () {
		jQuery('#business #profile-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#business .callout-button-2').css('z-index', '999999');
		jQuery('#business #social-overlay').fadeIn(300);
	});

	// profile icon - communications
	jQuery('#communications #profile-popover-trigger').popover({
		container: 'body',
		placement: 'bottom',
		trigger: 'focus'
	});

	jQuery('#communications #profile-popover-trigger').click(function () {
		jQuery('#communications #profile-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#communications .callout-button-2').css('z-index', '999999');
		jQuery('#communications #social-overlay').fadeIn(300);
	});

	// profile icon - engineering
	jQuery('#engineering #profile-popover-trigger').popover({
		container: 'body',
		placement: 'bottom',
		trigger: 'focus'
	});

	jQuery('#engineering #profile-popover-trigger').click(function () {
		jQuery('#engineering #profile-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#engineering .callout-button-2').css('z-index', '999999');
		jQuery('#engineering #social-overlay').fadeIn(300);
	});

	// profile icon - research
	jQuery('#research #profile-popover-trigger').popover({
		container: 'body',
		placement: 'bottom',
		trigger: 'focus'
	});

	jQuery('#research #profile-popover-trigger').click(function () {
		jQuery('#research #profile-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#research .callout-button-2').css('z-index', '999999');
		jQuery('#research #social-overlay').fadeIn(300);
	});

	// about section - arts
	jQuery('#arts #about-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#arts #about-popover-trigger').click(function () {
		jQuery('#arts #about-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#arts #social-overlay').fadeIn(300);
	});

	// about section - business
	jQuery('#business #about-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#business #about-popover-trigger').click(function () {
		jQuery('#business #about-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#business #social-overlay').fadeIn(300);
	});

	// about section - communications
	jQuery('#communications #about-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#communications #about-popover-trigger').click(function () {
		jQuery('#communications #about-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#communications #social-overlay').fadeIn(300);
	});

	// about section - engineering
	jQuery('#engineering #about-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#engineering #about-popover-trigger').click(function () {
		jQuery('#engineering #about-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#engineering #social-overlay').fadeIn(300);
	});

	// about section - research
	jQuery('#research #about-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#research #about-popover-trigger').click(function () {
		jQuery('#research #about-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#research #social-overlay').fadeIn(300);
	});

	// experience section - arts
	jQuery('#arts #experience-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#arts #experience-popover-trigger').click(function () {
		jQuery('#arts #experience-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#arts #social-overlay').fadeIn(300);
	});

	// experience section - business
	jQuery('#business #experience-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#business #experience-popover-trigger').click(function () {
		jQuery('#business #experience-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#business #social-overlay').fadeIn(300);
	});

	// experience section - communications
	jQuery('#communications #experience-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#communications #experience-popover-trigger').click(function () {
		jQuery('#communications #experience-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#communications #social-overlay').fadeIn(300);
	});

	// experience section - engineering
	jQuery('#engineering #experience-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#engineering #experience-popover-trigger').click(function () {
		jQuery('#engineering #experience-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#engineering #social-overlay').fadeIn(300);
	});

	// experience section - research
	jQuery('#research #experience-popover-trigger').popover({
		container: 'body',
		placement: 'top',
		trigger: 'focus'
	});

	jQuery('#research #experience-popover-trigger').click(function () {
		jQuery('#research #experience-expose').css('z-index', '99999').addClass('social-lightbox');
		jQuery('#research #social-overlay').fadeIn(300);
	});

	// cancel overlay for arts modal
	jQuery('#arts #cover-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#arts #social-overlay').fadeOut(300, function () {
			jQuery('#arts #cover-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#arts .callout-button-1').css('z-index', '2').removeClass('social-lightbox');
			jQuery('#arts #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#arts .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#arts #profile-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#arts #social-overlay').fadeOut(300, function () {
			jQuery('#arts #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#arts .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#arts #about-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#arts #social-overlay').fadeOut(300, function () {
			jQuery('#arts #about-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	jQuery('#arts #experience-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#arts #social-overlay').fadeOut(300, function () {
			jQuery('#arts #experience-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	// cancel overlay for business modal
	jQuery('#business #cover-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#business #social-overlay').fadeOut(300, function () {
			jQuery('#business #cover-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#business .callout-button-1').css('z-index', '2').removeClass('social-lightbox');
			jQuery('#business #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#business .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#business #profile-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#business #social-overlay').fadeOut(300, function () {
			jQuery('#business #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#business .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#business #about-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#business #social-overlay').fadeOut(300, function () {
			jQuery('#business #about-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	jQuery('#business #experience-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#business #social-overlay').fadeOut(300, function () {
			jQuery('#business #experience-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	// cancel overlay for communications modal
	jQuery('#communications #cover-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#communications #social-overlay').fadeOut(300, function () {
			jQuery('#communications #cover-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#communications .callout-button-1').css('z-index', '2').removeClass('social-lightbox');
			jQuery('#communications #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#communications .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#communications #profile-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#communications #social-overlay').fadeOut(300, function () {
			jQuery('#communications #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#communications .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#communications #about-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#communications #social-overlay').fadeOut(300, function () {
			jQuery('#communications #about-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	jQuery('#communications #experience-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#communications #social-overlay').fadeOut(300, function () {
			jQuery('#communications #experience-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	// cancel overlay for engineering modal
	jQuery('#engineering #cover-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#engineering #social-overlay').fadeOut(300, function () {
			jQuery('#engineering #cover-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#engineering .callout-button-1').css('z-index', '2').removeClass('social-lightbox');
			jQuery('#engineering #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#engineering .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#engineering #profile-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#engineering #social-overlay').fadeOut(300, function () {
			jQuery('#engineering #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#engineering .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#engineering #about-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#engineering #social-overlay').fadeOut(300, function () {
			jQuery('#engineering #about-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	jQuery('#engineering #experience-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#engineering #social-overlay').fadeOut(300, function () {
			jQuery('#engineering #experience-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	// cancel overlay for research modal
	jQuery('#research #cover-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#research #social-overlay').fadeOut(300, function () {
			jQuery('#research #cover-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#research .callout-button-1').css('z-index', '2').removeClass('social-lightbox');
			jQuery('#research #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#research .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#research #profile-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#research #social-overlay').fadeOut(300, function () {
			jQuery('#research #profile-expose').css('z-index', '1').removeClass('social-lightbox');
			jQuery('#research .callout-button-2').css('z-index', '2').removeClass('social-lightbox');
		});
	});

	jQuery('#research #about-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#research #social-overlay').fadeOut(300, function () {
			jQuery('#research #about-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});

	jQuery('#research #experience-popover-trigger').on('hidden.bs.popover', function () {
		jQuery('#research #social-overlay').fadeOut(300, function () {
			jQuery('#research #experience-expose').css('z-index', '1').removeClass('social-lightbox');
		});
	});
});