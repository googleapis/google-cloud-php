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

namespace Google\Cloud\Core\Testing;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\V1\Client\DatastoreClient;
use Prophecy\Argument;

/**
 * Refresh Datastore operation class
 *
 * @experimental
 * @internal
 */
trait DatastoreOperationRefreshTrait
{
    /**
     * Refresh the operation property of a given stubbed class.
     *
     * @param mixed $stub
     * @param ConnectionInterface $connection
     * @param RequestHandler $requestHandler
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $projectId the project id.
     *     @type bool $returnInt64AsObject if true, will encode int64s as objects.
     *     @type bool $encode whether to base64-encode certain values.
     * }
     * @return mixed
     */
    public function refreshOperation($stub, ConnectionInterface $connection, RequestHandler $requestHandler, array $options = [])
    {
        $options += [
            'projectId' => null,
            'returnInt64AsObject' => false,
            'encode' => false
        ];

        $mapper = new EntityMapper(
            $options['projectId'],
            $options['encode'],
            $options['returnInt64AsObject']
        );

        $serializer = new Serializer([], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [
            'google.protobuf.Timestamp' => function ($v) {
                if (is_string($v)) {
                    $dt = new \DateTime($v);
                    return ['seconds' => $dt->format('U')];
                }
                return $v;
            }
        ]);

        $stub->___setProperty('operation', new Operation(
            $connection,
            $requestHandler,
            $serializer,
            $options['projectId'],
            $options['returnInt64AsObject'],
            $mapper
        ));

        return $stub;
    }

    /**
     * Helper method for Unit and Snippet test classes. This mocks the
     * $requestHandler class property present in the Test Class with
     * given arguments.
     *
     * @param string $methodName The method name to mock in RequestHandler::sendRequest
     * @param array<string, mixed> $params The parameters to look for in the
     * array equivalent of rpc request.
     * @param mixed $returnValue The value to be returned by sendRequest mock.
     * @param null|int $shouldBeCalledTimes Adds a shouldBeCalled prophecy. Defaults to `null`, implying nothing is added.
     * [
     *      `0` => `shouldBeCalled`,
     *      Non zero positive integer $x => `shouldBeCalledTimes($x)`
     * ]
     */
    private function mockSendRequest($methodName, $params, $returnValue, $shouldBeCalledTimes = null)
    {
        if (isset($this->serializer)) {
            $serializer = $this->serializer;
        } else {
            $serializer = new Serializer([], [
                'google.protobuf.Value' => function ($v) {
                    return $this->flattenValue($v);
                },
                'google.protobuf.Timestamp' => function ($v) {
                    return $this->formatTimestampFromApi($v);
                }
            ], [], [
                'google.protobuf.Timestamp' => function ($v) {
                    if (is_string($v)) {
                        $dt = new \DateTime($v);
                        return ['seconds' => $dt->format('U')];
                    }
                    return $v;
                }
            ]);
        }

        $prophecy = $this->requestHandler->sendRequest(
            DatastoreClient::class,
            $methodName,
            Argument::that(function ($arg) use ($methodName, $params, $serializer) {
                $requestName = ucfirst($methodName . 'Request');
                $x = explode('\\', get_class($arg));
                $argName = end($x);

                if ($requestName != $argName) {
                    return false;
                }
                $data = $serializer->encodeMessage($arg);
                // $z = array_replace_recursive($data, $params) == $data;
                return array_replace_recursive($data, $params) == $data;
                // return array_merge($params, $data) == $data;
            }),
            Argument::cetera()
        );

        if (!is_null($shouldBeCalledTimes)) {
            if ($shouldBeCalledTimes == 0) {
                $prophecy->shouldBeCalled();
            } else {
                $prophecy->shouldBeCalledTimes($shouldBeCalledTimes);
            }
        }

        $prophecy->willReturn($returnValue);
    }
}
