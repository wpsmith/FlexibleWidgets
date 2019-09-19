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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( __NAMESPACE__ . '\HalvesWidgetArea' ) ) {
	class HalvesWidgetArea extends WidgetArea {

		protected $type = 'halves';
		protected $classes = array( 'flexible-widget-area' );

		public function do_widget_area( $classes = array() ) {
			$classes = $this->get_sanitized_classes( $classes );

			genesis_widget_area( $this->id, array(
				'before' => "<div id=\"$this->id\" class=\"$this->id\"><div class=\"$classes\"><div class=\"wrap\">",
				'after'  => '</div></div></div>',
			) );

		}

		/**
		 * Get the widget's classes.
		 *
		 * @return string
		 */
		protected function get_column_classes( $count, $prefix = 'widget-' ) {

			if ( $count == 1 ) {
				return "${prefix}full";
			} else {
				return "${prefix}halves";
			}

		}

	}
}