<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Core\Uploaders;

/**
 * Class ImageUploader
 * @package Core\Uploaders
 */
class ImageUploader extends Uploader
{

    /**
     * @inheritDoc
     * @var string
     */
    protected $relativePath = "uploads/thumbs";

    /**
     * @inheritDoc
     */
    protected const EXTENSIONS = ['jpg', 'png', 'gif', 'jpeg'];

    /**
     * @inheritDoc
     */
    protected const MIME_TYPES = [
        'jpg' => 'image/jpg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'jpeg' => 'image/jpeg'
    ];

    /**
     * @inheritDoc
     */
    protected const MAX_SIZE = 100000000000000;

    /**
     * @return string
     */
    protected function getPath(): string
    {
        if (is_null($this->path)) {
            $this->path = WEBROOT . DIRECTORY_SEPARATOR . $this->relativePath;
        }
        return $this->path;
    }
}