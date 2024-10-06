<?php

class Route{
    private static $uriList = array();
    private static $uriCallback = array();

    static public function add($uri, $function)
    {
        self::$uriList[] = $uri;
        self::$uriCallback[$uri] = $function;
    }

    static public function submit()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $doesUriMatch = false;

        foreach (self::$uriList as $u) {
            if (strpos($uri, $u) === 0) {
                $doesUriMatch = true;
                break;
            }
        }

        if ($doesUriMatch && isset(self::$uriCallback[$uri])) {
            call_user_func(self::$uriCallback[$uri]);
        } else {
            http_response_code(404);
            require __DIR__ . '/commerce_2/views/404.php';
            exit;
        }
    }
}
