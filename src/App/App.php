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
     * setUp the app add middlewares and register routes
     * @return App
     */
    public function setup(): self
    {
        $this->isCliServer();
        (require(ROOT . '/config/pipeline.php'))($this);
        (require(ROOT . '/config/routes/web.php'))($this);
        (require(ROOT . '/config/routes/api.php'))($this);
        $this->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', [])->add(NotFoundMiddleware::class);
        return $this;
    }

    /**
     * @param ContainerBuilder $builder
     */
    public function configureContainer(ContainerBuilder $builder)
    {
        $builder->useAutowiring(true);
        $builder->addDefinitions(ROOT . "/config/settings.php");
        $builder->addDefinitions(ROOT . "/config/settings.local.php");
        $builder->addDefinitions(ROOT . "/config/dependencies.php");
    }

    /**
     * @return bool
     */
    private function isCliServer()
    {
        if (PHP_SAPI == 'cli-server') {
            $url = parse_url($_SERVER['REQUEST_URI']);
            $file = __DIR__ . $url['path'];
            if (is_file($file)) {
                return false;
            }
        }
    }
}
