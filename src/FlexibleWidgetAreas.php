<?php

/**
 * FlexibleWidgetAreas Class
 *
 * Sets up Flexible Widget Areas within WordPress.
 *
 * You may copy, distribute and modify the software as long as you track changes/dates in source files.
 * Any modifications to or software including (via compiler) GPL-licensed code must also be made
 * available under the GPL along with build & install instructions.
 *
 * @package    WPS\WP\FlexibleWidgets
 * @author     Travis Smith <t@wpsmith.net>
 * @copyright  2015-2019 Travis Smith
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License v2
 * @link       https://github.com/wpsmith/WPS
 * @version    1.0.0
 * @since      0.1.0
 */

namespace WPS\WP\FlexibleWidgets;

use WPS\Core\Singleton;
use WPS\WP\Parallax\Customizer;
use WPS\WP\Parallax\ParallaxScript;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( __NAMESPACE__ . '\FlexibleWidgetAreas' ) ) {
	class FlexibleWidgetAreas extends Singleton {

		protected static function _maybe_do_widget_area( $classname, $id, $classes = array() ) {

			/* @var WidgetArea $widget_area */
			$widget_area = new $classname( $id );
			$widget_area->maybe_do_widget_area( $classes );

		}

		public static function maybe_do_default_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\DefaultWidgetArea', $id, $classes );

		}

		public static function maybe_do_halves_full_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\HalvesWidgetArea', $id, $classes );

		}

		public static function maybe_do_halves_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\HalvesWidgetArea', $id, $classes );

		}

		public static function maybe_do_flexible_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\FlexibleWidgetArea', $id, $classes );

		}

		public static function maybe_do_flexible_alt_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\FlexibleAltWidgetArea', $id, $classes );

		}

		public static function maybe_do_parallax_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\ParallaxWidgetArea', $id, $classes );

		}

		public static function maybe_do_parallax_flexible_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\ParallaxFlexibleWidgetArea', $id, $classes );

		}

		public static function maybe_do_parallax_halves_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\ParallaxHalvesWidgetArea', $id, $classes );

		}

		public static function maybe_do_parallax_flexible_alt_widget_area( $id, $classes = array() ) {

			self::_maybe_do_widget_area( __NAMESPACE__ . '\ParallaxFlexibleAltWidgetArea', $id, $classes );

		}

