<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */


namespace Framework\Uploader;

/**
 * Class ImageUploader
 * @package Framework\Uploader
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ImageUploader extends Uploader
{

    /**
     * {@inheritDoc}
     */
    protected $relativePath = "/uploads/thumbs";

    /**
     * {@inheritDoc}
     */
    protected const EXTENSIONS = ['jpg', 'png', 'gif', 'jpeg'];

    /**
     * {@inheritDoc}
     */
    protected const MIME_TYPES = [
        'jpg' => 'image/jpg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'jpeg' => 'image/jpeg'
    ];

    /**
     * {@inheritDoc}
     */
    protected const MAX_SIZE = 15728640;

    /**
     * {@inheritDoc}
     * @return string
     */
    protected function getPath(): string
    {
        if (is_null($this->path)) {
            $this->path = WEB_ROOT . DIRECTORY_SEPARATOR . $this->relativePath;
        }
        return $this->path;
    }
}
