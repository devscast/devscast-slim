<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Handlers;

use Exception;
use Framework\Logger;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Slim\Handlers\AbstractError;
use Slim\Http\Body;
use Throwable;
use Twig\Error\LoaderError;
use UnexpectedValueException;

/**
 * Class ErrorHandler
 * @package App\Handlers
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ErrorHandler extends AbstractError
{

    /** @var RendererInterface|TwigRenderer */
    private $renderer;

    /**
     * ErrorHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container->get('settings.displayErrorDetails'));
        $this->renderer = $container->get(RendererInterface::class);
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $exception)
    {
        $contentType = $this->determineContentType($request);
        switch ($contentType) {
            case 'application/json':
                $output = $this->renderJsonErrorMessage($exception);
                break;

            case 'text/xml':
            case 'application/xml':
                $output = $this->renderXmlErrorMessage($exception);
                break;

            case 'text/html':
                try {
                    $output = $this->renderHtmlErrorMessage($exception);
                } catch (LoaderError $e) {
                    Logger::error($e->getMessage(), [$e->getTraceAsString()]);
                    exit("App Error #03");
                }
                break;

            default:
                throw new UnexpectedValueException('Cannot render unknown content type ' . $contentType);
        }

        $this->writeToErrorLog($exception);

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($output);

        return $response
            ->withStatus(500)
            ->withHeader('Content-type', $contentType)
            ->withBody($body);
    }

    /**
     * @param Throwable $exception
     * @return string
     * @throws LoaderError
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function renderHtmlErrorMessage(Throwable $exception)
    {
        $title = 'STEM ERROR';
        if ($this->displayErrorDetails) {
            $html = '<p>The application could not run because of the following error:</p>';
            $html .= '<h2>Details</h2>';
            $html .= $this->renderHtmlException($exception);

            while ($exception = $exception->getPrevious()) {
                $html .= '<h2>Previous exception</h2>';
                $html .= $this->renderHtmlExceptionOrError($exception);
            }
        } else {
            return $this->renderer->fetch("@errors/500.html.twig");
        }

        $output = sprintf(
            "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>" .
            "<title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana," .
            "sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{" .
            "display:inline-block;width:65px;}</style></head><body><h1>%s</h1>%s</body></html>",
            $title,
            $title,
            $html
        );
        return $output;
    }

    /**
     * Render exception as HTML.
     *
     * Provided for backwards compatibility; use renderHtmlExceptionOrError().
     *
     * @param Throwable $exception
     *
     * @return string
     */
    protected function renderHtmlException(Throwable $exception)
    {
        return $this->renderHtmlExceptionOrError($exception);
    }

    /**
     * Render exception or error as HTML.
     *
     * @param Throwable $exception
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected function renderHtmlExceptionOrError(Throwable $exception)
    {
        if (!$exception instanceof Exception && !$exception instanceof \Error) {
            throw new RuntimeException("Unexpected type. Expected Exception or Error.");
        }

        $html = sprintf('<div><strong>Type:</strong> %s</div>', get_class($exception));

        if (($code = $exception->getCode())) {
            $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        }

        if (($message = $exception->getMessage())) {
            $html .= sprintf('<div><strong>Message:</strong> %s</div>', htmlentities($message));
        }

        if (($file = $exception->getFile())) {
            $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        }

        if (($line = $exception->getLine())) {
            $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        }

        if (($trace = $exception->getTraceAsString())) {
            $html .= '<h2>Trace</h2>';
            $html .= sprintf('<pre>%s</pre>', htmlentities($trace));
        }

        return $html;
    }

    /**
     * Render JSON error
     *
     * @param Throwable $exception
     *
     * @return string
     */
    protected function renderJsonErrorMessage(Throwable $exception)
    {
        $error = [
            'message' => 'Slim Application Error',
        ];

        if ($this->displayErrorDetails) {
            $error['exception'] = [];

            do {
                $error['exception'][] = [
                    'type' => get_class($exception),
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => explode("\n", $exception->getTraceAsString()),
                ];
            } while ($exception = $exception->getPrevious());
        }

        return json_encode($error, JSON_PRETTY_PRINT);
    }

    /**
     * Render XML error
     *
     * @param Throwable $exception
     *
     * @return string
     */
    protected function renderXmlErrorMessage(Throwable $exception)
    {
        $xml = "<error>\n  <message>Slim Application Error</message>\n";
        if ($this->displayErrorDetails) {
            do {
                $xml .= "  <exception>\n";
                $xml .= "    <type>" . get_class($exception) . "</type>\n";
                $xml .= "    <code>" . $exception->getCode() . "</code>\n";
                $xml .= "    <message>" . $this->createCdataSection($exception->getMessage()) . "</message>\n";
                $xml .= "    <file>" . $exception->getFile() . "</file>\n";
                $xml .= "    <line>" . $exception->getLine() . "</line>\n";
                $xml .= "    <trace>" . $this->createCdataSection($exception->getTraceAsString()) . "</trace>\n";
                $xml .= "  </exception>\n";
            } while ($exception = $exception->getPrevious());
        }
        $xml .= "</error>";

        return $xml;
    }

    /**
     * Returns a CDATA section with the given content.
     *
     * @param  string $content
     *
     * @return string
     */
    private function createCdataSection($content)
    {
        return sprintf('<![CDATA[%s]]>', str_replace(']]>', ']]]]><![CDATA[>', $content));
    }
}
