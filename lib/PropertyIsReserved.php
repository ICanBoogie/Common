<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

use LogicException;
use Throwable;

/**
 * Exception thrown when a property has a reserved name.
 *
 * @property-read string $property Name of the reserved property.
 */
class PropertyIsReserved extends LogicException implements PropertyError
{
    private $property;

    public function __construct($property, Throwable $previous = null)
    {
        $this->property = $property;

        parent::__construct(
            format('Property %property is reserved.', [ '%property' => $property ]),
            0,
            $previous
        );
    }

    public function __get($property)
    {
        if ($property === 'property') {
            return $this->property;
        }

        throw new PropertyNotDefined([ $property, $this ]);
    }
}
