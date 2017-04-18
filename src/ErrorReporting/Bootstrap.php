<?php

namespace Google\Cloud\ErrorReporting;

use Google\Cloud\Logging\BatchLogger;

/**
 * Static methods for bootstrapping Stackdriver Error Reporting.
 */
class Bootstrap
{
    const DEFAULT_LOGNAME = 'app-error';

    /** @var BatchLogger */
    public static $batchLogger;

    /**
     * Register hooks for error reporting.
     *
     * @param BatchLogger $batchLogger
     * @return void
     */
    public static function init(BatchLogger $batchLogger = null)
    {
        register_shutdown_function(
            [
                '\\Google\\Cloud\\ErrorReporting\\Bootstrap',
                'shutdownHandler'
            ]
        );
        set_exception_handler(
            array(
                '\\Google\\Cloud\\ErrorReporting\\Bootstrap',
                'exceptionHandler'
            )
        );
        set_error_handler(
            array(
                '\\Google\\Cloud\\ErrorReporting\\Bootstrap',
                'errorHandler'
            )
        );
        // TODO: Allow users to use own BatchLogger.
        self::$batchLogger = $batchLogger !== null ?: new BatchLogger(
            self::DEFAULT_LOGNAME,
            true, // debug output
            ['workerNum' => 2]
        );
    }

    /**
     * Return a string prefix for the given error level.
     *
     * @param int $level
     * @return string A string prefix for reporting the error.
     */
    public static function getErrorPrefix($level)
    {
        switch ($level) {
            case E_PARSE:
                $prefix = 'PHP Parse error';
                break;
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
                $prefix = 'PHP Fatal error';
                break;
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                $prefix = 'PHP error';
                break;
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                $prefix = 'PHP Warning';
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $prefix = 'PHP Notice';
                break;
            case E_STRICT:
                $prefix = 'PHP Debug';
                break;
            default:
                $prefix = 'PHP Notice';
        }
        return $prefix;
    }

    /**
     * Return a string PSR-3 error level for the given PHP error level.
     *
     * @param int $level
     * @return string A PSR-3 error level string.
     */
    public static function getPsr3ErrorLevel($level)
    {
        switch ($level) {
            case E_PARSE:
                return 'critical';
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                return 'error';
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                return 'warning';
            case E_NOTICE:
            case E_USER_NOTICE:
                return 'notice';
            case E_STRICT:
                return 'debug';
            default:
                return 'notice';
        }
        return $prefix;
    }

    /**
     * @param mixed $ex \Throwable (PHP 7) or \Exception (PHP 5)
     */
    public static function exceptionHandler($ex)
    {
        $message = sprintf('PHP Notice: %s', (string)$ex);
        self::$batchLogger->error($message);
    }

    /**
     * @param int $level The error level.
     * @param string $message The error message.
     * @param string $file The filename that the error was raised in.
     * @param int $line The line number that the error was raised at.
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (!($level & \error_reporting())) {
            return true;
        }
        $service = self::$batchLogger->getMetadataProvider()->getService();
        $version = self::$batchLogger->getMetadataProvider()->getVersion();
        $message =  sprintf(
            '%s: %s in %s on line %d',
            self::getErrorPrefix($level),
            $message,
            $file,
            $line
        );
        $context = [
            'context' => [
                'reportLocation' => [
                    'filePath' => $file,
                    'lineNumber' => $line,
                    'functionName' => 'unknown'
                ]
            ],
            'serviceContext' => [
                'service' => $service,
                'version' => $version
            ]
        ];
        self::$batchLogger->log(self::getPsr3ErrorLevel($level), $message, $context);
    }

    /**
     * Called at exit, to check there's a fatal error and report the error if
     * any.
     */
    public static function shutdownHandler()
    {
        if ($err = error_get_last()) {
            $service = self::$batchLogger->getMetadataProvider()->getService();
            $version = self::$batchLogger->getMetadataProvider()->getVersion();
            switch ($err['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_COMPILE_ERROR:
                case E_COMPILE_WARNING:
                case E_CORE_ERROR:
                case E_CORE_WARNING:
                    $message = sprintf(
                        '%s: %s in %s on line %d',
                        self::getErrorPrefix($err['type']),
                        $err['message'],
                        $err['file'],
                        $err['line']
                    );
                    $context = [
                        'context' => [
                            'reportLocation' => [
                                'filePath' => $err['file'],
                                'lineNumber' => $err['line'],
                                'functionName' => 'unknown'
                             ]
                        ],
                        'serviceContext' => [
                            'service' => $service,
                            'version' => $version
                        ]
                    ];
                    self::$batchLogger->log(self::getPsr3ErrorLevel($err['type']), $message, $context);
                    break;
            }
        }
    }
}
