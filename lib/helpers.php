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

use Exception;
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
use function bin2hex;
use function chr;
use function count;
use function function_exists;
use function htmlentities;
use function htmlspecialchars;
use function is_array;
use function is_bool;
use function is_null;
use function is_numeric;
use function is_object;
use function is_scalar;
use function is_string;
use function max;
use function mb_strlen;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;
use function method_exists;
use function min;
use function ob_get_clean;
use function ob_start;
use function ord;
use function preg_match;
use function preg_replace;
use function print_r;
use function random_bytes;
use function reset;
use function rtrim;
use function str_replace;
use function str_split;
use function str_starts_with;
use function strcasecmp;
use function strcmp;
use function strtolower;
use function substr;
use function trim;
use function vsprintf;
use function xdebug_var_dump;

use const ENT_COMPAT;
use const ENT_NOQUOTES;
use const PHP_SAPI;

/**
 * Escape HTML special characters.
 *
 * HTML special characters are escaped using the {@link htmlspecialchars()} function with the
 * {@link ENT_COMPAT} flag.
 */
function escape(string $str, string $encoding = null): string
{
    return htmlspecialchars($str, ENT_COMPAT, $encoding);
}

/**
 * Escape all applicable characters to HTML entities.
 *
 * Applicable characters are escaped using the {@link htmlentities()} function with the {@link ENT_COMPAT} flag.
 */
function escape_all(string $str, string $encoding = null): string
{
    return htmlentities($str, ENT_COMPAT, $encoding);
}

// Avoid conflicts with ICanBoogie/Inflector
if (!function_exists(__NAMESPACE__ . '\downcase')) {
    /**
     * Returns a lowercase string.
     */
    function downcase(string $str): string
    {
        return mb_strtolower($str);
    }
}

// Avoid conflicts with ICanBoogie/Inflector
if (!function_exists(__NAMESPACE__ . '\upcase')) {
    /**
     * Returns an uppercase string.
     */
    function upcase(string $str): string
    {
        return mb_strtoupper($str);
    }
}

// Avoid conflicts with ICanBoogie/Inflector
if (!function_exists(__NAMESPACE__ . '\capitalize')) {
    /**
     * Returns a copy of str with the first character converted to uppercase and the
     * remainder to lowercase.
     *
     * @param bool $preserve_str_end Whether the string end should be preserved or downcased.
     */
    function capitalize(string $str, bool $preserve_str_end = false): string
    {
        $end = mb_substr($str, 1);

        if (!$preserve_str_end) {
            $end = downcase($end);
        }

        return upcase(mb_substr($str, 0, 1)) . $end;
    }
}

/**
 * Shortens a string at a specified position.
 *
 * @param string $str The string to shorten.
 * @param int $length The desired length of the string.
 * @param float $position Position at which characters can be removed.
 * @param bool $shortened `true` if the string was shortened, `false` otherwise.
 */
function shorten(string $str, int $length = 32, float $position = .75, bool &$shortened = null): string
{
    $l = mb_strlen($str);

    if ($l <= $length) {
        return $str;
    }

    $length--;
    $position = (int) ($position * $length);

    if ($position == 0) {
        $str = '…' . mb_substr($str, $l - $length);
    } else {
        if ($position == $length) {
            $str = mb_substr($str, 0, $length) . '…';
        } else {
            $str = mb_substr($str, 0, $position) . '…' . mb_substr($str, $l - ($length - $position));
        }
    }

    $shortened = true;

    return $str;
}

/**
 * Removes the accents of a string.
 */
function remove_accents(string $str, string $encoding = null): string
{
    $str = htmlentities($str, ENT_NOQUOTES, $encoding);
    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    // @phpstan-ignore-next-line
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // ligatures e.g. '&oelig;'

    // @phpstan-ignore-next-line
    return preg_replace('#&[^;]+;#', '', $str); // remove other escaped characters
}

/**
 * Binary-safe case-sensitive accents-insensitive string comparison.
 *
 * Accents are removed using the {@link remove_accents()} function.
 */
function unaccent_compare(string $a, string $b): int
{
    return strcmp(remove_accents($a), remove_accents($b));
}

/**
 * Binary-safe case-insensitive accents-insensitive string comparison.
 *
 * Accents are removed using the {@link remove_accents()} function.
 */
function unaccent_compare_ci(string $a, string $b): int
{
    return strcasecmp(remove_accents($a), remove_accents($b));
}

/**
 * Normalizes a string.
 *
 * Accents are removed, the string is downcased and characters that don't match [a-z0-9] are
 * replaced by the separator character.
 *
 * @param string $str The string to normalize.
 * @param string $separator The separator characters replaces characters the don't match [a-z0-9].
 */
function normalize(string $str, string $separator = '-', string $encoding = null): string
{
    static $cache;

    $cache_key = $encoding . '|' . $separator . '|' . $str;

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $str = str_replace('\'', '', $str);
    $str = remove_accents($str, $encoding);
    $str = strtolower($str);
    $str = preg_replace('#[^a-z0-9]+#', $separator, $str) ?? "";
    $str = trim($str, $separator);

    return $cache[$cache_key] = $str;
}

