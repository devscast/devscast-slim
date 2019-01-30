<?php
namespace App\Resources;

use App\Repositories\PodcastsRepository;
use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class PodcastsResource
 * @package App\Resources
 */
class PodcastsResource
{
    /**
     * podcasts table
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
     * [GET] all podcasts
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
     * [GET] the last podcast
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
     * [GET] a define podcast thanks to its id
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
