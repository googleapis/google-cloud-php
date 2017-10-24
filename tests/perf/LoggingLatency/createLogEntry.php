<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require 'vendor/autoload.php';

use Google\Cloud\Core\GrpcTrait;
use Google\GAX\Serializer;
use Google\Logging\V2\LogEntry;
use Google\Logging\V2\LogSink_VersionFormat;

/**
 * Implementation of the
 * [Google Stackdriver Logging gRPC API](https://cloud.google.com/logging/docs/).
 */
class createLogEntry
{
    use GrpcTrait;

    private static $versionFormatMap = [
        LogSink_VersionFormat::VERSION_FORMAT_UNSPECIFIED => 'VERSION_FORMAT_UNSPECIFIED',
        LogSink_VersionFormat::V1 => 'V1',
        LogSink_VersionFormat::V2 => 'V2'
      ];


    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([
            'timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'severity' => function ($v) {
                return Logger::getLogLevelMap()[$v];
            },
            'output_version_format' => function ($v) {
                return self::$versionFormatMap[$v];
            },
            'json_payload' => function ($v) {
                return $this->unpackStructFromApi($v);
            }
        ]);
    }
   /**
     * @param array $entry
     * @return LogEntry
     */
    public function buildEntry(array $entry)
    {
        if (isset($entry['jsonPayload'])) {
            $entry['jsonPayload'] = $this->formatStructForApi($entry['jsonPayload']);
        }

        if (isset($entry['timestamp'])) {
            $entry['timestamp'] = $this->formatTimestampForApi($entry['timestamp']);
        } else {
            unset($entry['timestamp']);
        }

        if (isset($entry['severity']) && is_string($entry['severity'])) {
            $entry['severity'] = array_flip(Logger::getLogLevelMap())[strtoupper($entry['severity'])];
        }

        return $this->serializer->decodeMessage(new LogEntry(), $entry);
    }
}
