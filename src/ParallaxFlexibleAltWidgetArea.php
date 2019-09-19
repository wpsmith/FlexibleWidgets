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

if ( ! class_exists( __NAMESPACE__ . '\ParallaxFlexibleAltWidgetArea' ) ) {
	class ParallaxFlexibleAltWidgetArea extends ParallaxFlexibleWidgetArea {

		protected $type = 'parallax-flexible-alt';

		public function do_widget_area( $classes = array() ) {
			self::enqueue();

			$this->do_before();

			$widget_area = new FlexibleAltWidgetArea( $this->id );
			$widget_area->do_widget_area( $classes );

			// End wrap.
			$this->do_after();

		}

	}
}