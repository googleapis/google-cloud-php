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
 * Set and get row values
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable;
 *
 * $cell = new Cell();
 *
 * $family = 'cf';
 * $cell->setFamily($family);
 * ```
 *
 */
class Cell
{
    /**
     * @var string
     */
    private $family;

    /**
     * @var string
     */
    private $qualifier;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $labels;

    /**
     * Set the family name.
     *
     * Example:
     * ```
     * $family = 'cf';
     * $cell->setFamily($family);
     * ```
     *
     * @param string $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }

    /**
     * Get the family name. It will return the family name.
     *
     * Example:
     * ```
     * $familyName = $cell->getFamily();
     * ```
     *
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set the Qualifier name.
     *
     * Example:
     * ```
     * $qualifier = 'qualifier';
     * $cell->setQualifier();
     * ```
     *
     * @param string $qualifier
     */
    public function setQualifier($qualifier)
    {
        $this->qualifier = $qualifier;
    }

    /**
     * Get the qualifier name. It will return the qualifier name.
     *
     * Example:
     * ```
     * $qualifier = $cell->getQualifier();
     * ```
     *
     * @return string
     */
    public function getQualifier()
    {
        return $this->qualifier;
    }

    /**
     * Set the Timestamp.
     *
     * Example:
     * ```
     * $timestamp = '';
     * $cell->setQualifier($timestamp);
     * ```
     *
     * @param integer $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Get the Timestamp. It will return the Timestamp.
     *
     * Example:
     * ```
     * $timestamp = $cell->getTimestamp();
     * ```
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    
    /**
     * Set the value.
     *
     * Example:
     * ```
     * $value = 'Val';
     * $cell->setValue($value);
     * ```
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value. It will return the value of row.
     *
     * Example:
     * ```
     * $value = $cell->getValue();
     * ```
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the label.
     *
     * Example:
     * ```
     * $label = '';
     * $cell->setValue($label);
     * ```
     *
     * @param string $label
     */
    public function setLabels($label)
    {
        $this->labels = $label;
    }

    /**
     * Get the label. It will return the label of row.
     *
     * Example:
     * ```
     * $label = $cell->getLabels();
     * ```
     *
     * @return string
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Concat values of cell in progress state rows.
     *
     * Example:
     * ```
     * $value = '';
     * $cell->appendValue($value);
     * ```
     *
     * @param string $value
     */
    public function appendValue($value)
    {
        $this->value = $this->value.$value;
    }
}
