<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Renderer\Twig\Extensions;

use Twig\Extension\{AbstractExtension, GlobalsInterface};
use Framework\Session\FlashMessage;

/**
 * Class FlashTwigExtension
 * @package Framework\Renderer\Twig\Extensions
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class FlashTwigExtension extends AbstractExtension implements GlobalsInterface
{

    /**
     * @var FlashMessage
     */
    private $flash;

    /**
     * FlashTwigExtension constructor.
     * @param FlashMessage $flash
     */
    public function __construct(FlashMessage $flash)
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
            'flash' => $this->flash->getAll()
        ];
    }
}
