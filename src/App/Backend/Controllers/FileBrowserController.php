<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Backend\Controllers;

use Framework\Logger;
use Slim\Http\Request;
use Slim\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GalleryController
 * administration of  files
 * @package App\Backend\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class FileBrowserController extends DashboardController
{

    /**
     * managing files
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function audio(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $filesPath = WEBROOT . "/uploads/podcasts";
        try {
            $directory = new \DirectoryIterator($filesPath);
        } catch (\Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            $this->flash->error($e->getMessage());
        }

        if ($request->isDelete()) {
            $file = strval($request->getParam('file'));

            if ($file && file_exists($file)) {
                @unlink($file);
                $this->flash->success("files.audio.delete");
                return $this->redirect('admin.files.audio');
            }

            $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            $this->flash->error('files.audio.delete');
        }

        return $this->renderer->render(
            $response->withStatus($this->status),
            "admin/files/audio.html.twig",
            compact('directory')
        );
    }


    /**
     * managing files
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function images(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $thumbsPath = WEBROOT . "/uploads/thumbs";
        $imagesPath = WEBROOT . "/uploads/images";
        try {
            $thumbsDirectory = new \DirectoryIterator($thumbsPath);
            $imagesDirectory = new \DirectoryIterator($imagesPath);
        } catch (\Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            $this->flash->error($e->getMessage());
            return $this->redirect('admin.index');
        }

        if ($request->isDelete()) {
            $file = strval($request->getParam('file'));

            if ($file && file_exists($file)) {
                @unlink($file);
                $this->flash->success("files.images.delete");
                return $this->redirect('admin.files.images');
            }

            $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            $this->flash->error('files.images.delete');
        }

        return $this->renderer->render(
            $response->withStatus($this->status),
            "admin/files/images.html.twig",
            compact('thumbsDirectory', 'imagesDirectory')
        );
    }
}
