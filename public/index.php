<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\App;
use Framework\Logger;

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/config/constants.php');

try {
    $app = new App();

    if (php_sapi_name() !== 'cli') {
        $app->run();
    }
} catch (Throwable | Exception $e) {
    Logger::error($e->getMessage(), [$e->getTraceAsString()]);
    exit("App Error #01");
}
