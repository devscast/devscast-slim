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

use App\Repositories\NewsletterRepository;
use App\Repositories\Validators\NewsletterValidator;
use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NewsletterController
 * manage the newsletter module, create and send messages
 * Crud the newsletter subscribers
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class NewsletterController extends CRUDController
{

    /**
     * NewsletterController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(NewsletterRepository::class);
        $this->validator = NewsletterValidator::class;
        $this->module = 'newsletter';
    }
}
