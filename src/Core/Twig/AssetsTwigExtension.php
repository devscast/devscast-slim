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
use Slim\Http\Environment;
use Slim\Http\Uri;


/**
 * Class AssetsTwigExtension
 * @package Core\Twig
 */
class AssetsTwigExtension extends \Twig_Extension
{
    /**
     * whether the cacheBusting is enable
     * @var bool
     */
    private $cacheBusting;

    /**
     * directories of assets
     * @var string
     */
    private $assetPath = "assets";

    /**
     * Base Url of the website
     * @var string
     */
    private $baseUrl;

    /**
     * Cross Os directory separator
     * @var string
     */
    private $ds;

    /**
     * AssetsTwigExtension constructor.
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
            new \Twig_SimpleFunction("asset", [$this, 'asset'])
        ];
    }

    /**
     * get the filename
     * @param string $file
     * @return string
     */
    public function asset(string $file): string
    {
        $filename  = WEBROOT . DIRECTORY_SEPARATOR . "{$this->assetPath}" . DIRECTORY_SEPARATOR . $file;
        $filename = str_replace('/', $this->ds, $filename);

        if (file_exists($filename)) {
            $filename = $this->getFilename($filename);
            $filename = "{$this->baseUrl}/{$this->assetPath}/{$filename}";
            $this->resetAssetPath();
            return $filename;
        } else {
            throw new \InvalidArgumentException(sprintf("The file %s does not exists looked in (%s)", $file, $filename));
        }
    }

    /**
     * generate a hash when the file has been update
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
}
