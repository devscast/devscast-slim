<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Controllers;

use App\Repositories\CategoriesRepository;
use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class CategoriesController
 * Data Provider for API and renderer for WebApp
 * @package App\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CategoriesController extends Controller
{

    /**
     * @var CategoriesRepository|mixed
     */
    private $categories;

    /**
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * CategoriesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->categories = $container->get(CategoriesRepository::class);
        $this->podcasts = $container->get(PodcastsRepository::class);
    }

    /**
     * listing all categories
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $categories = $this->categories->all();
        return $this->renderer->render($response, 'categories/index.html.twig', compact('categories'));
    }


    /**
     * Show a particular categories, thanks to an id
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $slug = $request->getAttribute('route')->getArgument('slug');
        $category = $this->categories->find($id);

        if ($category) {
            $podcasts = $this->podcasts->findWith('categories_id', $id);
            $data = compact('category', 'podcasts');

            if ($category->slug == $slug) {
                return $this->renderer->render($response, 'categories/show.html.twig', $data);
            }
            return $this->redirect('categories.show', ['id' => $category->id, 'slug' => $category->slug]);
        }
        return $response->withStatus(404);
    }
}
