<?php
/**
 * Theme settings page
 *
 * @package uw_wp_theme
 */


function theme_settings_page()
{
    ?>
	    <div class="wrap">
	    <h1>Theme Panel</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");
	            submit_button();
	        ?>
	    </form>
		</div>
	<?php
}
function add_theme_menu_item()
{
	add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

function display_twitter_element()
{
	?>
    	<input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
    <?php
}

function display_facebook_element()
{
	?>
    	<input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
    <?php
}

function display_quicklinks_element()
{
	?>
    	<input type="checkbox" name="quicklinks-hide" value="1" <?php checked(1, get_option('quicklinks-hide'), true); ?> />
    <?php
}

function display_search_element()
{
	?>
    	<input type="checkbox" name="search-hide" value="1" <?php checked(1, get_option('search-hide'), true); ?> />
    <?php
}

function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");

	add_settings_field("twitter_url", "Twitter Profile Url", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook Profile Url", "display_facebook_element", "theme-options", "section");

    // add_settings_field("quicklinks-hide", "Hide Quicklinks menu button", "display_quicklinks_element", "theme-options", "section");

    // register_setting("section", "search-hide");

    // add_settings_field("search-hide", "Hide Search menu button", "display_search_element", "theme-options", "section");

    register_setting("section", "search-hide");

    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
}

add_action("admin_init", "display_theme_panel_fields");
