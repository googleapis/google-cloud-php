<?php
/**
 * Copyright 2019 Google LLC
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
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Creates stubs with required global expectations.
 */
trait StubCreationTrait
{
    use ProphecyTrait;

    private function getConnStub()
    {
        $c = $this->prophesize(ConnectionInterface::class);
        $c->deleteSession(Argument::any())->willReturn([]);

        return $c;
    }

    private function getRequestHandlerStub()
    {
        $handler = $this->prophesize(RequestHandler::class);
        $handler->sendRequest(
            SpannerClient::class,
            'deleteSession',
            Argument::cetera()
        )->willReturn([[]]);
        return $handler;
    }

    private function getSerializerStub()
    {
        $serializer = $this->prophesize(Serializer::class);
        $serializer->decodeMessage(
            Argument::type(DeleteSessionRequest::class),
            Argument::cetera()
        )->willReturn(new DeleteSessionRequest());
        // All the serializer decode may not be mocked.
        $serializer->decodeMessage(
            Argument::cetera()
        )->willReturn(null);
        return $serializer;
    }
}
