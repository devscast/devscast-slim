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

use App\Auth\DatabaseAuth;
use App\Validators\UsersValidator;
use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthController
 * @package Admin\Controllers
 */
class AuthController extends DashboardController
{

    /**
     * @var DatabaseAuth|mixed
     */
    private $databaseAuth;

    /**
     * AuthController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->databaseAuth = $container->get(DatabaseAuth::class);
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $errors = $input = [];
        if ($request->isPost()) {
            $input = $request->getParams();
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, UsersValidator::getLoginValidationRules());

            if ($validator->isValid()) {
                $user = $this->databaseAuth->login($input['email'], $input['password']);

                if (!$user) {
                    $this->flash->error('Invalid Credentials');
                    $this->status = 422;
                } else {
                    return $this->redirect('admin.index');
                }
            } else {
                $errors = $validator->getErrors();
                $this->status = 422;
            }
        }

        return $this->renderer->render($response, "auth/login.html.twig", compact('input', 'errors'));
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->databaseAuth->logout();
        return $this->redirect('home');
    }
}
