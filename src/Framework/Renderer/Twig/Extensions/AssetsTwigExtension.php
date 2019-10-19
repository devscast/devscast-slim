<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Renderer\Twig\Extensions;

use Framework\Logger;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Slim\Http\Uri;
use Slim\Http\Environment;
use InvalidArgumentException;

/**
 * Class AssetsTwigExtension
 * @package Framework\Renderer\Twig\Extensions
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class AssetsTwigExtension extends AbstractExtension
{
    /**
     * whether the cacheBusting is enable
     *
     * @var bool
     */
    private $cacheBusting;

    /**
     * directories of assets
     *
     * @var string
     */
    private $assetPath = "assets";

    /**
     * directories of images
     *
     * @var string
     */
    private $imagesPath = "images";

    /**
     * Base Url of the website
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Cross Os directory separator
     *
     * @var string
     */
    private $ds;

    /**
     * AssetsTwigExtension constructor.
     *
     * @param bool $cacheBusting
     */
    public function __construct(bool $cacheBusting = false)
    {
        $this->cacheBusting = $cacheBusting;
        $this->baseUrl = Uri::createFromEnvironment(new Environment($_SERVER))->getBaseUrl();
        $this->ds = addslashes(DIRECTORY_SEPARATOR); // for windows os;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction("asset", [$this, 'asset']),
            new TwigFunction("images", [$this, "images"])
        ];
    }

    /**
     * get the filename
     *
     * @param string $file
     * @return string
     */
    public function asset(string $file): string
    {
        $filename = WEB_ROOT . DIRECTORY_SEPARATOR . "{$this->assetPath}" . DIRECTORY_SEPARATOR . $file;
        $filename = str_replace('/', $this->ds, $filename);

        if (file_exists($filename)) {
            $filename = $this->getFilename($filename);
            $filename = "{$this->baseUrl}/{$this->assetPath}/{$filename}";
            $this->resetAssetPath();
            $this->resetImagesPath();
            return $filename;
        } else {
            Logger::error(sprintf("%s does not exists looked in (%s)", $file, $filename));
            throw new InvalidArgumentException(sprintf("%s does not exists looked in (%s)", $file, $filename));
        }
    }

    /**
     * get the filename
     *
     * @param string $file
     * @return string
     */
    public function images(string $file): string
    {
        $filename = WEB_ROOT . DIRECTORY_SEPARATOR . "{$this->imagesPath}" . DIRECTORY_SEPARATOR . $file;
        $filename = str_replace('/', $this->ds, $filename);

        if (file_exists($filename)) {
            $filename = $this->getFilename($filename);
            $filename = "{$this->baseUrl}/{$this->imagesPath}/{$filename}";
            $this->resetImagesPath();
            $this->resetAssetPath();
            return $filename;
        } else {
            Logger::error(sprintf("%s does not exists looked in (%s)", $file, $filename));
            throw new InvalidArgumentException(sprintf("%s does not exists looked in (%s)", $file, $filename));
        }
    }

    /**
     * generate a hash when the file has been update
     *
     * @param string $filename
     * @return string
     */
    private function getFilename(string $filename): string
    {
        $info = pathinfo($filename);
        $baseFilename = preg_replace("#(.*){$this->ds}{$this->assetPath}{$this->ds}#", "", $filename);

        if (preg_match("#(.*{$this->ds})+#", $baseFilename, $matches)) {
            array_shift($matches);
            $this->setAssetPath($this->assetPath . '/' . trim(str_replace("\\", "/", $matches[0]), '/'));
        }

        if ($this->cacheBusting) {
            $hash = md5(@filemtime($filename));
            $filename = "{$info['filename']}_{$hash}.{$info['extension']}";
            return $filename;
        }

        $filename = "{$info['filename']}.{$info['extension']}";
        return $filename;
    }

    /**
     * @param string $assetPath
     */
    private function setAssetPath(string $assetPath)
    {
        $this->assetPath = $assetPath;
    }

    /**
     * reset the assets path to his default value
     */
    private function resetAssetPath()
    {
        $this->assetPath = "assets";
    }

    /**
     * @param string $imagesPath
     */
    private function setImagesPath(string $imagesPath)
    {
        $this->imagesPath = $imagesPath;
    }

    /**
     * reset the images path to his default value
     */
    private function resetImagesPath()
    {
        $this->imagesPath = "images";
    }
}
