<?php

namespace ListingManager\Annotation\Handler;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

use ListingManager\Annotation\Filter;

class FilterHandler {
	public function __construct() {
		AnnotationRegistry::registerAutoloadNamespace( 'ListingManager\Annotation\Filter', LISTING_MANAGER_DIR . '/src/' );
	}

	public function handle( $class_name ) {
		$annotation_reader = new AnnotationReader();
		$annotation_reader::addGlobalIgnoredName( 'type' );
		$class_methods = get_class_methods( $class_name );

		if ( is_array( $class_methods ) ) {
			foreach ( $class_methods as $method ) {
				$reflection_method = new \ReflectionMethod( $class_name, $method );
				$method_annotations = $annotation_reader->getMethodAnnotations( $reflection_method );

				if ( is_array( $method_annotations ) ) {
					foreach ( $method_annotations as $annotation ) {
						if ( $annotation instanceof Filter ) {
							add_filter( $annotation->name, [ $class_name, $method ], $annotation->priority, $annotation->accepted_args );
						}
					}
				}
			}
		}
	}
}
