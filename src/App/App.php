<?php

/**
 * This file is part of DevsCast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App;

use App\Middlewares\NotFoundMiddleware;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

/**
 * Class App
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App
 */
class App extends \DI\Bridge\Slim\App
{

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadRoutingAndMiddleware();
    }

    /**
     * @param ContainerBuilder $builder
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $this->loadEnvConfig();
        $builder->useAutowiring(true);
        $builder->addDefinitions($this->loadAutoloadConfig());
    }

    /**
     * Load autoload configuration
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function loadAutoloadConfig()
    {
        $aggregator = new ConfigAggregator(
            [
                new ArrayProvider([
                    ConfigAggregator::ENABLE_CACHE => getenv("APP_ENV") === 'prod'
                ]),
                new PhpFileProvider(ROOT . "/config/autoload/*.php")
            ],
            getenv('APP_ENV') === 'dev' ? false : ROOT . "/data/cache/config.php"
        );

        return $aggregator->getMergedConfig();
    }

    /**
     * load the .env config
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function loadEnvConfig()
    {
        $env = Dotenv::create(ROOT);
        $env->load();
    }

    /**
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function loadRoutingAndMiddleware(): self
    {
        (require(ROOT . '/config/middleware.php'))($this);
        (require(ROOT . '/config/routes/app.php'))($this);
        (require(ROOT . '/config/routes/api.php'))($this);
        (require(ROOT . '/config/routes/backend.php'))($this);
        $this->map(
            ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
            '/{routes:.+}',
            []
        )->add(NotFoundMiddleware::class);
        return $this;
    }
}
