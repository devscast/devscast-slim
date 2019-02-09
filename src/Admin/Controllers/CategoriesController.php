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

use App\Repositories\CategoriesRepository;
use App\Repositories\Validators\CategoriesValidator;
use Awurth\SlimValidation\Validator;
use Core\CRUDInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CategoriesController
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CategoriesController extends DashboardController implements CRUDInterface
{
    /**
     * @var CategoriesRepository|mixed
     */
    private $categories;

    /**
     * CategoriesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->categories = $container->get(CategoriesRepository::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
       $categories = $this->categories->all();
       return $this->renderer->render($response, 'admin/categories/index.html.twig', compact('categories'));
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isPost()) {
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, CategoriesValidator::getValidationRules());
            $input = $request->getParams();
            $errors = $validator->getErrors();
            $params = $this->filter($input, CategoriesValidator::getStoreAbleFields());

            if ($validator->isValid()) {
                $this->categories->create($params);
                $this->flash->success('categories.create');
                return $this->redirect('admin.categories');
            } else {
                $this->flash->error('categories.create');
                $this->status = 422;
            }
        }

        $data = compact('errors', 'input');
        return $this->renderer->render($response->withStatus($this->status), 'admin/categories/create.html.twig', $data);
    }

    /**
     * @TODO fix the bug while storing updated data
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $category = $this->categories->find($id);

        if ($category) {
            if ($request->isPut()) {
                $validator = $this->container->get(Validator::class);
                $validator->validate($request, CategoriesValidator::getUpdateValidationRules());
                $errors = $validator->getErrors();
                $input = $request->getParams();
                $params = $this->filter($input, CategoriesValidator::getUpdateAbleFields());

                if ($validator->isValid()) {
                    $this->categories->update($id, $params);
                    $this->flash->success('categories.update');
                    return $this->redirect('admin.categories');
                } else {
                    $this->flash->error('categories.update');
                    $this->status = 422;
                }
            }

            $data = compact('errors', 'input', 'category');
            return $this->renderer->render($response->withStatus($this->status), 'admin/categories/edit.html.twig', $data);
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
        if ($request->isDelete()) {
            $id = $request->getAttribute('route')->getArgument('id');
            if ($this->categories->find($id)) {
                $this->categories->destroy($id);
                $this->flash->success('categories.delete');
                return $this->redirect('admin.categories');
            }
        }
        return $response->withStatus(404);
    }
}
