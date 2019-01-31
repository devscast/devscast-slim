<?php
// Application middleware


use Slim\Http\Request;
use Slim\Http\Response;

$app->options('/{routes:.+}', function (Request $request, Response $response, array $args) {
    return $response;
});


/**
 * Check if the request is a json one
 */
$app->add(function (Request $request, Response $response, $next) {
    if ($request->getHeader('CONTENT_TYPE') != 'application/json') {
        if ($request->hasHeader('authorization')) {
            $request->withAttribute('IsJson', true);
        }
    }
    return $next($request, $response);
});


/**
 * Enable CORS for the frontend app
 */
$app->add(function (Request $request, Response $response, $next) {
    $response = $next($request, $response);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->withHeader('X-Powered-By', 'Devcast Team');
});
