<?php

namespace ICanBoogie;

use LogicException;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_merge;
use function array_search;
use function array_shift;
use function array_splice;
use function array_unshift;
use function array_walk;
use function asort;
use function count;
use function is_array;
use function is_numeric;
use function is_scalar;
use function max;
use function min;
use function reset;
use function substr;
use function trigger_error;

use const E_USER_DEPRECATED;

/**
 * Sorts an array using a stable sorting algorithm while preserving its keys.
 *
 * A stable sorting algorithm maintains the relative order of values with equal keys.
 *
 * The array is always sorted in ascending order, but one can use the array_reverse() function to
 * reverse the array. Also, keys are preserved, even numeric ones, use the array_values() function
 * to create an array with an ascending index.
 *
 * @param array<int|string, mixed> $array
 *
 * @deprecated Sorting has been stable since PHP 8.0 https://wiki.php.net/rfc/stable_sorting
 */
function stable_sort(array &$array, callable $picker = null): void
{
    @trigger_error('icanboogie/common: stable_sort() is deprecated, use asort() or uasort()', E_USER_DEPRECATED);

    if ($picker) {
        uasort($array, $picker);
    } else {
        asort($array);
    }
}

/**
 * Sort an array according to the weight of its items.
 *
 * The weight of the items is defined as an integer; a position relative to another member of the
 * array `before:<key>` or `after:<key>`; the special words `top` and `bottom`.
 *
 * @param array<int|string, mixed> $array
 * @param callable $weight_picker The callback function used to pick the weight of the item. The
 * function is called with the following arguments: `$value`, `$key`.
 *
 * @return array<int|string, mixed> A sorted copy of the array.
 */
function sort_by_weight(array $array, callable $weight_picker): array
{
    if (!$array) {
        return $array;
    }

    $order = [];

    foreach ($array as $k => $v) {
        $order[$k] = $weight_picker($v, $k);
    }

    $n = count($order);

    $numeric_order = array_filter($order, fn($weight) => is_scalar($weight) && is_numeric($weight));

    if ($numeric_order) {
        $top = min($numeric_order) - $n;
        $bottom = max($numeric_order) + $n;
    } else {
        $top = -$n;
        $bottom = $n;
    }

    foreach ($order as &$weight) {
        if ($weight === 'top') {
            $weight = --$top;
        } else {
            if ($weight === 'bottom') {
                $weight = ++$bottom;
            }
        }
    }

    foreach ($order as $k => &$weight) {
        if (str_starts_with($weight, 'before:')) {
            $target = substr($weight, 7);

            if (isset($order[$target])) {
                $order = array_insert($order, $target, $order[$target], $k);
            } else {
                $weight = 0;
            }
        } else {
            if (str_starts_with($weight, 'after:')) {
                $target = substr($weight, 6);

                if (isset($order[$target])) {
                    $order = array_insert($order, $target, $order[$target], $k, true);
                } else {
                    $weight = 0;
                }
            }
        }
    }

    asort($order);

    array_walk($order, function (&$v, $k) use ($array) {
        $v = $array[$k];
    });

    return $order;
}

/**
 * Inserts a value in an array before, or after, a given key.
 *
 * Numeric keys are not preserved.
 *
 * @param array<int|string, mixed> $array
 * @param mixed $relative
 * @param mixed $value
 * @param string|int|null $key
 * @param bool $after
 *
 * @return array<int|string, mixed>
 */
function array_insert(array $array, mixed $relative, mixed $value, string|int $key = null, bool $after = false): array
{
    if ($key) {
        unset($array[$key]);
    }

    $keys = array_keys($array);
    $pos = array_search($relative, $keys, true);

    if ($pos === false) {
        throw new LogicException("Relative not found.");
    }

    if ($after) {
        $pos++;
    }

    $spliced = array_splice($array, $pos);

    if ($key !== null) {
        $array = array_merge($array, [ $key => $value ]);
    } else {
        array_unshift($spliced, $value);
    }

    return array_merge($array, $spliced);
}

/**
 * Flattens an array.
 *
 * @param array<int|string, mixed> $array
 * @param string|array{ string, string } $separator
 *
 * @return array<int|string, mixed>
 */
