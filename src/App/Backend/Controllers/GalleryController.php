<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Backend\Controllers;

use App\Modules;
use App\Repositories\GalleryRepository;
use App\Validators\GalleryValidator;
use Psr\Container\ContainerInterface;

/**
 * Class GalleryController
 * administration of the gallery modules
 * @package App\Backend\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class GalleryController extends CRUDController
{

    /**
     * GalleryController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(GalleryRepository::class);
        $this->validator = GalleryValidator::class;
        $this->module = Modules::GALLERY;
    }
}
