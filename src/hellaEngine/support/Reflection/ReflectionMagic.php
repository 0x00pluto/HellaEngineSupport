<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/9
 * Time: 下午2:26
 */

namespace hellaEngine\support\Reflection;

/**
 * 魔术方法反射接口
 * Interface ReflectionMagic
 * @package hellaEngine\support\Reflection
 */
interface ReflectionMagic
{
    /**
     * 反射类方法
     * @param string $className
     * @param string $functionName
     * @return \Reflection|null
     */
    public function ReflectionMethod($className, $functionName);
}