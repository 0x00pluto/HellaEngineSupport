<?php

/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/8/18
 * Time: 上午11:33
 */

namespace hellaEngine\support;


/**
 * @param $varVal
 * @param bool $isReturn
 * @param int $lineStack
 * @param bool $richHtml
 * @param int $lineStack
 * @return string
 */

function dump($varVal, $isReturn = false, $richHtml = true, $lineStack = 0)
{
    return (new Debug())->dump($varVal, $isReturn, $richHtml, $lineStack + 1);
}

/**
 * 打印调用堆栈
 * @param int $lineStack
 * @param bool|FALSE $return
 * @return array
 */
function dumpStack($lineStack = 0, $return = FALSE)
{
    return (new Debug())->dumpStack($lineStack + 1, $return);
}