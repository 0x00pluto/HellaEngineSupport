<?php

/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/18
 * Time: 上午11:33
 */
if (!function_exists('dump_enable')) {
    /**
     * 是否开启打印输出
     * @param bool $enable
     */
    function dump_enable($enable = true)
    {
        \hellaEngine\support\Debug::$Enable = $enable;
    }
}
if (!function_exists('dumpLine')) {
    /**
     * @param $varVal
     * @param int $lineStack
     * @return string
     */

    function dumpLine($varVal, $lineStack = 0)
    {
        return (new \hellaEngine\support\Debug())->dump($varVal, $lineStack + 1);
    }
}
if (!function_exists('dumpStack')) {
    /**
     * 打印调用堆栈
     * @param mixed $varVal
     * @param int $lineStack
     * @param bool|FALSE $return
     * @return array
     */
    function dumpStack($varVal = null, $lineStack = 0, $return = FALSE)
    {
        return (new \hellaEngine\support\Debug())->dumpStack($varVal, $lineStack + 1, $return);
    }
}