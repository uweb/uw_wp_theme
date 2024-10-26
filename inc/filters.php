<?php
// UW Filters
//
// These are filters the UW 2014 theme adds and globally uses.

class UW_Filters
{

    private $REPLACE_TEMPLATE_CLASS = array( 'templatestemplate-', '-php' );

    function __construct() {
        // Global filters
        // Allow shortcodes in text widgets and excerpts
        add_filter( 'widget_text', 'do_shortcode' );
        add_filter( 'the_excerpt', 'do_shortcode' );

        // Add a better named template class to the
        add_filter( 'body_class', array( $this, 'better_template_name_body_class' ) );

        // Modify the more text link
        add_filter( 'excerpt_more', '__return_false' );
        add_filter( 'the_excerpt', array( $this, 'excerpt_more_override' ) );

        // Add PDF filter to media library
        add_filter( 'post_mime_types', array( $this, 'modify_post_mime_types' ) );

        // Multisite filters
        if ( is_multisite() ) {
            // Add the site title to the body class
            add_filter( 'body_class', array( $this, 'add_site_title_body_class' ) );
        }

        // Custom excerpt ending
        add_filter( 'excerpt_more', array( $this, 'custom_excerpt_more' ) );

		// custom excerpt length.
		add_filter( 'excerpt_length', array( $this, 'uw_excerpt_length' ) );

        //allow username less than 4 characters
        add_filter( 'wpmu_validate_user_signup', 'short_user_names' );

    }

    function custom_excerpt_more( $more ) {
        return '...';
    }

	function uw_excerpt_length( $length ) {
		return 80;
	}

	// Adds a more link to the end of the excerpt
    function excerpt_more_override( $excerpt ) {

        return $excerpt . '<div><a class="more-link" href="' . get_permalink() . '">Continue reading <span class="screen-reader-text">' . get_the_title() . '</span></a></div>';
    }

    function modify_post_mime_types( $post_mime_types ) {

        // select the mime type, here: 'application/pdf'
        $post_mime_types[ 'application/pdf' ] = array( __( 'PDF' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );

        return $post_mime_types;

    }

    function add_site_title_body_class( $classes ) {
        global $current_blog;

        if ( is_multisite() )
            $classes[] = 'site-'. sanitize_html_class( $current_blog->path );

        return $classes;

    }

    function better_template_name_body_class( $classes ) {
        if ( is_page_template() ) {

            foreach( $classes as $index=>$class ) {
                $classes[ $index ] = str_replace( $this->REPLACE_TEMPLATE_CLASS, '', $class );
            }
        }
        return $classes;
    }

    // Allow short usernames to match NetID standards
    function short_user_names( $result ) {

        $error_name = $result[ 'errors' ]->get_error_message( 'user_name' );

        if ( empty ( $error_name ) || $error_name !== __( 'Username must be at least 4 characters.' ) ) {
            return $result;
        }

        unset ( $result[ 'errors' ]->errors[ 'user_name' ] );
        return $result;
    }
}

new UW_Filters();
