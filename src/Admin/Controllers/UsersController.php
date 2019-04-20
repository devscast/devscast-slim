<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Controllers;

use App\Modules;
use App\Validators\UsersValidator;
use App\Repositories\UsersRepository;
use Psr\Container\ContainerInterface;

/**
 * Class UsersController
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class UsersController extends CRUDController
{

    /**
     * UsersController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(UsersRepository::class);
        $this->validator = UsersValidator::class;
        $this->module = Modules::USERS;
    }
}

