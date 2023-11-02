<?php

class UW_Attachment_Meta {
	const TITLE = 'Attachment Page Attributes';
	const POSTTYPE = 'attachment';
	const POSITION = 'side';
	const PRIORITY = 'core';

	function __construct() {
		$this->HIDDEN = array( 'No Sidebar' );
		add_action( 'add_meta_boxes', array( $this, 'replace_meta_box' ) );
		add_action( 'edit_attachment', array( $this, 'save_postdata' ) );

	}

	function replace_meta_box() {
		add_meta_box( 'uwattachmentpageparentdiv', 'Attachment Page Attributes', array( $this, 'page_attributes_meta_box' ), 'attachment', 'side', 'core' );
	}

	function page_attributes_meta_box( $post ) {
		$post_type_object = get_post_type_object( $post->post_type );
			$dropdown_args = array(
				'post_type'        => $post->post_type,
				'exclude_tree'     => $post->ID,
				'selected'         => $post->post_parent,
			);
			$sidebar = get_post_meta( $post->ID, 'sidebar', true );
			wp_nonce_field( 'sidebar_nonce', 'sidebar_name' );
		?>

		<p><strong><?php _e( 'Sidebar' ); ?></strong></p>

		<label class="screen-reader-text" for="sidebar"><?php _e( 'Sidebar' ); ?></label>

		<p><input type="checkbox" id="sidebar_id" name="sidebarcheck" value="on" <?php if( ! empty( $sidebar ) ) {
			?>
			checked="checked"<?php } ?> /><?php _e( 'Show Sidebar' ) ?></p>

		<?php
	}

	function save_postdata( $post_ID ) {
		$post_ID = (int) $post_ID;
		$post_type = get_post_type( $post_ID );
		$post_status = get_post_status( $post_ID );
		if ( ! isset( $post_type ) || 'attachment' != $post_type ) {
			return $post_ID;
		}

		if ( $post_type ) {
			if( isset ( $_POST['sidebarcheck'] ) ) {
				update_post_meta( $post_ID, "sidebar", $_POST['sidebarcheck'] );
			} else {
				update_post_meta( $post_ID, "sidebar", null );
			}
		}

		return $post_ID;
	}
}

new UW_Attachment_Meta;
