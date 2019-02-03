<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Controllers;

use App\Entities\PodcastsEntity;
use App\Repositories\CategoriesRepository;
use App\Repositories\PodcastsRepository;
use Awurth\SlimValidation\Validator;
use Core\CRUDInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class PodcastsController
 * @package Admin\Controllers
 */
class PodcastsController extends DashboardController implements CRUDInterface
{
    /**
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * PodcastsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->podcasts = $container->get(PodcastsRepository::class);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $podcasts = $this->podcasts->all();
        return $this->renderer->render($response, 'admin/podcasts/index.html.twig', compact('podcasts'));
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $validator = $this->container->get(Validator::class);
        $validator->validate($request, PodcastsEntity::getValidationRules());
        $errors = $validator->getErrors() ?? [];

        if ($validator->isValid()) {
            $this->podcasts->create($request->getParams());
            return $response->withStatus(200);
        } else {
            return ($request->getAttribute('isJson')) ?
                $response->withJson($errors)->withStatus(422) :
                $this->create($request->withAttributes(compact('errors')), $response->withStatus(422));
        }
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data['categories'] = $this->container->get(CategoriesRepository::class)->all();
        if ($request->getAttribute('validationErrors')) {
            $data['errors'] = $request->getAttribute('validationErrors');
        }
        return $this->renderer->render($response, 'admin/podcasts/create.html.twig', $data);
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');

        if ($this->podcasts->find($id)) {
            return $this->renderer->render($response, 'admin/podcasts/edit.html.twig');
        }
        return $response->withStatus(404);
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $validator = $this->container->get(Validator::class);
        $validator->validate($request, PodcastsEntity::getUpdateValidationRules());
        $errors = $validator->getErrors() ?? [];
        $id = $request->getAttribute('route')->getArgument('id');

        if ($this->podcasts->find($id)) {
            if ($validator->isValid()) {
                $this->podcasts->update($id, $request->getParams());

                return $response->withStatus(200);
            } else {
                return ($request->getAttribute('isJson')) ?
                    $response->withJson($errors)->withStatus(422) :
                    $this->create($request->withAttributes(compact('errors')), $response->withStatus(422));
            }
        }
        return $response->withStatus(404);
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');

        if ($this->podcasts->find($id)) {
            $this->podcasts->destroy($id);
            return $response->withStatus(200);
        }
        return $response->withStatus(404);
    }
}
