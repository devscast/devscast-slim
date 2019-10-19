<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend\User;

use App\Enumerations\ModulesEnum;
use App\Enumerations\PathsEnum;
use Modules\User\UsersValidator;
use Modules\User\UsersRepository;
use Psr\Container\ContainerInterface;
use Modules\Backend\AbstractCRUDController;

/**
 * Class UsersController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Backend\User
 */
class UsersController extends AbstractCRUDController
{

    /**
     * UsersController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(UsersRepository::class);
        $this->validator = UsersValidator::class;
        $this->module = ModulesEnum::USERS;
        $this->path = PathsEnum::USERS;
    }
}
