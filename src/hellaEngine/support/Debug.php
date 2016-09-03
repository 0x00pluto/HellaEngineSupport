<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/18
 * Time: 上午10:54
 */

namespace hellaEngine\support;


/**
 * 调试类
 * Class Debug
 * @package hellaEngine\support
 */
class Debug
{


    /**
     * @param $varVal
     * @param int $lineStack
     * @param int $lineStack
     * @return string
     */
    public function dump($varVal, $lineStack = 0)
    {
        $track = debug_backtrace();
        $trackInfo = $track [$lineStack];
        $lineInfo = $trackInfo ["file"] . ":" . $trackInfo ['line'];

        $printInfo = [
            'line' => $lineInfo,
            'var' => $varVal
        ];

        return dump($printInfo);
    }


    /**
     * 打印调用堆栈
     * @param mixed $varVal
     * @param int $lineStack
     * @param bool|FALSE $return
     * @return array
     */
    function dumpStack($varVal, $lineStack = 0, $return = FALSE)
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

        $returnVar = [
            'var' => $varVal,
            'stack' => $stack
        ];
        if ($return) {
            return $returnVar;
        } else {
            $this->dump($returnVar, $lineStack + 1);
        }
    }
}
