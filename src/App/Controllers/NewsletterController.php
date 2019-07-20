<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controllers;

use App\Repositories\NewsletterRepository;
use App\Validators\NewsletterValidator;
use Awurth\SlimValidation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NewsletterController
 * Data Provider for API and renderer for WebApp
 * @package App\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class NewsletterController extends Controller
{
    /**
     * @var NewsletterRepository|mixed
     */
    private $newsletter;

    /**
     * @var Validator|mixed
     */
    private $validator;


    /**
     * NewsletterController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->newsletter = $container->get(NewsletterRepository::class);
        $this->validator = $container->get(Validator::class);
    }


    /**
     * Check validity of and email and save it into the newsletter table
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->validator->validate($request, NewsletterValidator::getValidationRules());

        if ($this->validator->isValid()) {
            $email = $request->getParam('email');

            if ($this->isUnique($email)) {
                $this->newsletter->create(compact('email'));
                return $response->withJson([
                    'api.message' => 'registration to the newsletter',
                    'api.flash' => 'success'
                ]);
            } else {
                return $response->withJson([
                    'api.message' => 'registration to the newsletter',
                    'api.error' => 'your email has already been registered'
                ])->withStatus(409);
            }
        } else {
            return $response->withJson([
                'api.validation.errors' => [
                    'email' => $this->validator->getErrors('email')
                ]
            ])->withStatus(422);
        }
    }


    /**
     * Whether an email has already been registered
     * @param string $email
     * @return bool
     */
    private function isUnique(string $email): bool
    {
        return !boolval($this->newsletter->findWith('email', $email));
    }
}
