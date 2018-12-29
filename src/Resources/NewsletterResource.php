<?php
namespace App\Resources;


use App\Repositories\NewsletterRepository;
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
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $email = strval($request->getParsedBody()['email']);


    }
}