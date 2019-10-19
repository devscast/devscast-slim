<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

if (!defined('APP_NAME')) {
    define('APP_NAME', 'devscast', true);
}

/**
 * domain name of the online application
 * the environment variable ENV must be defined on the Production Server
 */
if (!defined("APP_DOMAIN_NAME")) {
    define('APP_DOMAIN_NAME', getenv('ENV') ? 'https://devs-cast.com' : 'http://localhost:8080', true);
}

/**
 * path to the root folder accessible via the web
 */
if (!defined("WEB_ROOT")) {
    define('WEB_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR . "public", true);
}

/**
 * path to the project root
 */
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__), true);
}

/**
 * the name of the log file,
 * this one is the current date to find easily during a search
 * and thus allow to group the logs by days
 */
if (!defined('LOG_FILE')) {
    define('LOG_FILE', date("m-d-Y") . ".log");
}
