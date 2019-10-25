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
namespace Google\Cloud\Core\Logger;

use Monolog\Formatter\LineFormatter;

/**
 * Monolog 1.x formatter for formatting logs on App Engine flexible environment.
 *
 * If you are using Monolog 2.x, use {@see \Google\Cloud\Core\Logger\AppEngineFlexFormatterV2} instead.
 */
class AppEngineFlexFormatter extends LineFormatter
{
    use FormatterTrait;

    /**
     * @param string $format [optional] The format of the message
     * @param string $dateFormat [optional] The format of the timestamp
     * @param bool $ignoreEmptyContextAndExtra [optional]
     */
    public function __construct($format = null, $dateFormat = null, $ignoreEmptyContextAndExtra = false)
    {
        parent::__construct($format, $dateFormat, true, $ignoreEmptyContextAndExtra);
    }

    /**
     * Get the plain text message with LineFormatter's format method and add
     * metadata including the trace id then return the json string.
     *
     * @param array $record A record to format
     * @return string The formatted record
     */
    public function format(array $record)
    {
        return $this->formatPayload($record, parent::format($record));
    }
}
