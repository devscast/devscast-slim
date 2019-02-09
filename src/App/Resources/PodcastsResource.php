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
use Core\Renderer\Renderer;
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
class PodcastsResource
{
    /**
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * @var Renderer|mixed
     */
    private $renderer;

    /**
     * PodcastsResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->podcasts = $container->get(PodcastsRepository::class);
        $this->renderer = $container->get(Renderer::class);
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

        if ($request->getAttribute('isJson')) {
            return $response->withJson([
                'api.action' => 'listing all podcasts',
                'podcasts' => $podcasts,
                'hero' => $hero,
                'last' => $last
            ]);
        } else {
            return $this->renderer->render($response, 'podcasts/index.html.twig', compact('hero', 'last', 'podcasts'));
        }
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
            return $response->withJson([
                'api.action' => 'fetch the last podcast',
                'podcast' => $this->podcasts->last()
            ]);
        }
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
        $last = $this->podcasts->latest(3);
        $podcast = $this->podcasts->find($id);

        if ($podcast && $podcast->slug == $slug) {
            $next = $this->podcasts->next($podcast->id);
            $previous = $this->podcasts->previous($podcast->id);

            if ($request->getAttribute('isJson')) {
                return $response->withJson([
                    'api.action' => 'show a single podcast',
                    'podcast' => $podcast,
                    'next' => $next,
                    'previous' => $previous,
                    'last' => $last
                ]);
            } else {
                return $this->renderer->render(
                    $response,
                    'podcasts/show.html.twig',
                    compact('podcast', 'last', 'next', 'previous')
                );
            }
        } else {
            return $response->withStatus(404);
        }
    }
}
