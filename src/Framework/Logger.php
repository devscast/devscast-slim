<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework;

use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;

/**
 * Class Logger
 * this is a hack to easily use the logger ;) :p
 * @package Framework
 * @author bernard-ng <ngandubernard@gmail.com>
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
    public const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    public const INFO = 200;

    /**
     * Uncommon events
     */
    public const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    public const WARNING = 300;

    /**
     * Runtime errors
     */
    public const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    public const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    public const ALERT = 550;

    /**
     * Urgent alert.
     */
    public const EMERGENCY = 600;


    /**
     * create an instance of the logger
     * @return \Monolog\Logger
     */
    private static function getLogger(): \Monolog\Logger
    {
        if (is_null(self::$logger)) {
            try {
                $logger = new \Monolog\Logger(APP_NAME);
                $logger->pushProcessor(new UidProcessor());
                $logger->pushHandler(new StreamHandler(
                    ROOT . "/data/logs/" . LOG_FILE,
                    \Monolog\Logger::DEBUG
                ));
                self::$logger = $logger;
                return self::$logger;
            } catch (\Exception $e) {
                die('error: logger #01');
            }
        }
        return self::$logger;
    }

    /**
     * Adds a log record at the DEBUG level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
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
     * @param string $message The log message
     * @param array $context The log context
     * @return bool   Whether the record has been processed
     */
    public static function emergency($message, array $context = [])
    {
        return self::getLogger()->addRecord(static::EMERGENCY, $message, $context);
    }
}
