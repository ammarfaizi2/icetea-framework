<?php

namespace System\Crayner\URLManagement;

/**
 * @author    Ammar Faizi    <ammarfaizi2@gmail.com>
 */

class UriSegment
{
    /**
     *   @param  string $router
     *   @return array
     */
    public static function getSegments($router='index.php')
    {
        if (!empty($router) && strpos($_SERVER['REQUEST_URI'], $router)!==false) {
            $from = explode($router, $_SERVER['REQUEST_URI']);
            $from = $from[1];
        } else {
            $from = $_SERVER['REQUEST_URI'];
        }
        $from = explode("/", $from);
        foreach ($from as $key => $value) {
            if (empty($value)) {
                unset($from[$key]);
                $is = 1;
            }
        }
        if (isset($is)) {
            $fr = array();
            foreach ($from as $value) {
                $fr[] = $value;
            }
            $from = $fr;
        }
        return $from;
    }

    /**
     *   @param  int   $n
     *   @param  array $segs
     *   @return string
     */
    public static function getSegment($n, $segs)
    {
        $c = count($segs);
        return isset($segs[$n]) && !empty($segs[$n]) ?$segs[$n]: '';
    }
}
