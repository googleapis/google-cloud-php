<?php

namespace Google\Cloud\ErrorReporting;

use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\PsrLogger;

/**
 * Static methods for bootstrapping Stackdriver Error Reporting.
 */
class Bootstrap
{
    const DEFAULT_LOGNAME = 'app-error';

    /** @var PsrLogger */
    public static $psrLogger;

    /**
     * Register hooks for error reporting.
     *
     * @param PsrLogger $psrLogger
     * @return void
     * @codeCoverageIgnore
     */
    public static function init(PsrLogger $psrLogger = null)
    {
        self::$psrLogger = $psrLogger ?: (new LoggingClient())
            ->psrLogger(self::DEFAULT_LOGNAME, [
                'batchEnabled' => true,
                'debugOutput' => true,
                'batchOptions' => [
                    'workerNum' => 2
                ]
            ]);
        register_shutdown_function([self::class, 'shutdownHandler']);
        set_exception_handler([self::class, 'exceptionHandler']);
        set_error_handler([self::class, 'errorHandler']);
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
     * Return an error level string for the given PHP error level.
     *
     * @param int $level
     * @return string An error level string.
     */
    public static function getErrorLevelString($level)
    {
        switch ($level) {
            case E_PARSE:
                return 'CRITICAL';
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                return 'ERROR';
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                return 'WARNING';
            case E_NOTICE:
            case E_USER_NOTICE:
                return 'NOTICE';
            case E_STRICT:
                return 'DEBUG';
            default:
                return 'NOTICE';
        }
        return $prefix;
    }

    /**
     * @param mixed $ex \Throwable (PHP 7) or \Exception (PHP 5)
     */
    public static function exceptionHandler($ex)
    {
        $message = sprintf('PHP Notice: %s', (string)$ex);
        if (self::$psrLogger) {
            $service = self::$psrLogger->getMetadataProvider()->serviceId();
            $version = self::$psrLogger->getMetadataProvider()->versionId();
            self::$psrLogger->error($message, [
                'serviceContext' => [
                    'service' => $service,
                    'version' => $version,
                ]
            ]);
        } else {
            fwrite(STDERR, $message . PHP_EOL);
        }
    }

    /**
     * @param int $level The error level.
     * @param string $message The error message.
     * @param string $file The filename that the error was raised in.
     * @param int $line The line number that the error was raised at.
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (!($level & error_reporting())) {
            return true;
        }
        $message =  sprintf(
            '%s: %s in %s on line %d',
            self::getErrorPrefix($level),
            $message,
            $file,
            $line
        );
        if (!self::$psrLogger) {
            return false;
        }
        $service = self::$psrLogger->getMetadataProvider()->serviceId();
        $version = self::$psrLogger->getMetadataProvider()->versionId();
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
        self::$psrLogger->log(
            self::getErrorLevelString($level),
            $message,
            $context
        );
    }

    /**
     * Called at exit, to check there's a fatal error and report the error if
     * any.
     */
    public static function shutdownHandler()
    {
        if ($err = error_get_last()) {
            switch ($err['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_COMPILE_ERROR:
                case E_CORE_ERROR:
                    $service = self::$psrLogger
                        ->getMetadataProvider()
                        ->serviceId();
                    $version = self::$psrLogger
                        ->getMetadataProvider()
                        ->versionId();
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
                    if (self::$psrLogger) {
                        self::$psrLogger->log(
                            self::getErrorLevelString($err['type']),
                            $message,
                            $context
                        );
                    }
                    break;
            }
        }
    }
}
