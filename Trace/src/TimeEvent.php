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

namespace Google\Cloud\Trace;

/**
 * An abstract class that represents a TimeEvent resource.
 *
 * @see https://cloud.google.com/trace/docs/reference/v2/rest/v2/TimeEvents#timeevent TimeEvent model documentation
 */
abstract class TimeEvent
{
    use TimestampTrait;

    /**
     * @var \DateTimeInterface The time of the event.
     */
    protected $time;

    /**
     * Create a new TimeEvent.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type \DateTimeInterface|int|float|string $time The event time.
     */
    public function __construct(array $options = [])
    {
        if (array_key_exists('time', $options)) {
            $this->time = $this->formatDate($options['time']);
        } else {
            $this->time = $this->formatDate();
        }
    }
}