function array_flatten(array $array, string|array $separator = '.', int $depth = 0): array
{
    $rc = [];

    if (is_array($separator)) {
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $rc[$key . ($depth ? $separator[1] : '')] = $value;

                continue;
            }

            $values = array_flatten($value, $separator, $depth + 1);

            foreach ($values as $sk => $sv) {
                $rc[$key . ($depth ? $separator[1] : '') . $separator[0] . $sk] = $sv;
            }
        }
    } else {
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $rc[$key] = $value;

                continue;
            }

            $values = array_flatten($value, $separator);

            foreach ($values as $sk => $sv) {
                $rc[$key . $separator . $sk] = $sv;
            }
        }
    }

    return $rc;
}

/**
 * Merge arrays recursively with a different algorithm than PHP.
 *
 * @param array<int|string, mixed> ...$arrays
 *
 * @return array<int|string, mixed>
 */
function array_merge_recursive(array ...$arrays): array
{
    if (count($arrays) < 2) {
        return reset($arrays) ?: [];
    }

    $merge = array_shift($arrays);

    foreach ($arrays as $array) {
        foreach ($array as $key => $val) {
            #
            # if the value is an array and the key already exists
            # we have to make a recursion
            #

            if (is_array($val) && array_key_exists($key, $merge)) {
                $val = array_merge_recursive((array) $merge[$key], $val);
            }

            #
            # if the key is numeric, the value is pushed. Otherwise, it replaces
            # the value of the _merge_ array.
            #

            if (is_numeric($key)) {
                $merge[] = $val;
            } else {
                $merge[$key] = $val;
            }
        }
    }

    return $merge;
}

/**
 * @param array<int|string, mixed> ...$arrays
 *
 * @return array<int|string, mixed>
 */
function exact_array_merge_recursive(array ...$arrays): array
{
    if (count($arrays) < 2) {
        return reset($arrays) ?: [];
    }

    $merge = array_shift($arrays);

    foreach ($arrays as $array) {
        foreach ($array as $key => $val) {
            #
            # if the value is an array and the key already exists
            # we have to make a recursion
            #

            if (is_array($val) && array_key_exists($key, $merge)) {
                $val = exact_array_merge_recursive((array) $merge[$key], $val);
            }

            $merge[$key] = $val;
        }
    }

    return $merge;
}

/**
 * Creates a dictionary from an iterable according to the specified key selector function
 * and optional element selector function.
 *
 * @template TSource
 * @template TElement
 *
 * @param iterable<TSource> $it
 * @param callable(TSource):(int|string) $key_selector
 * @param ?callable(TSource):TElement $element_selector
 *
 * @return ($element_selector is null ? array<int|string, TSource> : array<int|string, TElement>)
 */
function iterable_to_dictionary(iterable $it, callable $key_selector, ?callable $element_selector = null): array
{
    $ar = [];
    $element_selector ??= fn ($source) => $source;

    foreach ($it as $source) {
        /** @var TElement $element */
        $key = $key_selector($source);
        $element = $element_selector($source);
        $ar[$key] = $element;
    }

    return $ar;
}

/**
 * Groups the elements of a sequence according to the specified key selector function
 * and optionally projects the elements for each group by using a specified function.
 *
 * @template TSource
 * @template TElement
 *
 * @param iterable<TSource> $it
 * @param callable(TSource):(int|string) $key_selector
 * @param ?callable(TSource):TElement $element_selector
 *
 * @return ($element_selector is null ? array<int|string, array<TSource>> : array<int|string, array<TElement>>)
 */
function iterable_to_groups(iterable $it, callable $key_selector, ?callable $element_selector = null): array
{
    $ar = [];
    $element_selector ??= fn ($source) => $source;

    foreach ($it as $source) {
        /** @var TElement $element */
        $key = $key_selector($source);
        $element = $element_selector($source);
        $ar[$key][] = $element;
    }

    return $ar;
}

/**
 * Tests whether every value in the iterable match the predicate.
 *
 * @template T
 *
 * @param iterable<int|string, T> $it
 * @param callable(T):bool $predicate
 */
function iterable_every(iterable $it, callable $predicate): bool
{
    foreach ($it as $value) {
        if (!$predicate($value)) {
            return false;
        }
    }

    return true;
}

/**
 * Tests whether at least one element in the array matches the predicate.
 *
 * @template T
 *
 * @param iterable<int|string, T> $it
 * @param callable(T):bool $predicate
 */
function iterable_some(iterable $it, callable $predicate): bool
{
    foreach ($it as $value) {
        if ($predicate($value)) {
            return true;
        }
    }

    return false;
}
