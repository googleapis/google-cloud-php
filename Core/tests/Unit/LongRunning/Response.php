<?php
/**
 * Copyright 2020 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\LongRunning;

class Response
{
    public $metadataType;
    public $metadata;
    public $responseType;
    public $response = null;
    public $error = null;

    public function __construct($metaType, $metadata, $respType = null, $response = null)
    {
        $this->metadataType = $metaType;
        $this->metadata = $metadata->serializeToString();
        $this->responseType = $respType;
        if (isset($response)) {
            $this->response = $response->serializeToString();
        }
    }

    public function getResponse()
    {
        return new Value($this->response);
    }

    public function getMetadata()
    {
        return new Value($this->metadata);
    }

    public function getDone()
    {
        return (isset($this->response) or isset($this->error));
    }

    public function getError()
    {
        return $this->error;
    }

    public function serializeToJsonString()
    {
        $result = [
            'done' => true,
            'metadata' => [
                'typeUrl' => $this->metadataType,
                'value' => $this->metadata,
            ],
        ];
        if (isset($this->response)) {
            $result['response'] = [
                'typeUrl' => $this->responseType,
                'value' => $this->response,
            ];
        }

        return json_encode($result);
    }
}
