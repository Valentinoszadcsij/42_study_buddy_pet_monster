<?php

class Router {
    public function dispatch($uri) {
        // Remove query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = trim($uri, '/');
        $segments = array_filter(explode('/', $uri)); //removes empty segments
        $segments = array_values($segments); //reindex after filtering

        // Default to Home controller and index action
        $controller = !empty($segments) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
        $action = $segments[1] ?? 'index';

        // Build the namespaced controller class
        $controllerClass = "\\App\\Controllers\\$controller";
        
        if (class_exists($controllerClass)) {
            $controllerObj = new $controllerClass();

            if (method_exists($controllerObj, $action)) {
                // Pass any further URI segments as params
                $params = array_slice($segments, 2);
                call_user_func_array([$controllerObj, $action], $params);
            } else {
                // action not found
                http_response_code(404);
                echo "Action not found!";
            }
        } else {
            // controller not found
            http_response_code(404);
            echo "Controller not found!";
        }
    }

    public function where_am_i($uri)
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($uri, '/'));
        if (empty($segments[0]))
            $segments[0] = 'home';
        return $segments[0];
    }
}
