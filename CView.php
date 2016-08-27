<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/27
 * Time: 19:41
 */

namespace core;


class CView
{
    private $parm = array();
    private $control;

    public function __construct(&$control)
    {
        $this->control = $control;
    }

    public function assign($name, $value)
    {
        if (is_array($name)) {
            foreach ($name as $key => $val) {
                $this->parm[$key] = $val;
            }
        } else {
            $this->parm[$name] = $value;
        }
    }

    public function __get($var)
    {
        return $this->control->$var;
    }

    public function display($group_, $tpl_, $classname_, $lay_)
    {
        $group_ = str_replace('\\', '/', $group_);
        $tplPath_ = $group_ == '' ? APP_PATH . "/view/" : APP_PATH . '/' . $group_ . "/view/";

        ob_start();
        extract($this->parm, EXTR_OVERWRITE);

        ///加载模版文件
        if (is_file($tplPath_ . "$classname_/$tpl_.php")) {
            include $tplPath_ . "$classname_/$tpl_.php";
        }
        $buffer = ob_get_contents();
        ob_end_clean();

        //加载布局文件
        if ($lay_ != "" && is_file($tplPath_ . "layout/$lay_.php")) {
            include $tplPath_ . "layout/$lay_.php";
        } else {
            echo $buffer;
        }

    }
}