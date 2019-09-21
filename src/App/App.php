<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App;

use App\Middlewares\NotFoundMiddleware;
use DI\ContainerBuilder;

/**
 * Class App
 * @package App
 * @author bernard-ng, https://bernard-ng.github.io
 */
class App extends \DI\Bridge\Slim\App
{

    /**
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setup(): self
    {
        (require(ROOT . '/config/pipeline.php'))($this);
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

    /**
     * @param ContainerBuilder $builder
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function configureContainer(ContainerBuilder $builder)
    {
        $builder->useAutowiring(true);
        $builder->addDefinitions(ROOT . "/config/settings.php");
        $builder->addDefinitions(ROOT . "/config/settings.local.php");
        $builder->addDefinitions(ROOT . "/config/dependencies.php");
    }
}
