<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/5
 * Time: 上午10:54
 */

namespace hellaEngine\support;

/**
 * Class GuidTest
 * @package hellaEngine\support
 */
class GuidTest extends \PHPUnit_Framework_TestCase
{

    public function testGuid()
    {
        $guid = Guid::uuid('abc-');

        self::assertStringStartsWith('abc-', $guid);
    }
}
