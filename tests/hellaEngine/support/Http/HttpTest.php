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

        public function testDownload()
        {
            $httpInstance = new Http();
            $response = $httpInstance->download('http://apps.chinapay.com/cpedusetliq/mer/recon/20161020/808080301001052_20161020_20161022050027.txt',
                '1.txt');
            self::assertTrue($response->isSucc());
            unlink('1.txt');

        }


    }
