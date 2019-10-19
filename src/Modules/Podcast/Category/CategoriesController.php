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
use App\Enumerations\PathsEnum;
use Psr\Container\ContainerInterface;
use Modules\Podcast\PodcastsRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class CategoriesController
 * @property mixed|CategoriesRepository categoriesRepository
 * @property mixed|PodcastsRepository podcastsRepository
 * @package Modules\Podcast\Category
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class CategoriesController extends AbstractController
{

    /** @var string */
    private $module = ModulesEnum::CATEGORIES;

    /** @var string  */
    private $path = PathsEnum::CATEGORIES;

    /**
     * CategoriesController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->categoriesRepository = $container->get(CategoriesRepository::class);
        $this->podcastsRepository = $container->get(PodcastsRepository::class);
    }

    /**
     * listing all categories
     * @todo paginate Query
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $categories = $this->categoriesRepository->all();
        return $this->renderer->render(
            $response,
            "@frontend/{$this->path}/index.html.twig",
            compact('categories')
        );
    }

    /**
     * Show a particular categories, thanks to an id
     * @todo paginate Query
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = intval($request->getAttribute('route')->getArgument('id'));
        $slug = strval($request->getAttribute('route')->getArgument('slug'));
        $category = $this->categoriesRepository->find($id);

        if ($category) {
            $podcasts = $this->podcastsRepository->findWith('categories_id', $id);
            $data = compact('category', 'podcasts');

            if ($category->slug == $slug) {
                return $this->renderer->render(
                    $response,
                    "@frontend/{$this->path}/show.html.twig",
                    $data
                );
            }
            return $this->redirect('categories.show', ['id' => $category->id, 'slug' => $category->slug]);
        }
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }
}
