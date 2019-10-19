<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend\Podcast;

use App\Modules;
use App\Paths;
use Modules\Backend\AbstractCRUDController;
use Modules\Podcast\Category\CategoriesRepository;
use Modules\Podcast\Category\CategoriesValidator;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Backend\Podcast
 */
class CategoriesController extends AbstractCRUDController
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
        $this->module = ModulesEnum::CATEGORIES;
        $this->path = PathsEnum::CATEGORIES;
    }
}
