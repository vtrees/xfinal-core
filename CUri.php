<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/27
 * Time: 20:59
 */

namespace core;


class CUri
{
    protected $group = '';
    protected $control = 'index';
    protected $action = 'index';
    protected $itemid = 0;

    public function __construct()
    {
        $this->_parse();
    }

    public function __get($val)
    {
        return $this->$val;
    }

    private function _parse()
    {
        $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url_path = trim($url_path, '/');
        $url_path_segment = explode('/', $url_path);

        $len = count($url_path_segment);
        if (is_numeric($url_path_segment[$len - 1])) {
            $this->itemid = $url_path_segment[$len - 1];
            array_pop($url_path_segment);
            $len = $len - 1;
        }

        if ($len >= 3) {
            $this->group = $url_path_segment[0];
            $this->control = $url_path_segment[1];
            $this->action = $url_path_segment[2];
        } else if ($len == 2) {
            $this->control = $url_path_segment[0];
            $this->action = $url_path_segment[1];
        } else if ($len == 1) {
            $this->control = $url_path_segment[0];
        }
    }

}