<?php

namespace Course_Table\Controllers;

use Course_Table\Widgets\Course_Table_Widget;

if ( ! class_exists( 'ElementorWidgetController' ) ) {
	class ElementorWidgetController {

		private static $_instance = null;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function register() {
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 99 );
		}

		public function register_widgets() {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Course_Table_Widget() );
		}

	}
}