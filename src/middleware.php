<?php
// Application middleware


use Slim\Http\Request;
use Slim\Http\Response;

$app->options('/{routes:.+}', function (Request $request, Response $response, array $args) {
    return $response;
});


/**
 * Whether the request is sent with XHR header
 */
$app->add(function (Request $request, Response $response, $next) {
   if ($request->isXhr()) {
       return $next($request, $response);
   } else {
       return $response->withJson(['api.message' => 'Access Forbidden'])->withStatus(403);
   }
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
