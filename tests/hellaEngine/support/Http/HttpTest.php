<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/8
 * Time: 上午9:32
 */

namespace hellaEngine\support\Http;


class HttpTest extends \PHPUnit_Framework_TestCase
{

    public function testHttp()
    {
        $httpInstance = new Http();
        $response = $httpInstance->http("www.baidu.com", Http::METHOD_GET);

        self::assertTrue($response->isSucc());

    }
}
