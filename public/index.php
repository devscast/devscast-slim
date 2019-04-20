<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\App;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/config/constants.php');
try {
    $app = new App();
    $app->setup()->run();
} catch (MethodNotAllowedException | NotFoundException | Exception $e) {
    echo $e->getMessage();
}
