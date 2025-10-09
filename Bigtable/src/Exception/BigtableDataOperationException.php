<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Exception;

/**
 * Exception thrown when a request fails.
 */
class BigtableDataOperationException extends \Exception
{
    /**
     * @var array
     */
    protected $metadata;

    /**
     * Handles previous exceptions differently here.
     *
     * @param string $message
     * @param int $code [optional]
     * @param array $metadata [optional] Exception metadata.
     */
    public function __construct(
        $message,
        $code = null,
        array $metadata = []
    ) {
        $this->metadata = $metadata;

        parent::__construct($message, $code ?? 0);
    }

    /**
     * Gets exception metadata.
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
