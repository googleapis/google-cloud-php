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
 * Trait providing setters for adding attributes to other models.
 */
trait AttributeTrait
{
    /**
     * @var Attributes
     */
    protected $attributes;

    /**
     * Attach labels to this span.
     *
     * @param array $labels Labels in the form of $label => $value
     */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->addAttribute($key, $value);
        }
    }

    /**
     * Attach a single label to this span.
     *
     * @param string $label The name of the label.
     * @param mixed $value The value of the label. Will be cast to a string
     */
    public function addAttribute($key, $value)
    {
        if (!$this->attributes) {
            $this->attributes = new Attributes();
        }

        $this->attributes[$key] = $value;
    }
}
