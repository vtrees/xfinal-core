<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/27
 * Time: 19:32
 */

namespace core;


class CController
{
    protected $view_;
    protected $group_;
    protected $control_;
    protected $action_;
    protected $layout = "main";
    protected $app = null;

    public function beforeAction()
    {
        return true;
    }

    public function __construct(&$app ,$group, $control, $action)
    {
        $this->app = $app;
        $this->control_ = $control;
        $this->action_ = $action;
        $this->view_ = new CView($this);
        $this->group_ = $group;
    }

    public function __call($name, $arguments)
    {
        $method = "action" . $name;
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo 'page not found!';
        }
    }

    protected function display($tpl = "")
    {
        $tplname = ($tpl == "") ? $this->action_ : $tpl;
        $classname = substr($this->control_, strrpos($this->control_, '\\') + 1);
        $this->view_->display($this->group_, $tplname, $classname, $this->layout);
    }

    public function __get($val)
    {
        return $this->app->$val;
    }
}