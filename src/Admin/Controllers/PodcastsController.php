<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Controllers;

use App\Modules;
use App\Repositories\CategoriesRepository;
use App\Repositories\PodcastsRepository;
use App\Validators\PodcastsValidator;
use Awurth\SlimValidation\Validator;
use Framework\Uploaders\AudioUploader;
use Framework\Uploaders\ImageUploader;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class PodcastsController
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PodcastsController extends CRUDController
{

    /**
     * PodcastsController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(PodcastsRepository::class);
        $this->validator = PodcastsValidator::class;
        $this->module = Modules::PODCASTS;
    }

    /**
     * create and store podcast
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $errors = $input = [];
        if ($request->isPost()) {
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, PodcastsValidator::getValidationRules());
            $input = $request->getParams();
            $errors = $validator->getErrors();
            $params = $this->filter($input, PodcastsValidator::getStoreAbleFields());

            if ($validator->isValid()) {
                if ($request->getUploadedFiles()) {
                    uploading: {
                        $audio = new AudioUploader($request->getUploadedFiles()['audio']);
                        $audio->setFilename("{$params['name']}.opus");
                        $audio->prepare()->upload();

                        $thumb = new ImageUploader($request->getUploadedFiles()['thumb']);
                        $thumb->setFilename("{$params['name']}.jpg");
                        $thumb->prepare()->upload();
                    }

                    if ($audio->isUploaded() && $thumb->isUploaded()) {
                        $params['audio'] = $audio->getUploadedFilename();
                        $params['thumb'] = $thumb->getUploadedFilename();

                        if (empty($errors)) {
                            $this->repository->create($params);
                            $this->flash->success('podcast.create');
                            return $this->redirect('admin.podcasts');
                        }
                    } else {
                        $errors['audio'] = $audio->getErrors();
                        $errors['thumb'] = $thumb->getErrors();
                        $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
                    }
                }
            } else {
                $this->flash->error('podcast.create');
                $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            }
        }

        $data = compact('errors', 'input');
        $data['categories'] = $this->container->get(CategoriesRepository::class)->all();
        return $this->renderer->render($response->withStatus($this->status), 'admin/podcasts/create.html.twig', $data);
    }

    /**
     * update a single podcast
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $item = $this->repository->find($id);
        $errors = $input = [];

        if ($item) {
            if ($request->isPut()) {
                $validator = $this->container->get(Validator::class);
                $validator->validate($request, PodcastsValidator::getUpdateValidationRules());
                $errors = $validator->getErrors();
                $input = $request->getParams();
                $params = $this->filter($input, PodcastsValidator::getUpdateAbleFields());
                $params['online'] = $params['online'] ?? '0';

                if ($validator->isValid()) {
                    $this->repository->update($id, $params);
                    $this->flash->success('podcast.update');
                    return $this->redirect('admin.podcasts');
                } else {
                    $this->flash->error('podcast.update');
                    $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
                }
            }

            $data = compact('errors', 'input', 'item');
            $data['categories'] = $this->container->get(CategoriesRepository::class)->all();
            return $this->renderer->render(
                $response->withStatus($this->status),
                'admin/podcasts/edit.html.twig',
                $data
            );
        }
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }
}
