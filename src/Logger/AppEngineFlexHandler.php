<?php
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
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
namespace Google\Cloud\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class for logging on App Engine flexible environment.
 */
class AppEngineFlexHandler extends StreamHandler
{
    /**
     * @param int $level The minimum logging level at which this handler will be triggered.
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not.
     * @param int|null $filePermission Optional file permissions (default (0640) are only for owner read/write).
     * @param Boolean $useLocking Try to lock log file before doing any writes.
     * @param resource|string|null $stream
     */
    public function __construct(
        $level = Logger::INFO,
        $bubble = true,
        $filePermission = 0640,
        $useLocking = false,
        $stream = null
    ) {
        if ($stream === null) {
            $pid = posix_getpid();
            $stream = "file:///var/log/app_engine/app.$pid.json";
        }
        parent::__construct(
            $stream,
            $level,
            $bubble,
            $filePermission,
            $useLocking
        );
    }

    /**
     * Get the default formatter.
     *
     * @return FormatterInterface
     */
    protected function getDefaultFormatter()
    {
        return new AppEngineFlexFormatter();
    }
}
