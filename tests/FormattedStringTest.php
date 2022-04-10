<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\ICanBoogie;

use ICanBoogie\FormattedString;
use PHPUnit\Framework\TestCase;

final class FormattedStringTest extends TestCase
{
    public function testNoArgs(): void
    {
        $s = new FormattedString('Testing... :a :b');
        $this->assertEquals('Testing... :a :b', (string) $s);
    }

    public function testArgsArray(): void
    {
        $s = new FormattedString('Testing... :a :b', [ 'a' => 'A', 'b' => 'B' ]);
        $this->assertEquals('Testing... A B', (string) $s);
    }

    public function testArgArrayAsIndex(): void
    {
        $s = new FormattedString('Testing... {0} {1}', [ 'a' => 'A', 'b' => 'B' ]);
        $this->assertEquals('Testing... A B', (string) $s);
    }

    public function testArgArrayIndex(): void
    {
        $s = new FormattedString('Testing... {0} {1}', [ 'A', 'B' ]);
        $this->assertEquals('Testing... A B', (string) $s);
    }

    public function testEscaping(): void
    {
        $s = new FormattedString('Testing... !a', [ 'a' => '<>' ]);
        $this->assertEquals('Testing... &lt;&gt;', (string) $s);
    }

    /**
     * The string shall not be formatted because we explicitly requested escaping.
     */
    public function testExplicitEscaping(): void
    {
        $s = new FormattedString('Testing... :a', [ '!a' => '<>' ]);
        $this->assertEquals('Testing... :a', (string) $s);
    }

    public function testQuoting(): void
    {
        $s = new FormattedString('Testing... %a', [ 'a' => 'A' ]);
        $this->assertEquals('Testing... `A`', (string) $s);
    }

    /**
     * The string shall not be formatted because we explicitely requested quoting.
     */
    public function testExplicitQuoting(): void
    {
        $s = new FormattedString('Testing... :a', [ '%a' => 'A' ]);
        $this->assertEquals('Testing... :a', (string) $s);
    }

    public function testQuotingEscaped(): void
    {
        $s = new FormattedString('Testing... %a', [ 'a' => 'A<>' ]);
        $this->assertEquals('Testing... `A&lt;&gt;`', (string) $s);
    }

    public function testAsIs(): void
    {
        $s = new FormattedString('Testing... :a', [ 'a' => 'A<>' ]);
        $this->assertEquals('Testing... A<>', (string) $s);
    }
}
