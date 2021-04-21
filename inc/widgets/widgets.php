<?php
/**
 * Widgets for the UW WordPress Theme
 *
 * @package uw_wp_theme
 */

$parent = get_template_directory() . "/inc/widgets/";

// Initialize the sidebar region
require_once($parent . 'class.sidebar.php');

require_once($parent . 'class.widget-visibility.php');
require_once($parent . 'class.campus-map.php');
require_once($parent . 'class.cards.php');
require_once($parent . 'class.blogroll.php');
require_once($parent . 'class.intro.php');
require_once($parent . 'class.single-image.php');
require_once($parent . 'class.rss.php');
require_once($parent . 'class.contact.php');
require_once($parent . 'class.recent-posts.php');
require_once($parent . 'class.twitter.php');
