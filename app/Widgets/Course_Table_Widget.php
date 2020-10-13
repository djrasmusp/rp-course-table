<?php

namespace Course_Table\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! class_exists( 'Course_Table_Widget' ) ) {
	class Course_Table_Widget extends Widget_Base {

		public function get_name() {
			return 'course-table';
		}

		public function get_title() {
			return 'Kursus Table';
		}

		public function get_icon() {
			return 'fas fa-chalkboard-teacher';
		}

		public function get_categories() {
			return [ 'general' ];
		}

		protected function _register_controls() {
			$this->start_controls_section(
				'section_content',
				[
					'label' => 'Indstillinger',
				]
			);

			$this->add_control(
				'label_heading',
				[
					'label'   => 'Table overskrift',
					'type'    => Controls_Manager::TEXT,
					'default' => 'Kurser'
				]
			);

			$this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$this->add_inline_editing_attributes( 'label_heading', 'basic' );
			$this->add_render_attribute(
				'label_heading',
				[
					'class' => [ 'course_table_heading' ]
				]
			);

			$sortby    = ( isset( $_GET['sortby'] ) ? $_GET['sortby'] : null );
			$direction = ( isset( $_GET['direction'] ) ? $_GET['direction'] : null );

			?>

            <h2 <?php echo $this->get_render_attribute_string( 'label_heading' ) ?>><?php echo $settings['label_heading'] ?></h2>
            <table class="course_table">
                <tr>
                    <th><a href="<?php echo $this->directionLink( 'title', $direction ) ?>">Kursus</a></th>
                    <th>Beskrivelse</th>
                    <th><a href="<?php echo $this->directionLink( 'date', $direction ) ?>">Dato</a></th>
                    <th>Tidspunkt</th>
                    <th>Addresse</th>
                    <th><a href="<?php echo $this->directionLink( 'price', $direction ) ?>">Pris</a></th>
                </tr>

				<?php

				foreach ( $this->getCourses( $sortby, $direction ) as $course ) {
					echo '<tr>';
					echo '<td>' . $course->post_title . '</td>';
					echo '<td>' . $course->post_content . '</td>';
					echo '<td>' . $this->courseDate( $course->ID ) . '</td>';
					echo '<td>' . $this->courseTime( $course->ID ) . '</td>';
					echo '<td>' . $this->courseField( 'address', $course->ID ) . '</td>';
					echo '<td>' . number_format_i18n( $this->courseField( 'price', $course->ID ) ) . ' kr.</td>';
					echo '</tr>';
				}
				?>

            </table>
			<?php
		}

		protected function _content_template() {
			?>
            <#
            view.addInlineEditingAttributes( 'label_heading', 'basic' );
            view.addRenderAttribute(
            'label_heading',
            {
            'class': [ 'course_table_heading' ],
            }
            );
            #>
            <h2 {{{ view.getRenderAttributeString( 'label_heading' ) }}}>{{{ settings.label_heading }}}</h2>
            <table>
                <tr>
                    <th>Kursus</th>
                    <th>Beskrivelse</th>
                    <th>Dato</th>
                    <th>Tidspunkt</th>
                    <th>Pris</th>
                </tr>
				<?php
				foreach ( $this->getCourses() as $course ) {
					echo '<tr>';
					echo '<td>' . $course->post_title . '</td>';
					echo '<td>' . $course->post_content . '</td>';
					echo '<td>' . $this->courseDate( $course->ID ) . '</td>';
					echo '<td>' . $this->courseTime( $course->ID ) . '</td>';
					echo '<td>' . $this->courseField( 'address', $course->ID ) . '</td>';
					echo '<td>' . number_format_i18n( $this->courseField( 'price', $course->ID ) ) . ' kr.</td>';
					echo '</tr>';
				} ?>
            </table>
			<?php
		}

		protected function getCourses( $sort = null, $direction = null ) {
			$args = [
				'post_type'      => 'course',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					'relation'     => 'AND',
					'date_clause'  => array(
						'key'     => 'date',
						'compare' => 'EXISTS'
					),
					'time_clause'  => array(
						'key'     => 'time',
						'compare' => 'EXISTS'
					)
				),
			];

			return get_posts( array_merge( $args, $this->sortby( $sort, $direction ) ) );
		}

		protected function courseField( $field, $post_id ) {
			return get_field( $field, $post_id );
		}

		protected function courseDate( $post_id ) {
			return date_i18n( 'd. F - Y', strtotime( get_field( 'date', $post_id ) ) );
		}

		protected function courseTime( $post_id ) {
			return substr( get_field( 'time', $post_id ), 0, 5 );
		}

		protected function sortby( $sort = null, $direction = null ) {

			if ( $direction == 'DESC' ) {
				$direction = 'DESC';
			} else {
				$direction = 'ASC';
			}

			switch ( $sort ) {
				case 'title':
					return [
						'orderby' => [
							'post_title' => $direction
						]
					];
				case 'price':
					return [
						'meta_key' => 'price',
						'orderby'  => 'meta_value_num',
						'order'    => $direction
                    ];
				default:
					return [
						'orderby' => [
							'date_clause' => $direction,
							'time_clause' => $direction,
						]
					];
			}
		}

		protected function directionLink( $sortby, $direction = null ) {
			$get_sortby = ( isset( $_GET['sortby'] ) ? $_GET['sortby'] : null );

			if ( $get_sortby == $sortby ) {
				if ( is_null( $direction ) ) {
					return '?sortby=' . $sortby . '&direction=DESC';
				}
			}

			return '?sortby=' . $sortby;
		}
	}
}
