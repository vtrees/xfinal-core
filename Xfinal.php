<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/27
 * Time: 19:43
 */

namespace core;


class Xfinal
{
    public static function app(array $config = null)
    {
        return CApplication::app($config);
    }

    /**
     * 应用根目录
     * /admin/test.php?a=test  对应/
     * /index.php?c=admin 对应/
     *
     * @return string
     */
    public static function baseUrl()
    {
        return substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
    }

    /**
     * 当前入口路径
     * /admin/test.php?a=test  对应/admin/test.php
     * /test.php?a=test 对应/test.php
     *
     * @return string
     */
    public static function entry()
    {
        if (strpos($_SERVER['REQUEST_URI'], '?') > 0) {
            return substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "?"));
        } else {
            return $_SERVER['REQUEST_URI'];
        }
    }
}