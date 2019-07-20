<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core;

/**
 * Class Logger
 * Static Adapter for the Logger
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
abstract class Logger
{

    /**
     * logger instance
     * @var \Monolog\Logger
     */
    private static $logger;


    /**
     * Detailed debug information
     */
    const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    const INFO = 200;

    /**
     * Uncommon events
     */
    const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    const WARNING = 300;

    /**
     * Runtime errors
     */
    const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    const ALERT = 550;

    /**
     * Urgent alert.
     */
    const EMERGENCY = 600;


    /**
     * create an instace of the logger
     * @return \Monolog\Logger
     */
    private static function getLogger(): \Monolog\Logger
    {
        if (is_null(self::$logger)) {
            $logger = new \Monolog\Logger("DEVSCAST");
            $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
            $logger->pushHandler(new \Monolog\Handler\StreamHandler(
                ROOT . "/data/logs/app.log",
                \Monolog\Logger::DEBUG
            ));
            self::$logger = $logger;
            return self::$logger;
        }
        return self::$logger;
    }

    /**
     * Adds a log record at the DEBUG level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function debug($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::DEBUG, $message, $context);
    }

    /**
     * Adds a log record at the INFO level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function info($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::INFO, $message, $context);
    }

    /**
     * Adds a log record at the NOTICE level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function notice($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::NOTICE, $message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function warn($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::WARNING, $message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function warning($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::WARNING, $message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function err($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::ERROR, $message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function error($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::ERROR, $message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function crit($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::CRITICAL, $message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function critical($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::CRITICAL, $message, $context);
    }

    /**
     * Adds a log record at the ALERT level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function alert($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::ALERT, $message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function emerg($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::EMERGENCY, $message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array  $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function emergency($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::EMERGENCY, $message, $context);
    }
}
