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

use Slim\Csrf\Guard;

/**
 * Class FormTwigExtension
 * @package Core\Twig
 */
class FormTwigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    /**
     * @var Guard
     */
    protected $csrf;

    /**
     * FormTwigExtension constructor.
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->csrf = $guard;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        $csrfNameKey = $this->csrf->getTokenNameKey();
        $csrfValueKey = $this->csrf->getTokenValueKey();
        $csrfName = $this->csrf->getTokenName();
        $csrfValue = $this->csrf->getTokenValue();

        return [
            'csrf'   => [
                'keys' => [
                    'name'  => $csrfNameKey,
                    'value' => $csrfValueKey
                ],
                'name'  => $csrfName,
                'value' => $csrfValue
            ]
        ];
    }


    /**
     * @inheritdoc
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('_method', [$this, 'method'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('_csrf', [$this, 'csrf'], ['is_safe' => ['html']])
        ];
    }

    /**
     * set request method that cannot be sent
     * via a web browser
     * @param string $method
     * @return string
     */
    public function method(string $method)
    {
        $method = strtoupper($method);
        return "<input type='hidden' name='_method' value='{$method}'/>";
    }

    /**
     * generate csrf token inputs
     */
    public function csrf()
    {
        $csrf = "<input type='hidden' name='{$this->csrf->getTokenNameKey()}' value='{$this->csrf->getTokenName()}'/>";
        $csrf .= "<input type='hidden' name='{$this->csrf->getTokenValueKey()}' value='{$this->csrf->getTokenValue()}'/>";
        return $csrf;
    }
}
