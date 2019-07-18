<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use App\Repositories\QuotesRepository;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;

/**
 * Class QuoteTwigExtension
 * @package App\Twig
 * @author bernard-ng, https://bernard-ng.github.io
 */
class QuoteTwigExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    /**
     * @var QuotesRepository
     */
    private $repository;

    /**
     * QuoteTwigExtension constructor.
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
