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
        $ch = $this->create_curl_handle($url, $query, $method, $appendCURLOption);
        $response = trim(curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $originUrl = trim(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
        curl_close($ch);

        return HttpResponse::create($http_code, $response, $originUrl);
    }

    /**
     * 并发请求
     * @param \Closure|array $curls 通过调用 create_curl_handle生产的CURL句柄
     * @return HttpResponse []
     */
    public function httpMulti($curls)
    {

        $curls = value($curls);
        if (empty($curls)) {
            return [];
        }

        $mh = curl_multi_init();
        //加入句柄
        foreach ($curls as $curl) {
            curl_multi_add_handle($mh, $curl);
        }

        //等待完成
        do {
            curl_multi_exec($mh, $active);
        } while ($active);


        //读取资源
        $responses = [];
        foreach ($curls as $i => $curl) {

            $response = trim(curl_multi_getcontent($curl));
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            $originUrl = trim(curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));
            //获取每一个线程的执行结果
            $responses[$i] = HttpResponse::create($http_code, $response, $originUrl);
        }

        foreach ($curls as $i => $curl) {
            curl_multi_remove_handle($mh, $curl);
            curl_close($curl);
        }

        curl_multi_close($mh);

        return $responses;
    }

    /**
     * 创建 CURL 句柄
     * @param $url
     * @param string $query
     * @param string $method
     * @param array $appendCURLOption
     * @return resource
     */
    public function create_curl_handle($url, $query = "", $method = self::METHOD_GET, $appendCURLOption = [])
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
        return $ch;
    }

    /**
     * 解析GET参数
     * @param $query
     * @return string
     */
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
        if (empty($queryString)) {
            return $url;
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