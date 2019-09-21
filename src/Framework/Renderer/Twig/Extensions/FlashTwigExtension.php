<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Renderer\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Framework\Session\FlashService;

/**
 * Class FlashTwigExtension
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Twig
 */
class FlashTwigExtension extends AbstractExtension implements GlobalsInterface
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
