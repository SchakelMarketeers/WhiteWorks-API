<?php

namespace Schakel\WhiteWorks\Test;

use PHPUnit\Framework\TestCase;

/**
 * Report that PHPUnit is actually working.
 *
 * @author Roelof Roos
 */
class ExampleTest extends TestCase
{
    public function testTrueish()
    {
        $this->assertTrue((bool) 'true');
    }
}
