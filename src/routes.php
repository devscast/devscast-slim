<?php

use App\Resources\HomeResource;
use App\Resources\PodcastsResource;

/*$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});*/


$app->get('/home', [HomeResource::class, 'index'])->setName('home');
$app->get('/podcasts', [PodcastsResource::class, 'index'])->setName('podcasts.index');
$app->get('/podcasts/{slug}-{id}', [PodcastsResource::class, 'show'])->setName('podcasts.show');