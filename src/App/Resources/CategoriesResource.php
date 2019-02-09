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

use App\Repositories\CategoriesRepository;
use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class CategoriesResource
 * Data Provider for API and renderer for WebApp
 * @package App\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CategoriesResource
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
     * CategoriesResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
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
        return $response->withJson([
            'api.message' => 'listing all categories',
            'categoires' => $this->categories->all()
        ]);
    }


    /**
     * show a particular categories, thanks to an id
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = intval($request->getAttribute('route')->getArgument('id'));
        $category = $this->categories->find($id);

        if ($category) {
            return $response->withJson([
                'api.message' => 'showing a category',
                'category' => $category,
                'podcasts' => $this->podcasts->findWith('categories_id', $id)
            ]);
        }
        return $response->withJson(['api.error' => "Page Not found"])->withStatus(404);
    }
}
