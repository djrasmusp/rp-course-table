<?php

namespace Course_Table\Base;

if ( ! class_exists( 'Deactive' ) ) {
	class Deactive {
		public static function deactivate() {
			flush_rewrite_rules();
		}
	}
}