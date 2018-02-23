<?php
/*
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Bigtable;

/**
*
*/
class Cell
{
    private $family;
    private $qualifier;
    private $timestamp;
    private $value;
    private $labels;

    /**
     * @param string $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }

    /**
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param string $qualifier
     */
    public function setQualifier($qualifier)
    {
        $this->qualifier = $qualifier;
    }

    /**
     * @return string
     */
    public function getQualifier()
    {
        return $this->qualifier;
    }

    /**
     * @param integer $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $label
     */
    public function setLabels($label)
    {
        $this->labels = $label;
    }

    /**
     * @return string
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Concat value
     * @param string $value
     */
    public function appendValue($value)
    {
        $this->value = $this->value.$value;
    }
}
