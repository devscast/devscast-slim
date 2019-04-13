<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace API\Resources;

use App\Repositories\CategoriesRepository;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesResource
 * @package API\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CategoriesResource extends Resource
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(CategoriesRepository::class);
        $this->resourceName = "categories";
    }
}