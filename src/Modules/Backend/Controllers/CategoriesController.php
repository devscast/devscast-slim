<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Backend\Controllers;

use App\Modules;
use App\Repositories\CategoriesRepository;
use App\Validators\CategoriesValidator;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesController
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Backend\Controllers
 */
class CategoriesController extends CRUDController
{

    /**
     * CategoriesController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(CategoriesRepository::class);
        $this->validator = CategoriesValidator::class;
        $this->module = Modules::CATEGORIES;
    }
}
