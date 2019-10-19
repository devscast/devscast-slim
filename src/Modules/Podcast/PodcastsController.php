<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Podcast;

use App\Enumerations\ModulesEnum;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\AbstractController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PodcastsController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Controllers
 */
class PodcastsController extends AbstractController
{
    /**
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * @var string
     */
    private $module = ModulesEnum::PODCASTS;

    /**
     * PodcastsController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->podcasts = $container->get(PodcastsRepository::class);
    }


    /**
     * List podcasts
     *
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
        return $this->renderer->render($response, "@frontend/{$this->module}/index.html.twig", $data);
    }

    /**
     * Show a podcast thanks to its id
     *
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
                $data = compact('podcast', 'last', 'next', 'previous');
                return $this->renderer->render($response, "@frontend/{$this->module}/show.html.twig", $data);
            }
            return $this->redirect('podcasts.show', ['slug' => $podcast->slug, 'id' => $podcast->id]);
        }
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }
}
