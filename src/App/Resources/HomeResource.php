<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Resources;

use App\Repositories\PodcastsRepository;
use App\Repositories\QuotesRepository;
use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class HomeResources
 * Data Provider for API and renderer for WebApp
 * @package App\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class HomeResource extends Resource
{

    /**
     * podcats table
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * HomeResource constructor.
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
