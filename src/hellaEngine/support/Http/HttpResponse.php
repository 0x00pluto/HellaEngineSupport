<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/8
 * Time: 上午9:26
 */

namespace hellaEngine\support\Http;

/**
 * http请求返回
 * Class HttpResponse
 * @package hellaEngine\support\Http
 */
class HttpResponse
{
    const HTTP_CODE_OK = 200;

    /**
     * @var string $response
     */
    private $response;

    /**
     * @var int $httpCode
     */
    private $httpCode;


    /**
     * @param int $httpCode
     * @param int $response
     * @return HttpResponse
     */
    public static function create($httpCode, $response)
    {
        $ins = new self();
        $ins->httpCode = $httpCode;
        $ins->response = $response;

        return $ins;
    }

    /**
     * 是否成功
     * @return bool
     */
    public function isSucc()
    {
        return $this->httpCode == self::HTTP_CODE_OK;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }


}