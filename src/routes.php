<?php

use App\Resources\HomeResource;

$app->get('/', [HomeResource::class, 'index'])->setName('home');
