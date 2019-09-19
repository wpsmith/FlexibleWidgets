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

use WPS\WP\Parallax\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( __NAMESPACE__ . '\ParallaxFlexibleWidgetArea' ) ) {
	class ParallaxFlexibleWidgetArea extends ParallaxWidgetArea {

		protected $type = 'parallax-flexible';

		public function do_before() {
			// Wrap the parallax.
			$before           = "<div id=\"$this->id\" class=\"fullwidth parallax-widget-areas parallax-window\" %s><div class=\"wrap\">";
			$mod_prefix       = apply_filters( 'parallax_setting_prefix', 'wps_parallax_' );
			$background_image = get_theme_mod( $mod_prefix . 'setting_' . Customizer::sanitize_name( $this->id ) . '_image' );
			$background_color = get_theme_mod( $mod_prefix . 'setting_' . Customizer::sanitize_name( $this->id ) . '_color' );

			if ( $background_image != '' ) {
				$before = sprintf( $before, 'data-speed="0.1" data-parallax="scroll" data-position="0px 0px" data-image-src="' . $background_image . '"' );
			} elseif ( $background_color != '' ) {
				$before = sprintf( $before, 'style="background-color:' . $background_color . '"' );
			}

			echo $before;
		}

		public function do_after() {
			echo '</div></div></div>';
		}

		public function do_widget_area( $classes = array() ) {
			self::enqueue();

			$this->do_before();

			$widget_area = new FlexibleWidgetArea( $this->id );
			$widget_area->do_widget_area( $classes );

			// End wrap.
			$this->do_after();

		}

	}
}