<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Renderer\Twig\Extensions;

use Twig\Extension\{AbstractExtension, GlobalsInterface};
use Modules\Page\QuotesRepository;

/**
 * Class QuoteTwigExtension
 * @package App\Renderer\Twig\Extensions
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class QuoteTwigExtension extends AbstractExtension implements GlobalsInterface
{
    /** @var QuotesRepository */
    private $repository;

    /**
     * QuoteTwigExtension constructor.
     *
     * @param QuotesRepository $repository
     */
    public function __construct(QuotesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'quote' => $this->repository->random()
        ];
    }
}
