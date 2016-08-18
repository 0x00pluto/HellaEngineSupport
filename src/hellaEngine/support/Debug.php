<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/18
 * Time: 上午10:54
 */

namespace hellaEngine\support;


use utilphp\util;

/**
 * 调试类
 * Class Debug
 * @package hellaEngine\support
 */
class Debug
{


    /**
     * @param $varVal
     * @param bool $isReturn
     * @param int $lineStack
     * @param bool $richHtml
     * @param int $lineStack
     * @return string
     */
    public function dump($varVal, $isReturn = false, $richHtml = true, $lineStack = 0)
    {
        $track = debug_backtrace();
        $trackInfo = $track [$lineStack];
        $lineInfo = $trackInfo ["file"] . ":" . $trackInfo ['line'];

        $printInfo = [
            'line' => $lineInfo,
            'var' => $varVal
        ];

        if ($richHtml) {
            return util::var_dump($printInfo, $isReturn, -1);
        } else {
            return var_export($printInfo, $isReturn);
        }
    }


    /**
     * 打印调用堆栈
     * @param int $lineStack
     * @param bool|FALSE $return
     * @return array
     */
    function dumpStack($lineStack = 0, $return = FALSE)
    {
        $debug_Info = debug_backtrace();
        $stack = [];
        foreach ($debug_Info as $value) {
            if (isset($value['file'])) {
                $info = $value ['file'] . ':' . $value ['line'] . " " . $value ['function'];
                $stack[] = $info;
            }
        }
        array_shift($stack);
        if ($return) {
            return $stack;
        } else {
            $this->dump($stack, FALSE, true, $lineStack + 1);
        }
    }
}
