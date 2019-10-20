<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend;

use App\AbstractController;
use Modules\Podcast\Category\CategoriesRepository;
use Modules\Podcast\Newsletter\NewsletterRepository;
use Modules\Podcast\PodcastsRepository;
use Modules\User\UsersRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class DashboardController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Backend
 */
class DashboardController extends AbstractController
{

    /**
     * default response status code
     *
     * @var int
     */
    protected $status = StatusCode::HTTP_OK;

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $podcasts = $this->container->get(PodcastsRepository::class)->count();
        $categories = $this->container->get(CategoriesRepository::class)->count();
        $newsletter = $this->container->get(NewsletterRepository::class)->count();
        $users = $this->container->get(UsersRepository::class)->count();

        return $this->renderer->render(
            $response,
            '@backend/index.html.twig',
            compact('podcasts', 'categories', 'newsletter', 'users')
        );
    }

    /**
     * filters data sent by the user and retrieves only
     * that are valid
     *
     * @param array $params
     * @param array $fields
     * @return array
     */
    protected function filter(array $params, array $fields): array
    {
        return array_filter($params, function ($key) use ($fields) {
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY);
    }
}
