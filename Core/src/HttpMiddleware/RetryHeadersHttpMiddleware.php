<?php
/*
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Core\HttpMiddleware;

use Google\ApiCore\AgentHeader;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

/**
 * Add the retry headers (invocation ID and count) to the retried request
 */
class RetryHeadersHttpMiddleware
{
    private int $currentAttempt = 0;
    private $nextHandler;

    public function __construct($nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, array $options)
    {
        // increment the current attempt
        $this->currentAttempt++;

        // add the retry headers
        $request = $this->addRetryHeaders($request, $options);

        // Call the next middleware
        $handler = $this->nextHandler;
        return $handler($request, $options);
    }

    /**
     * Adds the callback methods to $args which amends retry hash and attempt
     * count to the headers.
     * @param array $args
     *
     * @return array
     */
    private function addRetryHeaders(RequestInterface $request, array $options): RequestInterface
    {
        $agentHeader = $headers['headers'][AgentHeader::AGENT_HEADER_KEY]
            ?? $request->getHeaderLine(AgentHeader::AGENT_HEADER_KEY)
            ?: '';
        $agentHeaderParts = explode(' ', $agentHeader);

        $requestHash = Uuid::uuid4()->toString();
        $agentHeaderParts[] = sprintf('gccl-invocation-id/%s', $requestHash);
        $agentHeaderParts[] = sprintf('gccl-attempt-count/%s', $this->currentAttempt);

        return $request->withHeader(AgentHeader::AGENT_HEADER_KEY, implode(' ', $agentHeaderParts));
    }
}
