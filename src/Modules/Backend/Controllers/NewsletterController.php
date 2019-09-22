<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Backend\Controllers;

use App\Modules;
use App\Repositories\NewsletterRepository;
use App\Validators\NewsletterValidator;
use Psr\Container\ContainerInterface;

/**
 * Class NewsletterController
 * manage the newsletter module, create and send messages
 * Crud the newsletter subscribers
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Backend\Controllers
 */
class NewsletterController extends CRUDController
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
        $this->module = Modules::NEWSLETTER;
    }
}
