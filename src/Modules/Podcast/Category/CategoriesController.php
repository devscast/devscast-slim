<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Podcast\Category;

use App\AbstractController;
use App\Enumerations\ModulesEnum;
use Psr\Container\ContainerInterface;
use Modules\Podcast\PodcastsRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class CategoriesController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Category
 */
class CategoriesController extends AbstractController
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
     * @var string
     */
    private $module = ModulesEnum::CATEGORIES;

    /**
     * CategoriesController constructor.
     *
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
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $categories = $this->categories->all();
        return $this->renderer->render(
            $response,
            "@frontend/{$this->module}/index.html.twig",
            compact('categories')
        );
    }


    /**
     * Show a particular categories, thanks to an id
     *
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
                return $this->renderer->render(
                    $response,
                    "@frontend/{$this->module}/show.html.twig",
                    $data
                );
            }
            return $this->redirect('categories.show', ['id' => $category->id, 'slug' => $category->slug]);
        }
        return $response->withStatus(404);
    }
}
