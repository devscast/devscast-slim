<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * class DownloadAction
 * a handler for download request
 * @package App\Actions
 * @author bernard-ng, https://bernard-ng.github.io
 */
class DownloadAction
{

    /**
     * download action form a user
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $file = strval($request->getQueryParams()['file']) ?? null;
        $expectedFile = $file ? WEBROOT . "/uploads/podcasts/{$file}" : null;

        if (!is_null($expectedFile) && file_exists($expectedFile)) {
            $basename = basename($expectedFile);
            $file = readfile($expectedFile);

            return $response->withHeader("Cache-Control", "public")
                ->withHeader("Content-Description", "File Transfer")
                ->withHeader("Content-Disposition", "attachment; filename={$basename}")
                ->withHeader("Content-Type", "audio/mp3")
                ->withHeader("Content-Transfer-Encoding", "binary");
        }
        return (new NotFound())($request, $response);
    }
}
