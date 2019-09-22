<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend\User;

use Framework\Logger;
use Slim\Http\StatusCode;
use Modules\User\UsersValidator;
use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Modules\Backend\DashboardController;
use Psr\Http\Message\ServerRequestInterface;
use App\Authenticators\DatabaseAuthenticator;

/**
 * Class AuthController
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Backend\Controllers
 */
class AuthController extends DashboardController
{

    /**
     * @var DatabaseAuthenticator|mixed
     */
    private $databaseAuth;

    /**
     * AuthController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->databaseAuth = $container->get(DatabaseAuthenticator::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
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
                    $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
                    Logger::info("Attempt Connexion");
                } else {
                    Logger::info("Administrator Login");
                    return $this->redirect('admin.index');
                }
            } else {
                $errors = $validator->getErrors();
                $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
                Logger::info("Attempt Connexion");
            }
        }

        return $this->renderer->render(
            $response,
            "@backend/auth/login.html.twig",
            compact('input', 'errors')
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isPost()) {
            $this->databaseAuth->logout();
            return $this->redirect('home');
        }

        Logger::info("Administrator Logout");
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }
}
