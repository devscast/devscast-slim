<?php
namespace Admin\Controllers;
use Psr\Container\ContainerInterface;


/**
 * Class GalleryController
 * @package Admin\Controllers
 */
class GalleryController extends DashboardController
{

    /**
     * @var null
     */
    private $gallery;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->gallery = null;
    }
}