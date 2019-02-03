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
     * @TODO paginate podcasts query
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
     * creates and stores a podcast
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isPost()) {
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, PodcastsEntity::getValidationRules());
            $input = $request->getParams();
            $errors = $validator->getErrors();
            $params = $this->filter($input, PodcastsEntity::getStoreAbleFields());

            if ($validator->isValid()) {
                $this->podcasts->create($params);
                $this->flash->success('podcast.create');
                return $this->redirect('admin.podcasts');
            } else {
                $this->flash->error('podcast.create');
                $this->status = 422;
            }
        }

        $data = compact('errors', 'input');
        $data['categories'] = $this->container->get(CategoriesRepository::class)->all();
        return $this->renderer->render($response->withStatus($this->status), 'admin/podcasts/create.html.twig', $data);
    }

    /**
     * updates a podcast
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $podcast = $this->podcasts->find($id);

        if ($podcast) {
            if ($request->isPut()) {
                $validator = $this->container->get(Validator::class);
                $validator->validate($request, PodcastsEntity::getUpdateValidationRules());
                $errors = $validator->getErrors();
                $input = $request->getParams();
                $params = $this->filter($input, PodcastsEntity::getUpdateAbleFields());

                if ($validator->isValid()) {
                    $this->podcasts->update($id, $params);
                    $this->flash->success('podcast.update');
                    return $this->redirect('admin.podcasts');
                } else {
                    $this->flash->error('podcast.update');
                    $this->status = 422;
                }
            }

            $data = compact('errors', 'input', 'podcast', 'categories');
            $data['categories'] = $this->container->get(CategoriesRepository::class)->all();
            return $this->renderer->render($response->withStatus($this->status), 'admin/podcasts/edit.html.twig', $data);
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
            $this->flash->success('podcast.delete');
            return $this->redirect('admin.podcasts');
        }
        return $response->withStatus(404);
    }
}
