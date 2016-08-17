<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/17
 * Time: 下午4:58
 */

namespace hellaEngine\support;


class StrTest extends \PHPUnit_Framework_TestCase
{

    public function testStudly()
    {
        $studlyString = Str::studly('mynameis_bb');
        self::assertEquals('MynameisBb', $studlyString);
    }
}
