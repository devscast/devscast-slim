<?php
namespace Admin\Controllers;


use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;

/**
 * Class DashboardController
 * @package Admin\Controllers
 */
class DashboardController
{
    /**
     * @var Renderer|mixed
     */
    protected $renderer;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * DashboardController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $container->get(Renderer::class);
    }
}
