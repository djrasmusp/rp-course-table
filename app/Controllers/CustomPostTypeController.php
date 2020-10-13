<?php

namespace Course_Table\Controllers;

use Course_Table\Base\BaseController;

if ( ! class_exists( 'CustomPostTypeController' ) ) {
	class CustomPostTypeController extends BaseController {
		public function register() {
			if ( ! empty ($this->custom_post_types ) ) {
				add_action( 'init', array( $this, 'registerCustomPostType' ) );
			}
		}

		public function registerCustomPostType() {
			foreach ( $this->custom_post_types as $post_type ) {
				$labels = array(
					'name'               => __( $post_type['name'] ),
					'singular_name'      => __( $post_type['singular_name'] ),
					'add_new'            => __( 'Tilføj nyt ' . $post_type['singular_name'] ),
					'add_new_item'       => __( 'Tilføj nyt ' . $post_type['singular_name'] ),
					'edit_item'          => __( 'Rediger ' . $post_type['singular_name'] ),
					'new_item'           => __( 'Ny ' . $post_type['singular_name'] ),
					'all_items'          => __( 'Alle ' . $post_type['name'] ),
					'view_item'          => __( 'Vis ' . $post_type['name'] ),
					'search_items'       => __( 'Søg ' . $post_type['name'] ),
					'not_found'          => __( 'Ingen ' . $post_type['name'] . 'fundet' ),
					'not_found_in_trash' => __( 'Ingen ' . $post_type['name'] . ' fundet i skraldespanden' ),
					'parent_item_colon'  => null,
					'menu_name'          => $post_type['name']
				);

				$args = array(
					'labels'             => $labels,
					'rewrite'            => ( isset( $post_type['slug'] ) ) ? array(
						'slug'       => $post_type['slug'],
						'with_front' => false
					) : true,
					'menu_icon'          => $post_type['menu_icon'],
					'supports'           => $post_type['supports'],
					'public'             => $post_type['public'],
					'publicly_queryable' => ( isset( $post_type['publicly_queryable'] ) ) ? $post_type['publicly_queryable'] : $post_type['public'],
					'has_archive'        => $post_type['has_archive']
				);

				register_post_type( $post_type['post_type'], $args );
			}
		}

		public function hasTaxonomies( $taxonomies ) {
			$array = array();

			foreach ( $taxonomies['taxonomies'] as $taxonomy ) {
				$array[] = $taxonomy['taxonomy'];
			}

			return $array;
		}
	}
}