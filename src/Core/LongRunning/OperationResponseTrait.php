<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\LongRunning;

use DrSlump\Protobuf\CodecInterface;
use Google\GAX\OperationResponse;

/**
 * Serializes and deserializes GAX LRO Response objects.
 */
trait OperationResponseTrait
{
    private function operationToArray(OperationResponse $operation, CodecInterface $codec, array $lroMappers)
    {
        $response = $operation->getLastProtoResponse();
        if (is_null($response)) {
            return null;
        }

        $response = $response->serialize($codec);

        $result = null;
        if ($operation->isDone()) {
            $type = $response['metadata']['typeUrl'];
            $result = $this->deserializeResult($operation, $type, $codec, $lroMappers);
        }

        $error = $operation->getError();
        if (!is_null($error)) {
            $error = $error->serialize($codec);
        }

        $response['response'] = $result;
        $response['error'] = $error;

        return $response;
    }

    /**
     * @param mixed $client A generated client with a `resumeOperation` method.
     * @param string $name The Operation name.
     * @return OperationResponse
     */
    private function getOperationByName($client, $name)
    {
        return $client->resumeOperation($name);
    }

    private function deserializeResult($operation, $type, $codec, $mappers)
    {
        $mappers = array_filter($mappers, function ($mapper) use ($type) {
            return $mapper['typeUrl'] === $type;
        });

        if (count($mappers) === 0) {
            throw new \RuntimeException(sprintf('No mapper exists for operation response type %s.', $type));
        }

        $mapper = current($mappers);
        $message = $mapper['message'];

        $response = new $message();
        $anyResponse = $operation->getLastProtoResponse()->getResponse();

        if (is_null($anyResponse)) {
            return null;
        }

        $response->parse($anyResponse->getValue());

        return $response->serialize($codec);
    }
}
