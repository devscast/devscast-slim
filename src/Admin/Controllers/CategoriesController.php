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

use App\Repositories\CategoriesRepository;
use App\Validators\CategoriesValidator;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesController
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CategoriesController extends CRUDController
{

    /**
     * CategoriesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(CategoriesRepository::class);
        $this->validator = CategoriesValidator::class;
        $this->module = 'categories';
    }
}
