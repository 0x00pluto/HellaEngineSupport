<?php
/**
 * Created by PhpStorm.
 * User: zhipeng
 * Date: 16/9/5
 * Time: 上午10:59
 */

namespace hellaEngine\support\Reflection;

/**
 * Class Refection
 * @package hellaEngine\support\Refection
 */
class Reflection
{
    /**
     * 调用全局函数
     * @param string $method 函数名称
     * @param array $arr
     * @return mixed
     * @throws MissingArgumentException
     */
    static function callUserFuncNamedArray($method, array $arr = [])
    {
        $ref = new \ReflectionFunction($method);
        $params = [];
        foreach ($ref->getParameters() as $p) {
            if (isset ($arr [$p->name])) {
                $params [] = $arr [$p->name];
            } else if ($p->isOptional() || $p->isDefaultValueAvailable()) {
                $params [] = $p->getDefaultValue();
            } else {
                throw new MissingArgumentException ("Missing parameter $p->name");
            }
        }
        return $ref->invokeArgs($params);
    }

    /**
     * 调用
     *
     * @param string $className
     *            类名
     * @param string $functionName
     *            函数名称
     * @param array $arr
     *            参数列表 key=>value
     * @return mixed
     */
    static function callClassFuncNamedArray($className, $functionName, array $arr = [])
    {
        return self::callClassFuncNamedObjectArray($className, $functionName, new $className (), $arr);
    }

    /**
     *
     * @param string $className
     * @param string $functionName
     * @param mixed $classObject
     *            instanceof $className
     * @param array $parameters
     *            参数列表 key=>value
     * @throws MissingArgumentException
     * @return mixed
     */
    static function callClassFuncNamedObjectArray($className, $functionName, $classObject, array $parameters = [])
    {
        $ref = null;
        if ($classObject instanceof ReflectionMagic) {
            $ref = $classObject->ReflectionMethod($className, $functionName);
        }
        if (is_null($ref)) {
            $ref = new \ReflectionMethod ($className, $functionName);
        }
        $params = [];
        $finalArr = array_change_key_case($parameters, CASE_UPPER);

        foreach ($ref->getParameters() as $p) {
            $paramName = strtoupper($p->name);
            //已经传入参数了
            if (isset($finalArr[$paramName])) {
                $params [] = $finalArr [$paramName];
            } else if ($p->isOptional() || $p->isDefaultValueAvailable()) {
                $params [] = $p->getDefaultValue();
            } else {
                throw new MissingArgumentException ("Missing parameter $paramName");
            }
        }
        return call_user_func_array([$classObject, $functionName], $params);
    }
}