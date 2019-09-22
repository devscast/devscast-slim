<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Modules\Page;

use App\Modules\AbstractController;
use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class HomeController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Modules\Page
 */
class HomeController extends AbstractController
{

    /**
     * podcasts table
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * HomeController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->podcasts = $container->get(PodcastsRepository::class);
    }

    /**
     * Homepage
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $hero = $this->podcasts->last();
        $podcasts = $this->podcasts->latest(3);
        return $this->renderer->render($response, 'index.html.twig', compact('podcasts', 'hero'));
    }
}
