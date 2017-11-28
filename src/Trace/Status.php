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
 * This plain PHP class represents an Status resource. The Status type defines a
 * logical error model that is suitable for different programming environments,
 * including REST APIs and RPC APIs
 */
class Status implements \JsonSerializable
{
    use ArrayTrait;

    /**
     * @var int The status code, which should be an enum value of google.rpc.Code.
     */
    private $code;

    /**
     * @var string A developer-facing error message, which should be in English.
     *      Any user-facing error message should be localized and sent in the
     *      google.rpc.Status.details field, or localized by the client.
     */
    private $message;

    /**
     * @var array A list of messages that carry the error details. There is a
     * common set of message types for APIs to use. An object containing fields
     * of an arbitrary type. An additional field "@type" contains a URI
     * identifying the type.
     *
     * Example: { "id": 1234, "@type": "types.example.com/standard/id" }.
     */
    private $details;

    /**
     * Create a new Status.
     *
     * @param string $description A user-supplied message describing the event.
     *        The maximum length for the description is 256 bytes.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->code = $this->pluck('code', $options);
        $this->message = $this->pluck('message', $options);
        $this->details = $this->pluck('details', $options, false) ?: [];
    }

    /**
     * Returns a serializable array representing this Link.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'code' => $this->code,
            'message' => $this->message
        ];
        if ($this->details) {
            $data['details'] = $this->details;
        }

        return $data;
    }
}
