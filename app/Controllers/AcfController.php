<?php

namespace Course_Table\Controllers;

if ( ! class_exists( 'AcfController' ) ) {
	class AcfController {


		public function register() {
			add_action( 'acf/init', array( $this, 'addPremadeAcf' ) );
			add_filter( 'acf/settings/show_admin', array( $this, 'hideAcfAdmin' ) );
		}

		public function hideAcfAdmin( $show_admin ) {
			return false;
		}

		public function addPremadeAcf() {
			acf_add_local_field_group(
				array(
					'key'                   => 'group_course_info',
					'title'                 => 'Kursus Info',
					'fields'                => array(
						array(
							'key'               => 'field_course_date',
							'label'             => 'Dato',
							'name'              => 'date',
							'type'              => 'date_picker',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => 'date',
								'id'    => '',
							),
							'display_format'    => 'j. F - Y',
							'return_format'     => 'Y-m-d',
							'first_day'         => 1,
						),
						array(
							'key'               => 'field_course_time',
							'label'             => 'Tidspunkt',
							'name'              => 'time',
							'type'              => 'time_picker',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => 'time',
								'id'    => '',
							),
							'display_format'    => 'H:i',
							'return_format'     => 'H:i:s',
						),
						array(
							'key'               => 'field_course_address',
							'label'             => 'Adresse 2',
							'name'              => 'address',
							'type'              => 'textarea',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => 'adress',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'maxlength'         => '',
							'rows'              => 4,
							'new_lines'         => '',
						),
						array(
							'key'               => 'field_course_price',
							'label'             => 'Pris',
							'name'              => 'price',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => 'price',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => 999,
							'prepend'           => '',
							'append'            => 'Kr.',
							'min'               => '',
							'max'               => '',
							'step'              => '',
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'course',
							),
						),
					),
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'seamless',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => true,
					'description'           => '',
				)
			);
		}
	}
}