<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Renderer\Twig\Extensions;

use Slim\Csrf\Guard;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig_SimpleFunction;

/**
 * Class FormTwigExtension
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Renderer\Twig\Extensions
 */
class FormTwigExtension extends AbstractExtension implements GlobalsInterface
{

    /**
     * @var Guard
     */
    protected $csrf;

    /**
     * FormTwigExtension constructor.
     *
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->csrf = $guard;
    }

    /**
     * Return a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals(): array
    {
        $csrfNameKey = $this->csrf->getTokenNameKey();
        $csrfValueKey = $this->csrf->getTokenValueKey();
        $csrfName = $this->csrf->getTokenName();
        $csrfValue = $this->csrf->getTokenValue();

        return [
            'csrf' => [
                'keys' => [
                    'name' => $csrfNameKey,
                    'value' => $csrfValueKey
                ],
                'name' => $csrfName,
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
     *
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
     *
     * @return string
     */
    public function csrf(): string
    {
        return <<< HTML
    <input type='hidden' name='{$this->csrf->getTokenNameKey()}' value='{$this->csrf->getTokenName()}'/>
    <input type='hidden' name='{$this->csrf->getTokenValueKey()}' value='{$this->csrf->getTokenValue()}'/>
HTML;
    }
}
