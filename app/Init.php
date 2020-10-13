<?php

namespace Course_Table;

if (!class_exists('Init')) {
    class Init
    {
        public static function get_services() {
            return [
            	Controllers\CustomPostTypeController::class,
	            Controllers\CustomTaxonomyController::class,
	            Controllers\AcfController::class,
	            Controllers\AdminColumnsController::class,
	            Controllers\ElementorWidgetController::class,
            ];
        }

        public static function register_services() {
            foreach (self::get_services() as $class ){
                $service = self::instantiate($class);
                if(method_exists($service, 'register')) {
                    $service->register();
                }
            }
        }

        private static function instantiate ($class) {
            $service = new $class();

            return $service;
        }
    }
}