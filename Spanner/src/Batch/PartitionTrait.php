<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Batch;

/**
 * Common methods for Partitions
 */
trait PartitionTrait
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $options;

    /**
     * Returns the partition token.
     *
     * Example:
     * ```
     * $token = $partition->token();
     * ```
     *
     * @return string
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * Returns the partition options.
     *
     * Example:
     * ```
     * $options = $partition->options();
     * ```
     *
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Cast the partition to a string.
     *
     * @access private
     * @return string
     */
    public function __toString()
    {
        return $this->serialize();
    }
}
