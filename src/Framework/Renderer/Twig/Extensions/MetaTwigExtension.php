<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Renderer\Twig\Extensions;

use Framework\MetaManager;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

/**
 * Class MetaTwigExtension
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Renderer\Twig\Extensions
 */
class MetaTwigExtension extends AbstractExtension implements GlobalsInterface
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
            new TwigFunction('meta', [$this, "getMeta"], ["is_safe" => ["html"]])
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
