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

use App\Entities\NewsletterEntity;
use App\Repositories\NewsletterRepository;
use Awurth\SlimValidation\Validator;
use Respect\Validation\Validator as v;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NewsletterResource
 * @package App\Resources
 */
class NewsletterResource
{
    /**
     * @var NewsletterRepository|mixed
     */
    private $newsletter;


    /**
     * NewsletterResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
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
        $this->validator->validate($request, NewsletterEntity::getValidationRules());

        if ($this->validator->isValid()) {
            $email = $request->getParam('email');

            if ($this->isUnique($email)) {
                $this->newsletter->create(compact('email'), true);
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
