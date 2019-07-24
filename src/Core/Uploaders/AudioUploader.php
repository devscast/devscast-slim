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
 * Abstraction for Audio Uploads
 * @package Core\Uploaders
 * @author bernard-ng, https://bernard-ng.github.io
 */
class AudioUploader extends Uploader
{

    /**
     * @inheritDoc
     */
    protected $relativePath = "/uploads/podcasts";

    /**
     * @inheritDoc
     */
    protected const EXTENSIONS = ['mp3', 'mpeg', 'wav', '3gp', 'opus'];

    /**
     * @inheritDoc
     */
    protected const MIME_TYPES = [
        'mp3' => 'audio/mp3',
        'mpeg' => 'audio/mpeg',
        'wav' => 'audio/wav',
        '3gp' => 'audio/3gp',
        'opus' => 'audio/opus'
    ];

    /**
     * @inheritDoc
     */
    protected const MAX_SIZE = 104857600;

    /**
     * @inheritdoc
     */
    protected function getPath(): string
    {
        if (is_null($this->path)) {
            $this->path = WEBROOT . DIRECTORY_SEPARATOR . $this->relativePath;
        }
        return $this->path;
    }
}
