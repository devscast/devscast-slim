<?php
/**
 * This file is part of the DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Framework\Renderer;

use Slim\Views\Twig;

/**
 * Class Renderer
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Renderer
 */
class Renderer extends Twig
{

    /**
     * Renderer constructor.
     *
     * @param array|string $path
     * @param array $settings
     */
    public function __construct($path, array $settings = [])
    {
        parent::__construct($path, $settings);
    }
}
