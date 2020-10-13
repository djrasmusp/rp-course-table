<?php

namespace Course_Table\Base;

if ( ! class_exists( 'Enqueue' ) ) {
	class Enqueue extends BaseController {
		public function register() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		public function enqueue() {
			if(get_current_screen()->post_type == 'course') {
				wp_enqueue_style('rp-course-table', $this->plugin_url .'css/style.css');
				wp_enqueue_script('rp-course-table', $this->plugin_url . 'js/script.js');
			}
		}
	}
}