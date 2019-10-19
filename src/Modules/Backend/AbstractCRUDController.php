<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend;

use Slim\Http\StatusCode;
use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AbstractCRUDController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Backend
 */
class AbstractCRUDController extends DashboardController implements CRUDControllerInterface
{

    /**
     * Module repository Class
     *
     * @var Object
     */
    protected $repository;

    /**
     * Module full name
     *
     * @var string
     */
    protected $module;

    /**
     * Route name
     * @var string
     */
    protected $path;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Module data validation class
     *
     * @var string
     */
    protected $validator;

    /**
     * CRUDController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    /**
     * @inheritDoc
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $items = $this->repository->all();
        return $this->renderer->render(
            $response,
            "@backend/{$this->module}/index.html.twig",
            compact('items')
        );
    }

    /**
     * @inheritDoc
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $errors = $input = [];
        if ($request->isPost()) {
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, call_user_func([$this->validator, 'getValidationRules']));
            $input = $request->getParams();
            $errors = $validator->getErrors();
            $params = $this->filter($input, call_user_func([$this->validator, 'getStoreAbleFields']));

            if ($validator->isValid()) {
                $this->repository->create($params);
                $this->flash->success("{$this->module}.create");
                return $this->redirect("admin.{$this->module}");
            } else {
                $this->flash->error("{$this->path}.create");
                $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            }
        }

        $data = compact('errors', 'input');
        return $this->renderer->render(
            $response->withStatus($this->status),
            "@backend/{$this->path}/create.html.twig",
            $data
        );
    }

    /**
     * @inheritDoc
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $item = $this->repository->find($id);
        $errors = $input = [];

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
                    $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
                }
            }

            $data = compact('errors', 'input', 'item');
            return $this->renderer->render(
                $response->withStatus($this->status),
                "@backend/{$this->path}/edit.html.twig",
                $data
            );
        }
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }

    /**
     * @inheritDoc
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
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }
}
