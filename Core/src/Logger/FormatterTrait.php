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

/**
 * Shared trait to enrich and format a record with
 * App Engine Flex specific information.
 */
trait FormatterTrait
{
    protected function formatPayload(array $record, $message)
    {
        list($usec, $sec) = explode(' ', microtime());
        $usec = (int)(((float)$usec)*1000000000);
        $sec = (int)$sec;

        $payload = [
            'message' => $message,
            'timestamp'=> ['seconds' => $sec, 'nanos' => $usec],
            'thread' => '',
            'severity' => $record['level_name'],
        ];

        if (isset($_SERVER['HTTP_X_CLOUD_TRACE_CONTEXT'])) {
            $payload['traceId'] = explode(
                '/',
                $_SERVER['HTTP_X_CLOUD_TRACE_CONTEXT']
            )[0];
        }

        return "\n" . json_encode($payload);
    }
}
