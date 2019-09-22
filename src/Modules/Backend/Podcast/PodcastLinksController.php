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
use Psr\Container\ContainerInterface;
use Modules\Backend\AbstractCRUDController;
use Modules\Podcast\Link\PodcastLinksRepository;
use Modules\Podcast\Link\PodcastLinksValidator;

/**
 * Class PodcastLinksController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Backend\Podcast
 */
class PodcastLinksController extends AbstractCRUDController
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
        $this->path = Paths::PODCASTLINKS;
    }
}
