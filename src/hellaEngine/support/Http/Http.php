<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/8
 * Time: 上午9:22
 */

namespace hellaEngine\support\Http;

/**
 * http请求
 * Class Http
 * @package hellaEngine\support\Http
 */
class Http
{
    /**
     *
     */
    const METHOD_GET = "GET";
    /**
     *
     */
    const METHOD_POST = "POST";

    /**
     * @param $url
     * @param string $query
     * @param string $method
     * @param array $appendCURLOption 追加的curl参数,key=>value
     * @return HttpResponse
     */
    function http($url, $query = "", $method = self::METHOD_GET, $appendCURLOption = [])
    {
        $ch = curl_init();
        switch (strtoupper($method)) {
            case self::METHOD_GET :
                $url = $this->parseURL($url, $query);
                break;
            case self::METHOD_POST :
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                break;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        foreach ($appendCURLOption as $key => $value) {
            curl_setopt($ch, $key, $value);
        }

        $response = trim(curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return HttpResponse::create($http_code, $response, $url);
    }

    public function parseQueryArray($query)
    {
        if (is_array($query)) {
            $queryStringArray = [];
            foreach ($query as $key => $value) {
                $value = urlencode($value);
                $queryStringArray [] = "$key=$value";
            }
            $queryString = join("&", $queryStringArray);
        } else {
            $queryString = $query;
        }
        return $queryString;
    }

    /**
     * 解析URL
     * @param $url
     * @param array|string $query
     * @return string
     */
    function parseURL($url, $query)
    {
        if (is_string($query)) {
            $queryString = $query;
        } else {
            $queryString = $this->parseQueryArray($query);
        }
        if (false === stripos($url, '?')) {
            $url .= '?' . $queryString;
        } else {
            $url .= '&' . $queryString;
        }

        return $url;
    }

    /**
     * 下载文件
     * @param $url
     * @param $savePath
     * @return bool|HttpResponse
     */
    public function download($url, $savePath)
    {

        $fp = fopen($savePath, 'w');

        if ($fp === false) {
            return false;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);

        $response = trim(curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);

        return HttpResponse::create($http_code, $response, $url);

    }
}