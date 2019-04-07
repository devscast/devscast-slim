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

use Core\MetaManager;

/**
 * Class MetaTwigExtension
 * @package Core\Twig
 */
class MetaTwigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
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
            new \Twig_SimpleFunction('meta', [$this, "getMeta"], ["is_safe" => ["html"]])
        ];
    }

    /**
     * Generate meta from metaStore
     * @return string
     */
    public function getMeta(): string
    {
        $meta = "";
        foreach ($this->manager->metaStore as $name => $content) {
            $meta .= "<meta name='{$name}' content='{$content}' />";
        }
        return $meta;
    }
}