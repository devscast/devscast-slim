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

use App\Repositories\PodcastLinksRepository;
use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class PodcastsResource
 * Data Provider for API and renderer for WebApp
 * @package App\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PodcastsResource extends Resource
{
    /**
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * PodcastsResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->podcasts = $container->get(PodcastsRepository::class);
    }


    /**
     * List podcasts
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $hero = $this->podcasts->last();
        $last = $this->podcasts->latest(3);
        $podcasts = $this->podcasts->all();
        $data = compact('hero', 'last', 'podcasts');
        return $this->renderer->render($response, 'podcasts/index.html.twig', $data);
    }


    /**
     * Retrieve the last podcast
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function last(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->getAttribute('isJson')) {
            return $response->withJson(['podcast' => $this->podcasts->last()]);
        }
        return $response->withStatus(403);
    }


    /**
     * Show a podcast thanks to its id
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = intval($request->getAttribute('route')->getArgument('id'));
        $slug = strval($request->getAttribute('route')->getArgument('slug'));
        $podcast = $this->podcasts->find($id);

        if ($podcast) {
            if ($podcast->slug == $slug) {
                $last = $this->podcasts->latest(3);
                $next = $this->podcasts->next($podcast->id);
                $previous = $this->podcasts->previous($podcast->id);
                $links = $this->container->get(PodcastLinksRepository::class)->get($id);
                $data = compact('podcast', 'links', 'last', 'next', 'previous');

                return ($request->getAttribute('isJson')) ?
                    $response->withJson($data) :
                    $this->renderer->render($response, 'podcasts/show.html.twig', $data);
            }
            return $this->redirect('podcasts.show', ['slug' => $podcast->slug, 'id' => $podcast->id]);
        }
        return $response->withStatus(404);
    }
}
