<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/5
 * Time: 上午10:53
 */

namespace hellaEngine\support;

/**
 * Class Guid
 * @package hellaEngine\support
 */
class Guid
{
    /**
     * 生成GUID
     * @param string $prefix
     * @return string
     */
    static function uuid($prefix = '')
    {
        return $prefix . self::uuid_fromString(uniqid(mt_rand(), true));
    }

    /**
     * md5 切割GUID格式.
     * @param string $unMd5String 未被MD5加密的字符串
     * @return string
     */
    static private function uuid_fromString($unMd5String)
    {
        $chars = md5($unMd5String);
        $uuid = substr($chars, 0, 8) . '-';
        $uuid .= substr($chars, 8, 4) . '-';
        $uuid .= substr($chars, 12, 4) . '-';
        $uuid .= substr($chars, 16, 4) . '-';
        $uuid .= substr($chars, 20, 12);
        return $uuid;
    }
}