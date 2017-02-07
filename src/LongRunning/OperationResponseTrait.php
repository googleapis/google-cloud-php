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

namespace Google\Cloud\LongRunning;

use DrSlump\Protobuf\CodecInterface;
use Google\GAX\OperationResponse;

/**
 * Serializes and deserializes GAX LRO Response objects.
 */
trait OperationResponseTrait
{
    private function operationToArray(OperationResponse $operation, CodecInterface $codec)
    {
        $response = $operation->getLastProtoResponse();
        if (is_null($response)) {
            return null;
        }

        $response = $response->serialize($codec);
        $result = $operation->getResult();
        if (!is_null($result)) {
            $result = $result->serialize($codec);
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
     * @param array $clients A list of gRPC Clients with LRO support.
     * @param string $name The Operation name.
     * @param string $method The method which created the Operation.
     * @return OperationResponse
     */
    private function getOperationByNameAndMethod(array $clients, $name, $method)
    {
        $client = null;
        foreach ($clients as $client) {
            if (!method_exists($client, 'getLongRunningDescriptors')) {
                throw new \BadMethodCallException(sprintf(
                    'Given client %s does not have a method called `getLongRunningDescriptors`.',
                    get_class($client)
                ));
            }

            if (array_key_exists($method, $client::getLongRunningDescriptors())) {
                break;
            } else {
                $client = null;
            }
        }

        if (is_null($client)) {
            throw new \BadMethodCallException('Invalid LRO method');
        }

        return $client->resumeOperation($name, $method);
    }
}
