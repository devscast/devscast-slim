<?php
require('../vendor/autoload.php');

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *  title="API Devscast", 
 *  version="0.1",
 *  @OA\Contact(
 *      email="ngandubernard@gmail.com"
 *  ),
 *  @OA\License(
 *   name="Apache 2.0",
 *   url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *  )
 * ),
 * @OA\Server(
 *  url="http://devs-cast.com/api/v1/",
 *  description="Server API"
 * )
 */
