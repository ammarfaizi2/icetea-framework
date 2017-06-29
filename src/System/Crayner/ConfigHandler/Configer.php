<?php

namespace System\Crayner\ConfigHandler;

use System\Crayner\Hub\Singleton;

class Configer
{

    /**
     * Use singleton trait.
     */
    use Singleton;

    /**
     * @var    array
     */
    protected $config;

    /**
     * Constructor.
     */
    public function __construct()
    {
        include PUBLIC_DIR . '/../config.php';
        $this->config = $config;
    }

    /**
     * @return    array
     */
    public static function database()
    {
        return self::getInstance()->config['database'];
    }

    /**
     * @param    string $assetType
     * @return    string
     */
    public static function asset($assetType)
    {
        return self::getInstance()->config['assets'][$assetType];
    }

    /**
     * @return    string
     */
    public static function routerFile()
    {
        return self::getInstance()->config['router']['router_file'];
    }

    /**
     * @return    string
     */
    public static function automaticRoute()
    {
        return self::getInstance()->config['router']['automatic_route'];
    }

    /**
     * @return  string
     */
    public static function manualRoute()
    {
        return self::getInstance()->config['router']['manual_route'];
    }

    /**
     * @return    string
     */
    public static function defaultMethod()
    {
        return self::getInstance()->config['default_method'];
    }

    /**
     * @return    string
     */
    public static function defaultRoute()
    {
        return self::getInstance()->config['default_route'];
    }

    /**
     * @return  bool
     */
    public static function errorQuery()
    {
        return self::getInstance()->config['error_handler']['show_error_query'];
    }

    public static function getCookieDefaultDomain()
    {
        return self::getInstance()->config['cookie_default_domain'];
    }

    public static function loadRoutes()
    {
        include BASEPATH . "/App/Routes/web.php";
    }

    public static function smtp()
    {
        return self::getInstance()->config['smtp'];
    }
}
