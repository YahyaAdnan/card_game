<?php

$routes = [];

function route($path, $callback)
{
    global $routes;
    $routes[$path] = $callback; 
}

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

// Define your routes
route('', function () {
    include 'views/index.php';
});

route('rounds', function () {
    include 'views/rounds.php';
});


// Dispatch the request
dispatch();

?>
