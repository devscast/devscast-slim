<?php

use App\Resources\HomeResource;

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->get('/', [HomeResource::class, 'index'])->setName('home');

