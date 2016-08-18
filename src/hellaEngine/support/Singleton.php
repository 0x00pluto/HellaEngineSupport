<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/18
 * Time: 上午10:55
 */

namespace hellaEngine\support;


trait Singleton
{
    /**
     * @return static
     */
    public static function getInstance()
    {
        static $_instance = NULL;
        return $_instance ?: $_instance = new static();
    }
}