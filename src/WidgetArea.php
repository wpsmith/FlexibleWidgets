<?php

/**
 * Parallax Class
 *
 * Sets up Parallax within WordPress.
 *
 * You may copy, distribute and modify the software as long as you track changes/dates in source files.
 * Any modifications to or software including (via compiler) GPL-licensed code must also be made
 * available under the GPL along with build & install instructions.
 *
 * @package    WPS\Core
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

if ( ! class_exists( __NAMESPACE__ . '\WidgetArea' ) ) {
	abstract class WidgetArea {

		protected $id;
		protected $type;
		protected $classes = array();
		protected $has_featured_classes = false;

		public function __construct( $id ) {

			$this->id = $id;

		}

		public function enqueue() {

			$rel_path = str_replace( ABSPATH, '', dirname( __FILE__ ) );
			wp_enqueue_style(
				'flexible-widgets',
				site_url( $rel_path ) . '/assets/css/flexible-widgets-style.css',
				null,
				filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/flexible-widgets-style.css' )
			);

		}

		/**
		 * Setup widget counts.
		 *
		 * @return int
		 */
		protected function count_widgets() {

			$sidebars_widgets = wp_get_sidebars_widgets();
			if ( isset( $sidebars_widgets[ $this->id ] ) ) {
				return count( $sidebars_widgets[ $this->id ] );
			}

			return 0;
		}

		protected function get_widget_instance( $id ) {
			global $wp_registered_widgets;
			if ( empty( $wp_registered_widgets[ $id ]['callback'] ) ) {
				return array();
			}

			/** @var \WP_Widget $widget */
			$widget   = $wp_registered_widgets[ $id ]['callback'][0];
			$settings = $widget->get_settings();
			$index    = $wp_registered_widgets[ $id ]['params'][0]['number'];

			return ! empty( $settings[ $index ] ) ? $settings[ $index ] : array();
//			return ! empty( $settings[ $widget->number ] ) ? $settings[ $widget->number ] : array();
		}

		/**
		 * Gets uneven|even class.
		 *
		 * @param int $num Number to evaluate.
		 * @param string $prefix Class prefix.
		 *
		 * @return string
		 */
		protected static function get_even_uneven_class( $num, $prefix = '' ) {
			if ( absint( $num ) % 2 == 0 ) {
				return sanitize_html_class( $prefix ) . 'even';
			}

			return sanitize_html_class( $prefix ) . 'uneven';
		}

		/**
		 * Gets uneven|even classes.
		 *
		 * @return array
		 */
		protected function get_featured_even_uneven_classes() {
			$classes = array();

			// Only do this for widget areas that have only a single featured content widget instance.
//			if ( 1 !== $this->count_widgets() ) {

			// Only do this once.
			if ( $this->has_featured_classes ) {
				return $classes;
			}

			// Now check if the widget is a featured widget.
			$sidebars_widgets = wp_get_sidebars_widgets();
			foreach ( $sidebars_widgets[ $this->id ] as $sidebar_widget_id ) {
				if ( false !== strpos( $sidebar_widget_id, 'featured' ) ) {
					$classes[] = 'has-featured-content-widget';

					$instance = $this->get_widget_instance( $sidebar_widget_id );
					if ( isset( $instance['posts_num'] ) ) {
						$classes[] = self::get_even_uneven_class( absint( $instance['posts_num'] ), 'featured-' );
						$classes[] = 'featured-content-count-' . $instance['posts_num'];
						$classes[] = $this->get_column_classes( $instance['posts_num'], 'featured-' );

						$this->has_featured_classes = true;
						return $classes;
					}
				}

			}

			return $classes;
		}

		/**
		 * Gets the sanitized HTML classes as a string.
		 *
		 * @param array $classes
		 *
		 * @return string
		 */
		public function get_sanitized_classes( $classes = array() ) {

			$classes = array_merge( $this->classes, $classes );
			$classes = array_merge( $this->get_widget_area_classes(), $classes );
			$classes = array_merge( $classes, array(
				$this->id,
				'widget-area',
				"{$this->type}-widget-area",
			) );

			return implode( ' ', array_unique( array_map( 'sanitize_html_class', array_map( 'trim', $classes ) ) ) );

		}

		/**
		 * Get the widget's classes.
		 *
		 * @return array
		 */
		protected function _get_widget_area_classes() {

			$count = $this->count_widgets();

			$classes   = array( "$this->id-widget-area" );
			$classes[] = "widget-count-$count";
			$classes[] = self::get_even_uneven_class( $count, 'widgets-' );
			$classes   = array_merge( $classes, $this->get_featured_even_uneven_classes() );

			return $classes;

		}

		/**
		 * Get the widget's classes.
		 *
		 * @return array
		 */
		protected function get_widget_area_classes() {

			$count     = $this->count_widgets();
			$classes   = $this->_get_widget_area_classes();
			$classes[] = $this->get_column_classes( $count );

			return $classes;

		}

		/**
		 * Get the widget's classes.
		 *
		 * @return string
		 */
		protected function get_column_classes( $count, $prefix = 'widget-' ) {

//			if ( $count == 1 ) {
//				$classes[] = 'widget-full';
//			} elseif ( 0 === $count % 4 ) {
//				$classes[] = 'widget-fourths';
//				$classes[] = 'even';
//			} elseif ( 0 === $count % 3 ) {
//				$classes[] = 'widget-thirds';
//			} elseif ( 0 === $count % 2 ) {
//				$classes[] = 'widget-halves';
//				$classes[] = 'even';
//			} else {
//				$classes[] = 'widget-halves';
//				$classes[] = 'uneven';
//			}

			if ( $count == 1 ) {
				return "${prefix}full";
			} elseif ( 0 === $count % 4 ) {
				return "${prefix}fourths";
			} elseif ( 0 === $count % 3 ) {
				return "${prefix}thirds";
			} elseif ( 0 === $count % 2 ) {
				return "${prefix}halves";
			} else {
				return "${prefix}halves";
			}

		}

		/**
		 * Outputs the widget area.
		 *
		 * @param array $classes Optional classes to add.
		 */
		abstract public function do_widget_area( $classes = array() );

		/**
		 * Conditionally does the widget area if the sidebar is active.
		 *
		 * @param array $classes Optional classes to add.
		 */
		public function maybe_do_widget_area( array $classes = array() ) {
			if ( ! is_active_sidebar( $this->id ) ) {
				return;
			}

			$this->enqueue();
			$this->do_widget_area( $classes );
//			$this->do_widget_area( array_merge( $classes, $this->get_widget_area_classes() ) );

//			switch ( $type ) {
//				case 'halves':
//					self::do_flexible_widget( $id, 'halves', $classes );
//					break;
//				case 'parallax-halves':
//				case 'flexible-parallax-halves':
//					self::do_parallax_flexible_widget_area( $id, $type, $classes );
//					break;
//				case 'flexible-alt':
//				case 'flexible-alternate':
//					self::do_flexible_widget( $id, 'alt', $classes );
//					break;
//				case 'flexible':
//					self::do_flexible_widget( $id, 'flexible', $classes );
//					break;
//				case 'parallax-flexible':
//				case 'flexible-parallax':
//					self::do_parallax_flexible_widget_area( $id, 'flexible', $classes );
//					break;
//				case 'parallax':
//					self::do_parallax_widget_area( $id, $classes );
//					break;
//				default:
//					self::do_widget_area( $id, $classes );
//					break;
//			}
		}

	}
}