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
 * This plain PHP class represents an Annotation resource. Text annotation with
 * a set of attributes.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Annotation;
 *
 * $annotation = new Annotation('some note');
 * $span->addTimeEvent($annotation);
 * ```
 *
 * @see https://cloud.google.com/trace/docs/reference/v2/rest/v2/TimeEvents#annotation Annotation model documentation
 */
class Annotation extends TimeEvent
{
    use AttributeTrait;

    /**
     * @var string A user-supplied message describing the event. The maximum
     *      length for the description is 256 bytes.
     */
    private $description;

    /**
     * Create a new Annotation.
     *
     * @param string $description A user-supplied message describing the event.
     *        The maximum length for the description is 256 bytes.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $attributes A set of attributes on the annotation. You
     *           can have up to 4 attributes per Annotation.
     * }
     */
    public function __construct($description, array $options = [])
    {
        parent::__construct($options);
        $this->description = $description;
        if (array_key_exists('attributes', $options)) {
            $this->addAttributes($options['attributes']);
        }
    }

    /**
     * Returns a serializable array representing this Link.
     *
     * @access private
     * @return array
     */
    public function info()
    {
        $data = [
            'description' => [
                'value' => $this->description
            ]
        ];
        if ($this->attributes) {
            $data['attributes'] = $this->attributes->info();
        }

        return [
            'time' => $this->time,
            'annotation' => $data
        ];
    }
}
