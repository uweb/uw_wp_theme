<?php
/**
 * BOOSTRAP 4 MEGA MENU WALKER. HEAVILY EDITED FROM ORIGINAL.
 *
 * Extended Walker class for use with the Bootstrap 4 Dropdown menus in Wordpress.
 * Edited to support n-levels submenu and a Mega Menu.
 * @author @jaycbrf4
 * @license CC BY 4.0 https://creativecommons.org/licenses/by/4.0/
 */

/* Check if Class Exists. */
if ( ! class_exists( 'Bootstrap_MegaMenu_Walker' ) ) {

	class Bootstrap_MegaMenu_Walker extends Walker_Nav_Menu {

		/**
		 * Start Level
		 *
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );

			if ( 0 < $depth ) {
				$output	.= "\n$indent<ul class=\"nav-group-links depth-$depth\">\n";
			} else {
				$output	.= "\n$indent<ul class=\"dropdown-menu depth-$depth multi-column\">\n<div class=\"row\">\n";
			}
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @since       1.0.0
		 *
		 * @see Walker::end_lvl()
		 *
		 * @param string   $output Passed by reference. Used to append additional content.
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			if ( 0 < $depth ) {
				$output .= $n . str_repeat( $t, $depth ) . '</ul>' . $n;
			} else {
				$output .= $n . str_repeat( $t, $depth ) . '</div></ul>' . $n;
			}
		}

		/**
		 * Start Element
		 *
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent        = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$li_attributes = '';
			$class_names   = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$classes[] = ( $args->has_children ) ? 'dropdown' : '';
			$classes[] = ( $item->current ) ? 'current_page_item' : '';
			$classes[] = ( $item->current || $item->current_item_ancestor ) ? 'active' : '';
			$classes[] = 'nav-item-' . $item->ID;

			if ( 0 === $depth ) {
				$classes[] = 'top-level-nav';
			}

			if ( $depth && $args->has_children ) {
				$classes[] = 'nav-group ';
			}

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = ' class="nav-item ' . esc_attr( $class_names ) . '"';

			$id = apply_filters( 'nav_menu_item_id', 'nav-item-' . $item->ID, $item, $args );
			$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . $li_attributes . '>';

			$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';

			if ( $item->current ) {
				$attributes .= ' aria-current="page"';
			}

			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

			if ( 0 === $depth && $args->has_children ) {
				$attributes .= ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" role="button"';
			} elseif ( 1 === $depth && $args->has_children ) {
				$attributes .= ' class="nav-link"';
			} else {
				$attributes .= 'class="nav-link"';
			}

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( ( 0 || 1 === $depth ) && ( $args->has_children ) ) ? ' <b class="caret"></b></a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @since 1.0.0
		 *
		 * @see Walker::end_el()
		 *
		 * @param string   $output Passed by reference. Used to append additional content.
		 * @param WP_Post  $item   Page data object. Not used.
		 * @param int      $depth  Depth of page. Not Used.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			if ( $depth && $args->has_children ) {
				$output .= $n . str_repeat( $t, $depth ) . '</li></div>' . $n;
			} else {
				$output .= $n . str_repeat( $t, $depth ) . '</li>' . $n;
			}


		}

		/**
		 * Display Element
		 *
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
			if ( ! $element ) {
				return;
			}

			$id_field = $this->db_fields['id'];

			// display this element.
			if ( is_array( $args[0] ) ) {
				$args[0]['has_children'] = ! empty( $children_elements[ $element->$id_field ] );
			} elseif ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
				$cb_args = array_merge( array( &$output, $element, $depth ), $args );
				call_user_func_array( array( &$this, 'start_el' ), $cb_args );

				$id = $element->$id_field;
			}

			// descend only when the depth is right and there are children for this element.
			if ( ( 0 === $max_depth || $depth + 1 < $max_depth ) && isset( $children_elements[ $id ] ) ) {
				foreach ( $children_elements[ $id ] as $child ) {
					if ( ! isset( $newlevel ) ) {
						$newlevel = true;
						// start the child delimiter.
						$cb_args = array_merge( array( &$output, $depth ), $args );
						call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
					}

					$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
				}

				unset( $children_elements[ $id ] );
			}

			if ( isset( $newlevel ) && $newlevel ) {
				// end the child delimiter.
				$cb_args = array_merge( array( &$output, $depth ), $args );
				call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
			}

			// end this element.
			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( &$this, 'end_el' ), $cb_args );
		}
	}
}
