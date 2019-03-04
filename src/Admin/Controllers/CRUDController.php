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

use Awurth\SlimValidation\Validator;
use Core\CRUDInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CRUDController
 * Implementation of CRUDInterface, this is for avoid code repetition
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CRUDController extends DashboardController implements CRUDInterface
{

    /**
     * Module repository Class
     * @var Object
     */
    protected $repository;

    /**
     * Module full name
     * @var string
     */
    protected $module;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Module data validation class
     * @var string
     */
    protected $validator;

    /**
     * CRUDController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    /**
     * [READ] implementation should list all data for a particular module
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $items = $this->repository->all();
        return $this->renderer->render($response, "admin/{$this->module}/index.html.twig", compact('items'));
    }

    /**
     * [CREATE] implementation should store new data for a particular module
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isPost()) {
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, call_user_func([$this->validator, 'getValidationRules']));
            $input = $request->getParams();
            $errors = $validator->getErrors();
            $params = $this->filter($input, call_user_func([$this->validator, 'getValidationRules']));

            if ($validator->isValid()) {
                $this->repository->create($params);
                $this->flash->success("{$this->module}.create");
                return $this->redirect("admin.{$this->module}");
            } else {
                $this->flash->error("{$this->module}.create");
                $this->status = 422;
            }
        }

        $data = compact('errors', 'input');
        return $this->renderer->render($response->withStatus($this->status), "admin/{$this->module}/create.html.twig", $data);
    }

    /**
     * [UPDATE] implementation should update data for a particular module
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $item = $this->repository->find($id);

        if ($item) {
            if ($request->isPut()) {
                $validator = $this->container->get(Validator::class);
                $validator->validate($request, call_user_func([$this->validator, 'getValidationRules']));
                $errors = $validator->getErrors();
                $input = $request->getParams();
                $params = $this->filter($input, call_user_func([$this->validator, 'getUpdateAbleFields']));

                if ($validator->isValid()) {
                    $this->repository->update($id, $params);
                    $this->flash->success("{$this->module}.update");
                    return $this->redirect("admin.{$this->module}");
                } else {
                    $this->flash->error("{$this->module}.update");
                    $this->status = 422;
                }
            }

            $data = compact('errors', 'input', 'item');
            return $this->renderer->render($response->withStatus($this->status), "admin/{$this->module}/edit.html.twig", $data);
        }
        return $response->withStatus(404);
    }

    /**
     * [DELETE] implementation should destroy data for a particular module
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isDelete()) {
            $id = $request->getAttribute('route')->getArgument('id');
            if ($this->repository->find($id)) {
                $this->repository->destroy($id);
                $this->flash->success("{$this->module}.delete");
                return $this->redirect("admin.{$this->module}");
            }
        }
        return $response->withStatus(404);
    }
}
