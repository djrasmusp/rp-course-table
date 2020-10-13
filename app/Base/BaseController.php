<?php

namespace Course_Table\Base;

if ( ! class_exists( 'BaseController' ) ) {
	class BaseController {
		public $plugin_path;
		public $plugin_url;
		public $plugin;

		public $custom_post_types;

		public function __construct() {
			$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
			$this->plugin_url  = plugin_dir_url( dirname( __FILE__, 2 ) );
			$this->plugin      = plugin_basename( dirname( __FILE__, 3 ) ) . '/rp-course-table.php';

			$this->custom_post_types = array(
				array(
					'post_type' => 'course',
					'name' => 'Kurser',
					'singular_name' => 'Kursus',
					'public' => true,
					'publicly_queryable' => false,
					'slug' => 'kurser',
					'menu_icon' => 'dashicons-calendar-alt',
					'supports' => array('title', 'editor'),
					'has_archive' => false,
					'taxonomies' => array(
						array(
							'taxonomy' => 'course-type',
							'object-type' => 'course',
							'name' => 'Kursus Typer',
							'singular_name' => 'Kursus Type',
							'public' => true,
							'hierarchical' => true,
							'slug' => 'kursus-type',
							'premade-terms' => array(
								'Dansk',
								'Matematik',
								'Samfundsfag',
								'Engelsk'
							)
						)
					)
				)
			);
		}
	}
}