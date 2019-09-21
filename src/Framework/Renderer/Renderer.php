<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Framework\Renderer;

use Slim\Views\Twig;

/**
 * Class Renderer
 * Decorator of the Slim\Views\Twig
 * @see Twig
 * @package Framework\Renderer
 * @author bernard-ng, https://bernard-ng.github.io
 */
class Renderer extends Twig
{

    /**
     * Renderer constructor.
     * @param array|string $path
     * @param array $settings
     */
    public function __construct($path, array $settings = [])
    {
        parent::__construct($path, $settings);
    }
}
