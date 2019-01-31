<?php
namespace Admin\Controllers;


use App\Repositories\CategoriesRepository;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesController
 * @package Admin\Controllers
 */
class CategoriesController extends DashboardController
{
    /**
     * @var CategoriesRepository|mixed
     */
    private $categories;

    /**
     * CategoriesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->categories = $container->get(CategoriesRepository::class);
    }
}