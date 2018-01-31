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
     * function vardump(var)
     * @var \Closure|null
     */
    private static $dumper = null;

    static function setDumper($dumper = null)
    {
        self::$dumper = $dumper;
        return $dumper;
    }

    /**
     * 是否开启打印输出
     * @var bool
     */
    static $Enable = true;

    /**
     * @param $varVal
     * @param int $lineStack
     * @return string
     */
    public function dump($varVal, $lineStack = 0)
    {
        if (!static::$Enable) {
            return "";
        }

        if (is_null(self::$dumper)) {
            self::$dumper = function ($var) {
                return dump($var);
            };
        }

        $track = debug_backtrace();
        $trackInfo = $track [$lineStack];
        $lineInfo = $trackInfo ["file"] . ":" . $trackInfo ['line'];

        $printInfo = [
            'line' => $lineInfo,
            'var' => $varVal
        ];

        return (self::$dumper)($printInfo);
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
        if (!static::$Enable) {
            return [];
        }

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
        return [];
    }
}
