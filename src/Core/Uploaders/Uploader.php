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

use Cake\Core\Exception\Exception;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class Upload
 * Super Class for uploading
 * @package Core\Uploaders
 * @author bernard-ng, https://bernard-ng.github.io
 */
class Uploader
{

    /**
     * The upload target path
     * @var null|string
     */
    protected $path;

    /**
     * Accepted file mime_types
     */
    protected const MIME_TYPES = [];

    /**
     * Accepted file extensions
     */
    protected const EXTENSIONS = [];

    /**
     * Accepted max file size
     */
    protected const MAX_SIZE = 1;

    /**
     * Upload errors
     * @var array
     */
    protected $errors = [];

    /**
     * The uploaded filename after upload
     * @var string
     */
    protected $uploadedFilename;

    /**
     * The uploaded filename before upload
     * @var null|string
     */
    protected $filename;

    /**
     * The upload file
     * @var UploadedFileInterface
     */
    protected $file;

    /**
     * Relative path to the public directory of the server
     * @var string
     */
    protected $relativePath = "uploads";


    /**
     * Upload constructor.
     * @param UploadedFileInterface $file
     */
    public function __construct(UploadedFileInterface $file)
    {
        $this->file = $file;
        return clone $this;
    }

    /**
     * Delete old files and override existing
     * @param null|string $oldVersion
     * @param bool $override will add '_copy' suffix if set to false
     * @return self
     */
    public function prepare(?string $oldVersion = null, bool $override = false): self
    {
        if ($this->isValid($this->file)) {
            $this->delete($oldVersion);
            $filename = $this->filename ?? $this->file->getClientFilename();
            $this->filename = ($override) ? $filename : $this->addSuffix($filename);
        }
        return clone $this;
    }


    /**
     * Move the uploaded file to the target path
     * @return $this|self
     */
    public function upload(): self
    {
        try {
            $this->file->moveTo($this->getPath() . DIRECTORY_SEPARATOR . $this->filename);
            $this->uploadedFilename = $this->relativePath . "/" . $this->filename;
        } catch (\Exception|\Throwable|\Error $e) {
            $this->errors[] = "Something went wrong, try again please";
        } finally {
            return $this;
        }
    }

    /**
     * Whether the file is uploaded
     * @return bool
     */
    public function isUploaded(): bool
    {
        return empty($this->errors);
    }

    /**
     * Add a suffix if a file with the same name already exist
     * @param string $targetPath
     * @param string $suffix
     * @return string
     */
    private function addSuffix(string $targetPath, string $suffix = '_copy'): string
    {
        if (file_exists($targetPath)) {
            $info = pathinfo($targetPath);
            $targetPath =
                "{$info['dirname']}" . DIRECTORY_SEPARATOR . "{$info['filename']}{$suffix}.{$info['extension']}";
            return $this->addSuffix($targetPath);
        }
        return $targetPath;
    }

    /**
     * Delete a file
     * @param string|null $file
     */
    private function delete(?string $file): void
    {
        if ($file) {
            $file = $this->getPath() . DIRECTORY_SEPARATOR . $file;
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Check if the file is really the file type expected
     * @param UploadedFileInterface $file
     * @return bool
     */
    private function isValid(UploadedFileInterface $file): bool
    {
        $this->errors = [];
        if ($file->getError() === UPLOAD_ERR_OK) {
            $type = $file->getClientMediaType();
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = static::MIME_TYPES[$extension] ?? null;

            if (in_array($extension, static::EXTENSIONS) || $expectedType === $type) {
                if ($file->getSize() <= static::MAX_SIZE) {
                    return true;
                }
                $this->errors[] = sprintf("Your file is to big, limit is %d", static::MAX_SIZE);
                return false;
            }
            $this->errors[] = sprintf("%s files are not valid use (%s)", $extension, implode(', ', static::EXTENSIONS));
            return false;
        }
        $this->errors[] = "You have to upload a file";
        return false;
    }

    /**
     * Retrieve upload errors
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Retrieve the uploaded filename
     * @return string
     */
    public function getUploadedFilename(): string
    {
        if (is_null($this->uploadedFilename)) {
            $this->uploadedFilename = $this->relativePath . "/" . $this->filename;
        }
        return $this->uploadedFilename;
    }

    /**
     * Set the target path
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return clone $this;
    }

    /**
     * Set a new filename for the uploaded file
     * @param null|string $filename
     * @return self
     */
    public function setFilename($filename): self
    {
        $this->filename = $filename;
        return clone $this;
    }


    /**
     * Retrieve the target path
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