/**
 * Returns information about a variable.
 *
 * The function uses xdebug_var_dump() if [Xdebug](http://xdebug.org/) is installed, otherwise it
 * uses print_r() output wrapped in a PRE element.
 */
function dump(mixed $value): string
{
    if (function_exists('xdebug_var_dump')) {
        ob_start();

        xdebug_var_dump($value);

        $value = (string) ob_get_clean();
    } else {
        $value = '<pre>' . escape(print_r($value, true)) . '</pre>';
    }

    return $value;
}

/**
 * Formats the given string by replacing placeholders with the values provided.
 *
 * @param string $str The string to format.
 * @param array<int|string, mixed> $args An array of replacements for the placeholders. Occurrences in $str of any
 * key in $args are replaced with the corresponding sanitized value. The sanitization function
 * depends on the first character of the key:
 *
 * * :key: Replace as is. Use this for text that has already been sanitized.
 * * !key or {key}: Sanitize using the `ICanBoogie\escape()` function.
 * * %key: Sanitize using the `ICanBoogie\escape()` function and wrap inside a "EM" markup.
 *
 * Numeric indexes can also be used e.g "\\2" or "{2}" are replaced by the value of the index
 * "2".
 */
function format(string $str, array $args = []): string
{
    static $quotation_start;
    static $quotation_end;

    if ($quotation_start === null) {
        if (PHP_SAPI == 'cli') {
            $quotation_start = '`';
            $quotation_end = '`';
        } else {
            $quotation_start = '<q>';
            $quotation_end = '</q>';
        }
    }

    if (!$args) {
        return $str;
    }

    $holders = [];
    $i = 0;

    foreach ($args as $key => $value) {
        if (is_object($value) && method_exists($value, '__toString')) {
            $value = (string) $value;
        }

        if (is_array($value) || is_object($value)) {
            $value = dump($value);
        } else {
            if (is_bool($value)) {
                $value = $value ? '`true`' : '`false`';
            } elseif (is_null($value)) {
                $value = '`null`';
            }
        }

        if (is_string($key)) {
            switch ($key[0]) {
                case ':':
                    break;

                case '!':
                    $value = escape($value);
                    break;

                case '%':
                    $value = $quotation_start . escape($value) . $quotation_end;
                    break;

                default:
                    $escaped_value = escape($value);

                    $holders['{' . $key . '}'] = $escaped_value;
                    $holders['!' . $key] = $escaped_value;
                    $holders['%' . $key] = $quotation_start . $escaped_value . $quotation_end;

                    $key = ':' . $key;
            }
        }

        $holders[$key] = $value;
        $holders['\\' . $i] = $value;
        $holders['{' . $i . '}'] = $value;

        $i++;
    }

    return strtr($str, $holders);
}

/**
 * Sorts an array using a stable sorting algorithm while preserving its keys.
 *
 * A stable sorting algorithm maintains the relative order of values with equal keys.
 *
 * The array is always sorted in ascending order but one can use the array_reverse() function to
 * reverse the array. Also keys are preserved, even numeric ones, use the array_values() function
 * to create an array with an ascending index.
 *
 * @param array<int|string, mixed> $array
 */
function stable_sort(array &$array, callable $picker = null): void
{
    static $transform, $restore;

    $i = 0;

    if (!$transform) {
        $transform = function (&$v, $k) use (&$i) {
            $v = [ $v, ++$i, $k, $v ];
        };

        $restore = function (&$v) {
            $v = $v[3];
        };
    }

    if ($picker) {
        array_walk($array, function (&$v, $k) use (&$i, $picker) {
            $v = [ $picker($v, $k), ++$i, $k, $v ];
        });
    } else {
        array_walk($array, $transform);
    }

    asort($array);

    array_walk($array, $restore);
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

    $numeric_order = array_filter($order, function ($weight) {
        return is_scalar($weight) && is_numeric($weight);
    });

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

    stable_sort($order);

    array_walk($order, function (&$v, $k) use ($array) {
        $v = $array[$k];
    });

    return $order;
}

/**
 * Inserts a value in a array before, or after, a given key.
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
 * @param string|array{0: string, 1: string} $separator
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
 * Normalizes the path of a URL.
 *
 * @see http://en.wikipedia.org/wiki/URL_normalization
 */
function normalize_url_path(string $path): string
{
    static $cache = [];

    if (isset($cache[$path])) {
        return $cache[$path];
    }

    $normalized = preg_replace('#/index\.(html|php)$#', '/', $path) ?? "";
    $normalized = rtrim($normalized, '/');

    if (!preg_match('#\.[a-z]+$#', $normalized)) {
        $normalized .= '/';
    }

    $cache[$path] = $normalized;

    return $normalized;
}

/**
 * Generates a v4 UUID.
 *
 * @origin http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid#answer-15875555
 *
 * @throws Exception when random bytes cannot be generated.
 */
function generate_v4_uuid(): string
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
