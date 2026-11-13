<?php
declare(strict_types=1);

/*
 * Copyright 2026 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore;

use Google\LongRunning\CancelOperationRequest;
use Google\LongRunning\DeleteOperationRequest;
use Google\LongRunning\GetOperationRequest;
use Google\Protobuf\Internal\Message;
use LogicException;

/**
 * Adapter that wraps a custom operations client (e.g. Compute's ZoneOperationsClient)
 * to implement {@see \Google\ApiCore\OperationsClientWrapperInterface}.
 */
class CustomOperationsClient implements OperationsClientWrapperInterface
{
    private const CUSTOM_OPTION_KEYS = [
        'getOperationMethod',
        'cancelOperationMethod',
        'deleteOperationMethod',
        'getOperationRequest',
        'cancelOperationRequest',
        'deleteOperationRequest',
        'additionalOperationArguments',
    ];

    private object $client;
    private array $additionalArgs;
    private string $getOperationMethod;
    private ?string $cancelOperationMethod;
    private ?string $deleteOperationMethod;
    private string $getOperationRequest;
    private ?string $cancelOperationRequest;
    private ?string $deleteOperationRequest;

    public function __construct(object $client, array $options = [])
    {
        $this->client = $client;
        $options += [
            'getOperationMethod' => 'getOperation',
            'cancelOperationMethod' => 'cancelOperation',
            'deleteOperationMethod' => 'deleteOperation',
            'getOperationRequest' => GetOperationRequest::class,
            'cancelOperationRequest' => CancelOperationRequest::class,
            'deleteOperationRequest' => DeleteOperationRequest::class,
            'additionalOperationArguments' => [],
        ];

        $this->getOperationMethod = $options['getOperationMethod'];
        $this->cancelOperationMethod = $options['cancelOperationMethod'];
        $this->deleteOperationMethod = $options['deleteOperationMethod'];
        $this->getOperationRequest = $options['getOperationRequest'];
        $this->cancelOperationRequest = $options['cancelOperationRequest'];
        $this->deleteOperationRequest = $options['deleteOperationRequest'];
        $this->additionalArgs = $options['additionalOperationArguments'];
    }

    public static function hasCustomOptions(array $options): bool
    {
        foreach (self::CUSTOM_OPTION_KEYS as $key) {
            if (array_key_exists($key, $options)) {
                return true;
            }
        }

        return false;
    }

    public function getOperation(GetOperationRequest $request, array $callOptions = []): Message
    {
        return $this->operationsCall(
            $this->getOperationMethod,
            $this->getOperationRequest,
            $request->getName(),
            $callOptions
        );
    }

    public function cancelOperation(CancelOperationRequest $request, array $callOptions = []): void
    {
        if (is_null($this->cancelOperationMethod) || is_null($this->cancelOperationRequest)) {
            throw new LogicException('The cancel operation is not supported by this API');
        }

        $this->operationsCall(
            $this->cancelOperationMethod,
            $this->cancelOperationRequest,
            $request->getName(),
            $callOptions
        );
    }

    public function deleteOperation(DeleteOperationRequest $request, array $callOptions = []): void
    {
        if (is_null($this->deleteOperationMethod) || is_null($this->deleteOperationRequest)) {
            throw new LogicException('The delete operation is not supported by this API');
        }

        $this->operationsCall(
            $this->deleteOperationMethod,
            $this->deleteOperationRequest,
            $request->getName(),
            $callOptions
        );
    }

    public function getOperationsClient(): object
    {
        return $this->client;
    }

    private function operationsCall(
        string $method,
        string $requestClass,
        string $operationName,
        array $callOptions = []
    ): mixed {
        if (!method_exists($requestClass, 'build')) {
            throw new LogicException('Request class must support the static build method');
        }

        // In Compute, the Request "build" methods contain the operation ID last instead
        // of first. Compute is the only API which uses $additionalArgs, so switching the order
        // will not break anything.
        $request = $requestClass::build(...array_merge(
            array_values($this->additionalArgs),
            [$operationName]
        ));

        if ($callOptions) {
            return $this->client->$method($request, $callOptions);
        }

        return $this->client->$method($request);
    }
}
