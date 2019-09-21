<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Framework\Twig;

use Framework\MetaManager;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;
use Twig_SimpleFunction;

/**
 * Class MetaTwigExtension
 * @package Framework\Twig
 * @author bernard-ng, https://bernard-ng.github.io
 */
class MetaTwigExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    /**
     * @var MetaManager
     */
    private $manager;

    /**
     * MetaTwigExtension constructor.
     * @param MetaManager $manager
     */
    public function __construct(MetaManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals(): array
    {
        return [
            "meta" => $this->manager
        ];
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('meta', [$this, "getMeta"], ["is_safe" => ["html"]])
        ];
    }

    /**
     * Generate meta from metaStore
     * @return string|null
     */
    public function getMeta(): ?string
    {
        if (!empty($this->metaStore)) {
            $meta = "";
            foreach ($this->manager->metaStore as $name => $content) {
                  $meta .= "<meta name='{$name}' content='{$content}' />";
            }
            return $meta;
        }
        return null;
    }
}
