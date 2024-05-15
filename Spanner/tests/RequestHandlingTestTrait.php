<?php
/**
 * Copyright 2024 Google LLC
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

namespace Google\Cloud\Spanner\Tests;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Creates stubs and objects with required global expectations.
 */
trait RequestHandlingTestTrait
{
    use ProphecyTrait;

    private function getRequestHandlerStub()
    {
        return $this->prophesize(RequestHandler::class);
    }

    private function mockSendRequest(
        string $clientClass,
        string $method,
        ?callable $requestCondition,
        mixed $response,
        int $timesCalled = 1,
        ?callable $optionalArrayCondition = null
    ) {
        if (is_null($requestCondition)) {
            $requestCondition = function ($args) {
                return true;
            };
        }
        if (is_null($optionalArrayCondition)) {
            $optionalArrayCondition = function ($args) {
                return true;
            };
        }

        $handler = $this->requestHandler
            ->sendRequest(
                $clientClass,
                $method,
                Argument::that($requestCondition),
                Argument::that($optionalArrayCondition)
            )
            ->willReturn($response);
        if ($timesCalled >= 0) {
            $handler->shouldBeCalledTimes($timesCalled);
        }
    }

    private function getSerializer()
    {
        return new Serializer([], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ]);
    }
}
