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

use Google\Cloud\Core\ArrayTrait;

/**
 * This plain PHP class represents an MessageEvent resource.
 */
class MessageEvent extends TimeEvent
{
    use ArrayTrait;

    const TYPE_UNSPECIFIED = 'TYPE_UNSPECIFIED';
    const TYPE_SENT = 'SENT';
    const TYPE_RECEIVED = 'RECEIVED';

    private $type;

    private $id;

    private $uncompressedSizeBytes;

    private $compressedSizeBytes;

    public function __construct($id, $options = [])
    {
        $this->id = $id;
        $this->type = $this->pluck('type', $options, false) ?: self::TYPE_UNSPECIFIED;
        $this->uncompressedSizeBytes = $this->pluck('uncompressedSizeBytes', $options, false);
        $this->compressedSizeBytes = $this->pluck('compressedSizeBytes', $options, false);
    }

    public function jsonSerialize()
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type
        ];

        if ($this->uncompressedSizeBytes) {
            $data['uncompressedSizeBytes'] = $this->uncompressedSizeBytes;
        }
        if ($this->compressedSizeBytes) {
            $data['compressedSizeBytes'] = $this->compressedSizeBytes;
        }

        return $data;
    }
}
