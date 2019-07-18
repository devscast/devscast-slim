<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Core\Twig;

use Twig_Extension;
use Core\Session\FlashService;
use Twig_Extension_GlobalsInterface;

/**
 * Class FlashTwigExtension
 * @package Core\Twig
 * @author bernard-ng, https://bernard-ng.github.io
 */
class FlashTwigExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{

    /**
     * @var FlashService
     */
    private $flash;

    public function __construct(FlashService $flash)
    {
        $this->flash = $flash;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals(): array
    {
        return [
            'flash' => $this->flash
        ];
    }
}