//		public static function enqueue_style() {
//
//			$rel_path = str_replace( ABSPATH, '', dirname( __FILE__ ) );
//			wp_enqueue_style(
//				'flexible-widgets',
//				site_url( $rel_path ) . '/css/flexible-widgets-style.css',
//				null,
//				filemtime( plugin_dir_path( __FILE__ ) . 'css/flexible-widgets-style.css' )
//			);
//
//		}
//
//		/**
//		 * Setup widget counts.
//		 *
//		 * @param string $id Sidebar ID.
//		 *
//		 * @return int
//		 */
//		protected static function count_widgets( $id ) {
//
//			$sidebars_widgets = wp_get_sidebars_widgets();
//			if ( isset( $sidebars_widgets[ $id ] ) ) {
//				return count( $sidebars_widgets[ $id ] );
//			}
//
//			return 0;
//		}
//
//		protected static function get_widget_instance( $id ) {
//			global $wp_registered_widgets;
//			if ( empty( $wp_registered_widgets[ $id ]['callback'] ) ) {
//				return array();
//			}
//			/** @var \WP_Widget $widget */
//			$widget   = $wp_registered_widgets[ $id ]['callback'][0];
//			$settings = $widget->get_settings();
//
//			return ! empty( $settings[ $widget->number ] ) ? $settings[ $widget->number ] : array();
//		}
//
//		/**
//		 * Gets uneven|even class.
//		 *
//		 * @param int $num Number to evaluate.
//		 * @param string $prefix Class prefix.
//		 *
//		 * @return string
//		 */
//		protected static function get_even_uneven_class( $num, $prefix = '' ) {
//			if ( absint( $num ) % 2 == 0 ) {
//				return sanitize_html_class( $prefix ) . 'even';
//			}
//
//			return sanitize_html_class( $prefix ) . 'uneven';
//		}
//
//		/**
//		 * Gets uneven|even classes.
//		 *
//		 * @param string $id Sidebar ID.
//		 *
//		 * @return array
//		 */
//		protected static function get_featured_even_uneven_class( $id ) {
//			$classes = array();
//
//			// Only do this for widget areas that have only a single featured content widget instance.
//			if ( 1 !== self::count_widgets( $id ) ) {
//				return $classes;
//			}
//
//			// Now check if the widget is a featured widget.
//			$sidebars_widgets = wp_get_sidebars_widgets();
//			foreach ( $sidebars_widgets[ $id ] as $sidebar_widget_id ) {
//				if ( false !== strpos( $sidebar_widget_id, 'featured' ) ) {
//					$classes[] = 'has-featured-content-widget';
//
//					$instance = self::get_widget_instance( $sidebar_widget_id );
//					if ( isset( $instance['posts_num'] ) ) {
//						$classes[] = self::get_even_uneven_class( absint( $instance['posts_num'] ), 'featured-' );
//						$classes[] = 'featured-content-count-' . $instance['posts_num'];
//
//						return $classes;
//					}
//				}
//
//			}
//
//			return $classes;
//		}
//
//		/**
//		 * Get the widgets basic classes.
//		 *
//		 * @param string $id Sidebar ID.
//		 * @param int $count Number of widgets.
//		 *
//		 * @return array
//		 */
//		protected static function _get_widget_area_class( $id, $count ) {
//
//			$classes   = array( "widget-count-$count" );
//			$classes[] = self::get_even_uneven_class( $count, 'widget-' );
//			$classes[] = self::get_featured_even_uneven_class( $id );
//
//			return $classes;
//
//		}
//
//		/**
//		 * Determine the widget area class.
//		 *
//		 * @param string $id Sidebar ID.
//		 *
//		 * @return array
//		 */
//		protected static function get_widget_area_class( $id ) {
//
//			$count   = self::count_widgets( $id );
//			$classes = self::_get_widget_area_class( $id, $count );
//
//			if ( $count == 1 ) {
//				$classes[] = 'widget-full';
//			} elseif ( 0 === $count % 4 ) {
//				$classes[] = 'widget-fourths';
//			} elseif ( 0 === $count % 3 ) {
//				$classes[] = 'widget-thirds';
//			} elseif ( 0 === $count % 2 ) {
//				$classes[] = 'widget-halves';
//			} else {
//				$classes[] = 'widget-halves uneven';
//			}
//
//			return $classes;
//
//		}
//
//		/**
//		 * Gets the alternate widget area classes.
//		 *
//		 * @param string $id The widget ID.
//		 *
//		 * @return array
//		 */
//		protected static function get_alternate_widget_area_class( $id ) {
//
//			$count   = self::count_widgets( $id );
//			$classes = self::_get_widget_area_class( $id, $count );
//
//			if ( 1 === $count || 2 === $count ) {
//				$classes[] = 'widget-full';
//			} elseif ( 1 === $count % 3 ) {
//				$classes[] = 'widget-thirds';
//			} elseif ( 1 === $count % 4 ) {
//				$classes[] = 'widget-fourths';
//			} elseif ( 0 === $count % 2 ) {
//				$classes[] = 'widget-halves uneven';
//			} else {
//				$classes[] = 'widget-halves';
//			}
//
//
//			return $classes;
//
//		}
//
//		/**
//		 * Gets halves widget area classes.
//		 *
//		 * @param string $id Sidebar ID.
//		 *
//		 * @return array
//		 */
//		protected static function get_halves_widget_area_class( $id ) {
//
//			$count   = self::count_widgets( $id );
//			$classes = self::_get_widget_area_class( $id, $count );
//
//			if ( $count == 1 ) {
//				$classes[] = 'widget-full';
//			} elseif ( $count % 2 == 0 ) {
//				$classes[] = 'widget-halves';
//			} else {
//				$classes[] = 'widget-halves uneven';
//			}
//
//			return $classes;
//
//		}
//
//		/**
//		 * Gets the classes by widget area type.
//		 *
//		 * @param string $id Sidebar ID.
//		 * @param string $type Type of widget area.
//		 *
//		 * @return array
//		 */
//		protected static function get_classes_by_type( $id, $type ) {
//			switch ( $type ) {
//				case 'halves':
//				case 'parallax-halves':
//					$classes = self::get_halves_widget_area_class( $id );
//					break;
//				case 'alt':
//				case 'alternate':
//					$classes   = self::get_alternate_widget_area_class( $id );
//					$classes[] = 'alternate';
//					break;
//				default:
//					$classes = self::get_widget_area_class( $id );
//					break;
//			}
//
//			return array_filter( $classes );
//		}
//
//		/**
//		 * Gets the sanitized HTML classes as a string.
//		 *
//		 * @param array $classes
//		 *
//		 * @return string
//		 */
//		public static function get_sanitized_classes( $classes ) {
//
//			return implode( ' ', array_unique( array_map( 'sanitize_html_class', array_map( 'trim', $classes ) ) ) );
//
//		}
//
//		/**
//		 * Helper function to handle outputting widget markup and classes.
//		 *
//		 * @param string $id The id of the widget area.
//		 * @param string $type Whether to output flexible, flexible alternate class, or halves.
//		 * @param array $classes Additional classes to add to widget area.
//		 */
//		public static function do_flexible_widget( $id, $type = 'flexible', $classes = array() ) {
//
//			$classes = self::get_sanitized_classes( array_merge( $classes, self::get_classes_by_type( $id, $type ) ) );
//
//			genesis_widget_area( $id, array(
//				'before' => "<div id=\"$id\" class=\"$id\"><div class=\"widget-area flexible-widget-area widgets-$type $classes\"><div class=\"wrap\">",
//				'after'  => '</div></div></div>',
//			) );
//
//		}
//
//		public static function do_parallax_flexible_widget_area( $id, $type = 'flexible', $classes = array() ) {
//			global $wp_registered_sidebars;
//
//			$classes = self::get_sanitized_classes( array_merge( $classes, array( $id, 'parallax-flexible-widget-area' ) ) );
////			$classes = trim( trim( $classes ) . " $id parallax-flexible-widget-area" );
//
//			// Before for parallax.
//			if ( isset( $wp_registered_sidebars[ $id ]['parallax'] ) && $wp_registered_sidebars[ $id ]['parallax'] ) {
//				$before = "<div id=\"$id\" class=\"$classes fullwidth parallax-window\" %s>";
////				$before = "<div id=\"$id\" class=\"$classes widget-area flexible-widget-area fullwidth parallax-window\" %s>";
//			} else {
//				// Before with no ID attribute.
//				$before = "<div class=\"$classes fullwidth parallax-window\" %s>";
////				$before = "<div class=\"$id widget-area flexible-widget-area fullwidth parallax-window\" %s>";
//			}
//
//			// Before wrap.
//			$before .= '<div class="wrap">';
//
//			// Before flexible widgets.
//			$before .= sprintf(
//				'<div class="widget-area flexible-widget-area %s">',
//				self::get_sanitized_classes( self::get_classes_by_type( $id, $type ) )
//			);
//
//			// After.
//			$after = '</div></div></div>';
//
//			$mod_prefix       = apply_filters( 'parallax_setting_prefix', 'wps_parallax_' );
//			$background_image = get_theme_mod( $mod_prefix . 'setting_' . Customizer::sanitize_name( $id ) . '_image' );
//			$background_color = get_theme_mod( $mod_prefix . 'setting_' . Customizer::sanitize_name( $id ) . '_color' );
//
//			if ( $background_image != '' ) {
//				$before = sprintf( $before, 'data-speed="0.1" data-parallax="scroll" data-position="0px 0px" data-image-src="' . $background_image . '"' );
//			} elseif ( $background_color != '' ) {
//				$before = sprintf( $before, 'style="background-color:' . $background_color . '"' );
//			}
//
//			// Output widget area!
//			genesis_widget_area( $id, array(
//				'before' => $before,
//				'after'  => $after,
//			) );
//		}
//
//		public static function do_parallax_widget_area( $id, $classes = array() ) {
//			$classes = self::get_sanitized_classes( array_merge( $classes, array( $id ) ) );
//
//			genesis_widget_area( $id, array(
//				'before' => "<div id=\"$id\" class=\"$classes widget-area flexible-widget-area parallax-window parallax-widget-area\"><div class=\"wrap\">",
//				'after'  => '</div></div>',
//			) );
//		}
//
//		public static function do_widget_area( $id, $classes = array() ) {
//			$classes = self::get_sanitized_classes( array_merge( $classes, array(
//				$id,
//				'widget-area',
//			) ) );
//
//			genesis_widget_area( $id, array(
//				'before' => "<div class=\"$classes\">",
//				'after'  => '</div>',
//			) );
//		}
//
//		public static function maybe_do_parallax_widget_areas( $id, $widget_areas, $args = array() ) {
//			$is_active = false;
//
//			// Determine whether all the widget areas are active.
//			foreach ( $widget_areas as $widget_area ) {
//				if ( isset( $widget_area['id'] ) && is_active_sidebar( $widget_area['id'] ) ) {
//					$is_active = true;
//				}
//			}
//
//			if ( ! $is_active ) {
//				return;
//			}
//
//			self::enqueue_style();
//
//			/**
//			 * @var string $data Data attributes
//			 * @var string $classes Classes.
//			 */
//			extract( wp_parse_args( $args, array(
//				'data'    => '',
//				'classes' => '',
//			) ) );
//			$classes = trim( trim( $classes ) . " parallax-widget-areas $id" );
//
//			// Wrap the parallax.
//			$before           = "<div id=\"$id\" class=\"$classes widget-area flexible-widget-area fullwidth parallax-window\" %s><div class=\"wrap\">";
//			$mod_prefix       = apply_filters( 'parallax_setting_prefix', 'wps_parallax_' );
//			$background_image = get_theme_mod( $mod_prefix . 'setting_' . Customizer::sanitize_name( $id ) . '_image' );
//			$background_color = get_theme_mod( $mod_prefix . 'setting_' . Customizer::sanitize_name( $id ) . '_color' );
//
//			if ( $background_image != '' ) {
//				$data   = trim( $data );
//				$before = sprintf( $before, 'data-speed="0.1" data-parallax="scroll" data-position="0px 0px" data-image-src="' . $background_image . '" ' . $data );
//			} elseif ( $background_color != '' ) {
//				$before = sprintf( $before, 'style="background-color:' . $background_color . '"' );
//			}
//
//			echo $before;
//
//			// Output the widget areas.
//			foreach ( $widget_areas as $index => $widget_area ) {
//				$widget_areas[ $index ] = wp_parse_args( $widget_area, array(
//					'classes' => '',
//					'id'      => '',
//					'type'    => '',
//				) );
//
//				FlexibleWidgetAreas::maybe_do_widget_area( $widget_area['id'], $widget_area['type'], $widget_area['classes'] );
//			}
//
//			// End wrap.
//			echo '</div></div>';
//
//		}

		/**
		 * Conditionally does the widget area if the sidebar is active.
		 *
		 * @param string $id Sidebar ID.
		 * @param string $type Type of widget area.
		 * @param array $classes Optional classes to add.
		 */
		public static function maybe_do_widget_area( $id, $type = 'default', $classes = array() ) {
			if ( ! is_active_sidebar( $id ) ) {
				return;
			}

			switch ( $type ) {
				case 'halves-full':
					self::maybe_do_halves_full_widget_area( $id, $classes );
					break;
				case 'halves':
					self::maybe_do_halves_widget_area( $id, $classes );
					break;
				case 'halves-parallax':
				case 'parallax-halves':
					self::maybe_do_parallax_halves_widget_area( $id, $classes );
					break;
				case 'flexible-alt':
				case 'flexible-alternate':
				case 'alt-flexible':
				case 'alternate-flexible':
					self::maybe_do_flexible_alt_widget_area( $id, $classes );
					break;
				case 'flexible':
					self::maybe_do_flexible_widget_area( $id, $classes );
					break;
				case 'parallax-flexible':
				case 'flexible-parallax':
					self::maybe_do_parallax_flexible_widget_area( $id, $classes );
					break;
				case 'parallax-flexible-alt':
				case 'flexible-alt-parallax':
					self::maybe_do_parallax_flexible_alt_widget_area( $id, $classes );
					break;
				case 'parallax':
					self::maybe_do_parallax_widget_area( $id, $classes );
					break;
				default:
					self::maybe_do_default_widget_area( $id, $classes );
					break;
			}
		}
	}
}