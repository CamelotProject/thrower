<?php

declare(strict_types=1);

/*
 * This file is part of a Camelot Project package.
 *
 * (c) The Camelot Project
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Camelot\Thrower\Tests;

use Camelot\Thrower\Thrower;
use PHPUnit\Framework\TestCase;

class ThrowerTest extends TestCase
{
    public function testSet(): void
    {
        $orig = $this->getHandler();

        Thrower::set();

        $current = $this->getHandler();

        $this->assertNotSame($orig, $current);
        restore_error_handler();

        $now = $this->getHandler();
        $this->assertSame($orig, $now);
    }

    public function testSetUsesSameHandler(): void
    {
        Thrower::set();
        Thrower::set();

        $handler1 = $this->getHandler();
        restore_error_handler();
        $handler2 = $this->getHandler();
        restore_error_handler();

        $this->assertSame($handler1, $handler2);
    }

    public function testCall(): void
    {
        $origHandler = $this->getHandler();

        $result = Thrower::call(
            function ($arg1, $arg2) {
                $this->assertSame('arg1', $arg1);
                $this->assertSame('arg2', $arg2);

                return 'blue';
            },
            'arg1',
            'arg2'
        );

        $this->assertSame('blue', $result);

        $nowHandler = $this->getHandler();
        $this->assertSame($origHandler, $nowHandler);
    }

    public function testCallWithError(): void
    {
        $origHandler = $this->getHandler();

        $e = null;
        try {
            Thrower::call(
                function (): void {
                    trigger_error('I errored', E_USER_ERROR);
                }
            );
        } catch (\ErrorException $e) {
        } catch (\Exception $e) {
        }

        $this->assertInstanceOf(\ErrorException::class, $e);
        $this->assertSame('I errored', $e->getMessage());
        $this->assertSame(E_USER_ERROR, $e->getSeverity());

        $nowHandler = $this->getHandler();
        $this->assertSame($origHandler, $nowHandler);
    }

    private function getHandler()
    {
        $handler = set_error_handler('var_dump');
        restore_error_handler();

        return $handler;
    }
}
