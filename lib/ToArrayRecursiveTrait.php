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

/**
 * Implements {@link ToArrayRecursive}.
 */
trait ToArrayRecursiveTrait
{
    /**
     * Transforms an instance into an array.
     */
    abstract public function to_array(): array;

    /**
     * Transforms an instance into an array recursively.
     */
    public function to_array_recursive(): array
    {
        $array = $this->to_array();

        foreach ($array as &$value) {
            if ($value instanceof ToArrayRecursive) {
                $value = $value->to_array_recursive();
            } elseif ($value instanceof ToArray) {
                $value = $value->to_array();
            }
        }

        return $array;
    }
}
