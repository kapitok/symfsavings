<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 * @package App\Tests\Account
 */
class BaseTest extends TestCase
{
    public function testCase()
    {
        $this->assertEquals(true, 1 === 1);
    }

}
