<?php
namespace App\Resources;


use App\Repositories\NewsletterRepository;
use Awurth\SlimValidation\Validator;
use Respect\Validation\Validator as v;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
     * save a email to the newsletter
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->validator->validate($request, [
            'email' => v::email()
        ]);

        if ($this->validator->isValid()) {
            $email = strval($request->getParsedBody()['email']);
            $this->newsletter->create(compact('email'));
            return $response->withJson([
                'api.message' => 'registration to the newsletter',
                'api.flash' => 'success'
            ]);
        } else {
            return $response->withJson($this->validator->getErrors())->withJson(400);
        }
    }
}