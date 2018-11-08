<?php

namespace ListingManager\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Attributes({
 *   @Attribute("name", type="string"),
 *   @Attribute("priority", type="integer"),
 *   @Attribute("accepted_args", type="integer"),
 * })
 */
class Action extends Annotation {
	public $name;

	public $priority = 10;

	public $accepted_args = 1;
}
