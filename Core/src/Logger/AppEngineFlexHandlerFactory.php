<?php
/*
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Google\Cloud\Core\Logger;

use Exception;
use Monolog\Logger;

/**
 * Factory to build out an AppEngineFlexHandler for the installed version of Monolog.
 */
class AppEngineFlexHandlerFactory
{
    /**
     * Builds out an AppEngineFlexHandler for the installed version of Monolog.
     *
     * @param int $level [optional] The minimum logging level at which this
     *        handler will be triggered.
     * @param Boolean $bubble [optional] Whether the messages that are handled
     *        can bubble up the stack or not.
     * @param int|null $filePermission [optional] Optional file permissions
     *        (default (0640) are only for owner read/write).
     * @param Boolean $useLocking [optional] Try to lock log file before doing
     *        any writes.
     * @param resource|string|null $stream [optional]
     *
     * @throws Exception
     *
     * @return AppEngineFlexHandler|AppEngineFlexHandlerV2
     */
    public static function build(
        $level = Logger::INFO,
        $bubble = true,
        $filePermission = 0640,
        $useLocking = false,
        $stream = null
    ) {
        $version = defined('Monolog\Logger::API') ? Logger::API : 1;

        switch ($version) {
            case 1:
                return new AppEngineFlexHandler($level, $bubble, $filePermission, $useLocking, $stream);
            case 2:
                return new AppEngineFlexHandlerV2($level, $bubble, $filePermission, $useLocking, $stream);
            default:
                throw new Exception('Version not supported');
        }
    }
}
