<?php

$routes = [];

/**
 * Defines a new route by associating a path with a callback function.
 *
 * @param string   $path     The URL path for the route.
 * @param callable $callback The function to execute when the route is accessed.
 */
function route($path, $callback)
{
    global $routes;
    $routes[$path] = $callback; 
}

/**
 * Dispatches the incoming request to the appropriate route callback.
 * If the route does not exist, a 404 error is returned.
 */
function dispatch()
{
    global $routes;

    $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (array_key_exists($requestUri, $routes)) 
    {
        $routes[$requestUri](); 
    } 
    else 
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}

// our  the index view
route('', function () {
    include 'views/index.php';
});

// Dispatch the request
dispatch();

?>
