<?php
namespace App\Resources;

use Slim\Container;
use Slim\Http\Response;

/**
 * Class HomeResources
 * @package App\Resources
 */
class HomeResource
{

    /**
     * the welcome text to the app
     *
     * @return string
     */
    public function index()
    {
        $response = new Response();
        return $response->withJson(["api-message.info" => "Welcome To The Voting-machine Application"]);
    }
}
