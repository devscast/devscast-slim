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

use Core\Auth\AuthInterface;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;

/**
 * Class AuthTwigExtension
 * @package Core\Twig
 * @author bernard-ng, https://bernard-ng.github.io
 */
class AuthTwigExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{

    /**
     * @var AuthInterface
     */
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals(): array
    {
        return [
            'currentUser' => $this->auth->getUser()
        ];
    }
}
