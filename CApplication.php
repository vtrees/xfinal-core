<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/27
 * Time: 19:42
 */

namespace core;


class CApplication
{
    public $config;
    public static $app = null;
    private $data = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function app(array $config = null)
    {
        if (self::$app == null) {
            if ($config === null && defined('APP_PATH')) {
                $config = require APP_PATH . '/config.php';
            }
            self::$app = new self($config);
        }

        return self::$app;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function run()
    {
        $this->uri = $uri = new CUri();
        $group = $uri->group;
        if ($group == '') {
            $control = 'controller\\' . strtolower($uri->control);
        } else {
            $control = $group . '\controller\\' . strtolower($uri->control);
        }

        $action = strtolower($uri->action);

        $ctrl = new $control($this, $group, $control, $action);
        if ($ctrl->beforeAction()) {
            $ctrl->$action();
        }

    }

}