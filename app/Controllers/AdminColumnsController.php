<?php

namespace Course_Table\Controllers;

if ( ! class_exists( 'AdminColumnsController' ) ) {
	class AdminColumnsController {
		public function register() {
			add_filter('manage_course_posts_columns', array($this, 'addColumns'));
			add_filter('manage_edit-course_sortable_columns', array($this, 'addToSortable'));
			add_action('manage_course_posts_custom_column', array($this, 'addDataToColumns'), 10, 2);
			add_action('pre_get_posts', array($this, 'sortableCourseDate'));
		}

		public function addColumns($columns) {
			$columns = array(
				'cb' => $columns['cb'],
				'title' => __('Kursus'),
				'type' => __('Kursus Type'),
				'course_date' => __('Afholdelses'),
				'date' => __('Oprettet')
			);

			return $columns;
		}

		public function addToSortable($columns){
			$columns['course_date'] = 'course_date_sort';

			return $columns;
		}

		public function addDataToColumns($column, $post_id){
			if('type' === $column){
				$this->typeColumn($post_id);
			}

			if('course_date' === $column){
				$this->dateColumn($post_id);
			}
		}

		public function sortableCourseDate($query) {
			if (! is_admin() ) {
				return;
			}

			$orderby = $query->get('orderby');

			if( 'course_date_sort' == $orderby){
				$query->set('orderby', 'meta_value');
				$query->set('meta_key', 'date');
			}

			return $query;
		}

		private function typeColumn($post_id){
			$terms = get_the_terms($post_id, 'course-type');
			$terms_string = join(', ', wp_list_pluck($terms, 'name'));

			echo $terms_string;
		}

		private function dateColumn($post_id) {
			$course_date = get_field('date', $post_id);
			$course_time = get_field('time', $post_id);

			echo date_i18n('d. F - Y k\l. H:i', strtotime($course_date . ' ' . $course_time));
		}
	}
}