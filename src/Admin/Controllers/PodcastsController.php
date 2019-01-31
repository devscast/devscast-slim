<?php
namespace Admin\Controllers;


use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;

/**
 * Class PodcastsController
 * @package Admin\Controllers
 */
class PodcastsController extends DashboardController
{
    /**
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * PodcastsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->podcasts = $container->get(PodcastsRepository::class);
    }
}