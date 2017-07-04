<?php

namespace System;

use Closure;
use System\Crayner\Hub\Singleton;
use System\Exception\MethodNotAllowedHttpException;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 */

class Router
{
    use Singleton;

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var string
     */
    private $uri;

    /**
     * Constructor.
     * @param array
     */
    public function __construct($uri)
    {
        $this->uri = implode("/",$uri);
        $this->uri = substr($this->uri, 0, 1) != "/" ? "/".$this->uri : $this->uri;
    }

    /**
     * @param string|array          $route
     * @param string|array|\Closure $action
     * @param string                $type
     */
    private function addRoute($route, $action, $type)
    {
        if (is_array($route)) {
            foreach ($route as $val) {
                $this->routes[$val][$type] = $action;
            }
        } else {
            $this->routes[$route][$type] = $action;
        }
    }

    /**
     * @param string                $route
     * @param string|array|\Closure $action
     */
    public static function get($route, $action)
    {
        $self = self::getInstance();
        $self->addRoute($route, $action, "GET");
    }

    /**
     * @param string                $route
     * @param string|array|\Closure $action
     */
    public static function post($route, $action)
    {
        $self = self::getInstance();
        $self->addRoute($route, $action, "POST");
    }

    /**
     * @throws \System\Exception\MethodNotAllowedHttpException
     * @return mixed
     */
    public function run()
    {
        foreach ($this->routes as $key => $val) {
            $key = substr($key, 0, 1) != "/" ? "/".$key : $key;
            if ($this->uri == $key) {
                if (isset($this->routes[$key][$_SERVER['REQUEST_METHOD']])) {
                    $val = $this->routes[$key][$_SERVER['REQUEST_METHOD']];
                    if ($val instanceof Closure) {
                        $val(); die;
                    } elseif (is_string($val)) {
                        $val = explode("@", $val);
                        if (count($val) != 2) {
                            throw new \Exception("Invalid Route \"".implode("@", $val)."\"", 1);
                        } else {
                            return array(
                                    "controller" => $val[0],
                                    "method"     => $val[1]
                                );
                        }
                    }
                } else {
                    throw new MethodNotAllowedHttpException("Method not allowed!", 1);
                    return false;
                }
            }
        }
        return false;
    }

    /**
     * @param array
     * @return System\Router
     */
    public static function getInstance($uri = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($uri);
        }
        return self::$instance;
    }
}
