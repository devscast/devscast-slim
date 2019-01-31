<?php
namespace Admin\Controllers;


use App\Repositories\UsersRepository;
use Psr\Container\ContainerInterface;

/**
 * Class UsersController
 * @package Admin\Controllers
 */
class UsersController extends DashboardController
{

    /**
     * @var UsersRepository|mixed
     */
    private $users;

    /**
     * UsersController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->users = $container->get(UsersRepository::class);
    }
}