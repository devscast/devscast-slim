<?php
use DI\Bridge\Slim\App;

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_name('devcast_api');
    session_start();
}

require(dirname(__DIR__) . '/vendor/autoload.php');

/** @var $app DI\Bridge\Slim\App */
$app = new class() extends App {
    public function configureContainer(\DI\ContainerBuilder $builder)
    {
        $builder->useAutowiring(true);
        $builder->addDefinitions(dirname(__DIR__) . "/src/settings.php");
        $builder->addDefinitions(dirname(__DIR__) . "/src/dependencies.php");
    }
};

require(dirname(__DIR__) . '/src/middleware.php');
require(dirname(__DIR__) . '/src/routes.php');
$app->run();
