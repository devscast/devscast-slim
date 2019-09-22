<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Backend\Controllers;

use App\Modules;
use App\Repositories\PodcastLinksRepository;
use App\Validators\PodcastLinksValidator;
use Psr\Container\ContainerInterface;

/**
 * Class PodcastLinksController
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Backend\Controllers
 */
class PodcastLinksController extends CRUDController
{

    /**
     * PodcastLinksController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(PodcastLinksRepository::class);
        $this->validator = PodcastLinksValidator::class;
        $this->module = Modules::PODCASTLINKS;
    }
}
