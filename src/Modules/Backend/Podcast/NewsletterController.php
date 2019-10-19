<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend\Podcast;

use App\Enumerations\ModulesEnum;
use App\Enumerations\PathsEnum;
use Modules\Backend\AbstractCRUDController;
use Modules\Podcast\Newsletter\NewsletterRepository;
use Modules\Podcast\Newsletter\NewsletterValidator;
use Psr\Container\ContainerInterface;

/**
 * Class NewsletterController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Backend\Controllers
 */
class NewsletterController extends AbstractCRUDController
{

    /**
     * NewsletterController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(NewsletterRepository::class);
        $this->validator = NewsletterValidator::class;
        $this->module = ModulesEnum::NEWSLETTER;
        $this->path = PathsEnum::NEWSLETTER;
    }
}
