<?php

namespace System;

use Closure;
use System\Crayner\Hub\Singleton;
use System\Exception\MethodNotAllowedHttpException;

/**
 * @author    Ammar Faizi    <ammarfaizi2@gmail.com>
 */

class Router
{
    /**
     * Use singleton pattern.
     */
    use Singleton;

    /**
     * Uri Segments
     *
     * @var array
     */
    private $segments;

    /**
     * Routes
     *
     * @var array
     */
    private $routes;

    /**
     *
     *
     * @param     array $segments
     * @return    self
     */
    public static function getInstance($segments = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($segments);
        }
        return self::$instance;
    }


    /**
     * Constructor.
     *
     * @param array $segments
     */
    public function __construct($segments)
    {
        $this->segments = $segments;
    }

    /**
     * Set Route.
     *
     * @param string         $route
     * @param string|Closure $action
     * @param string         $type
     */
    private function setRoute($route, $action, $type = "GET")
    {
        $this->routes[$type][$route] = $action;
    }

    /**
     *
     * @todo Run Router.
     */
    public function run()
    {
        $this->segments = rtrim(implode("/", $this->segments), "/");
        $this->segments = empty($this->segments) ? "/" : $this->segments;
        foreach ($this->routes as $key => $value) {
            foreach ($value as $route => $action) {
                if ($route === $this->segments) {
                    if ($key !== $_SERVER['REQUEST_METHOD']) {
                        throw new MethodNotAllowedHttpException("Method Not Allowed !", 1);
                        return false;
                    } else {
                        if ($action instanceof Closure) {
                            $action();
                            return false;
                        } else {
                            $action = explode("@", $action);
                            if (count($action) !== 2) {
                                throw new \Exception("Invalid route ". implode("@", $action), 1);
                            } else {
                                return array(
                                        "controller" => $action[0],
                                        "method"     => $action[1]
                                    );
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Set GET Route.
     *
     * @param string         $route
     * @param string|Closure $action
     */
    public static function get($route, $action)
    {
        self::getInstance()->setRoute($route, $action);
    }


    /**
     * Set POST Route.
     *
     * @param string         $route
     * @param string|Closure $action
     */
    public static function post($route, $action)
    {
        self::getInstance()->setRoute($route, $action, "POST");
    }
}
