<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use App\Middlewares\NotFoundMiddleware;

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/config/constants.php');

$app = new class() extends DI\Bridge\Slim\App {
    public function configure()
    {
        if (PHP_SAPI == 'cli-server') {
            $url  = parse_url($_SERVER['REQUEST_URI']);
            $file = __DIR__ . $url['path'];
            if (is_file($file)) {
                return false;
            }
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_name('devscast_ssid');
            session_start();
        }

        (require(ROOT . '/config/pipeline.php'))($this);
        (require(ROOT . '/config/routes/web.php'))($this);
        (require(ROOT . '/config/routes/api.php'))($this);
        $this->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', [])->add(NotFoundMiddleware::class);
    }

    public function configureContainer(\DI\ContainerBuilder $builder)
    {
        $builder->useAutowiring(true);
        $builder->addDefinitions(ROOT . "/config/settings.php");
        $builder->addDefinitions(ROOT . "/config/settings.local.php");
        $builder->addDefinitions(ROOT . "/config/dependencies.php");
    }
};

$app->configure();
$app->run();
