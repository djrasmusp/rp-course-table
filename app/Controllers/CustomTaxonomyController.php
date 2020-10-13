<?php

namespace Course_Table\Controllers;

use Course_Table\Base\BaseController;

if ( ! class_exists( 'CustomTaxonomyController' ) ) {
	class CustomTaxonomyController extends BaseController {
		public function register() {
			if ( ! empty( $this->custom_post_types ) ) {
				add_action( 'init', array( $this, 'registerCustomTaxonomies' ), 0 );
				add_action( 'init', array( $this, 'registerPremadeTerms' ), 0 );
			}
		}

		public function registerCustomTaxonomies() {
			foreach ( $this->custom_post_types as $custom_post_type ) {
				if ( isset( $custom_post_type['taxonomies'] ) ) {
					foreach ( $custom_post_type['taxonomies'] as $taxonomy ) {
						$labels = array(
							'name'          => __( $taxonomy['name'] ),
							'singluar_name' => __( $taxonomy['singular_name'] ),
							'add_new_item' => __('Tilføj nyt ' . $taxonomy['singular_name'])
						);

						$args = array(
							'hierarchical' => $taxonomy['hierarchical'],
							'labels'       => $labels,
							'public'       => $taxonomy['public'],
							'rewrite'            => ( isset( $taxonomy['slug'] ) ) ? array(
								'slug'       => $taxonomy['slug'],
								'with_front' => false
							) : true,
						);

						register_taxonomy( $taxonomy['taxonomy'], $custom_post_type['post_type'], $args );
					}
				}
			}
		}

		public function registerPremadeTerms() {
			foreach ( $this->custom_post_types as $custom_post_type ) {
				if ( isset( $custom_post_type['taxonomies'] ) ) {
					foreach ($custom_post_type['taxonomies'] as $taxonomy) {
						if(isset($taxonomy['premade-terms'])) {
							foreach ($taxonomy['premade-terms'] as $term){
								wp_insert_term ($term, $taxonomy['taxonomy']);
							}
						}
					}
				}
			}
		}
	}
}
