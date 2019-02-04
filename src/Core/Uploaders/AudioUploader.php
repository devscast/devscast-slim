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
 * Class AudioUploader
 * @package Core\Uploaders
 */
class AudioUploader extends Uploader
{

    /**
     * @inheritDoc
     * @var string
     */
    protected $relativePath = "uploads/podcasts";

    /**
     * @inheritDoc
     */
    protected const EXTENSIONS = ['mp3', 'mpeg', 'wav', '3gp'];

    /**
     * @inheritDoc
     */
    protected const MIME_TYPES = [
        'mp3' => 'audio/mp3',
        'mpeg' => 'audio/mpeg',
        'wav' => 'audio/wav',
        '3gp' => 'audio/3gp'
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