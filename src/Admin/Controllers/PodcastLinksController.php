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
use App\Repositories\PodcastLinksRepository;
use App\Validators\PodcastLinksValidator;
use Psr\Container\ContainerInterface;

/**
 * Class PodcastLinksController
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PodcastLinksController extends CRUDController
{

    /**
     * PodcastLinksController constructor.
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
