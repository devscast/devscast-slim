<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend\Controllers;

use App\Modules;
use Framework\Logger;
use Slim\Http\Request;
use Slim\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;
use Modules\Backend\DashboardController;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FileBrowserController
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Backend\Controllers
 */
class FileBrowserController extends DashboardController
{

    /**
     * @var string
     */
    private $module = Modules::FILES;

    /**
     * managing files
     *
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function audio(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $filesPath = WEB_ROOT . "/uploads/podcasts";
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
            "@backend/{$this->module}/audio.html.twig",
            compact('directory')
        );
    }


    /**
     * managing files
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function images(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $thumbsPath = WEB_ROOT . "/uploads/thumbs";
        $imagesPath = WEB_ROOT . "/uploads/images";
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
            "@backend/{$this->module}/images.html.twig",
            compact('thumbsDirectory', 'imagesDirectory')
        );
    }
}
