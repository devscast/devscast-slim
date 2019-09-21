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

use Slim\Csrf\Guard;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;
use Twig_SimpleFunction;

/**
 * Class FormTwigExtension
 * Add _token and _method function to Twig
 * @package Framework\Twig
 * @author bernard-ng, https://bernard-ng.github.io
 */
class FormTwigExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
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
     * Return a list of global variables to add to the existing list.
     * @return array An array of global variables
     */
    public function getGlobals(): array
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
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('_method', [$this, 'method'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('_csrf', [$this, 'csrf'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Set request method that cannot be sent via a web browser
     * @param string $method
     * @return string
     */
    public function method(string $method): string
    {
        $method = strtoupper($method);
        return "<input type='hidden' name='_method' value='{$method}'/>";
    }

    /**
     * Generate csrf token inputs
     * @return string
     */
    public function csrf(): string
    {
        $csrf = <<< HTML
<input type='hidden' name='{$this->csrf->getTokenNameKey()}' value='{$this->csrf->getTokenName()}'/>
<input type='hidden' name='{$this->csrf->getTokenValueKey()}' value='{$this->csrf->getTokenValue()}'/>
HTML;
        return $csrf;
    }
}
