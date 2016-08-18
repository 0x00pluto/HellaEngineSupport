<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/18
 * Time: 上午11:15
 */

namespace hellaEngine\support;


class DebugTest extends \PHPUnit_Framework_TestCase
{

    public function testDump()
    {
        dump("test");

        dump("test", false, false);

        dumpStack();

    }
}
