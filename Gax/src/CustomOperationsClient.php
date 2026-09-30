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
use Google\LongRunning\Operation;
use Google\Rpc\Code;
use Google\Rpc\Status;
use LogicException;

/**
 * Adapter that wraps a custom operations client (e.g. Compute's ZoneOperationsClient)
 * to implement {@see OperationsClientInterface} and normalize custom operation messages
 * into {@see Operation}.
 */
class CustomOperationsClient implements OperationsClientInterface
{
    private const CUSTOM_OPTION_KEYS = [
        'getOperationMethod',
        'cancelOperationMethod',
        'deleteOperationMethod',
        'getOperationRequest',
        'cancelOperationRequest',
        'deleteOperationRequest',
        'additionalOperationArguments',
        'operationNameMethod',
        'operationStatusMethod',
        'operationStatusDoneValue',
        'operationErrorCodeMethod',
        'operationErrorMessageMethod',
    ];

    private object $client;
    private array $additionalArgs;
    private string $getOperationMethod;
    private ?string $cancelOperationMethod;
    private ?string $deleteOperationMethod;
    private string $getOperationRequest;
    private ?string $cancelOperationRequest;
    private ?string $deleteOperationRequest;
    private string $operationNameMethod;
    private string $operationStatusMethod;
    private mixed $operationStatusDoneValue;
    private ?string $operationErrorCodeMethod;
    private ?string $operationErrorMessageMethod;

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
            'operationNameMethod' => 'getName',
            'operationStatusMethod' => 'getDone',
            'operationStatusDoneValue' => true,
            'operationErrorCodeMethod' => null,
            'operationErrorMessageMethod' => null,
        ];

        $this->getOperationMethod = $options['getOperationMethod'];
        $this->cancelOperationMethod = $options['cancelOperationMethod'];
        $this->deleteOperationMethod = $options['deleteOperationMethod'];
        $this->getOperationRequest = $options['getOperationRequest'];
        $this->cancelOperationRequest = $options['cancelOperationRequest'];
        $this->deleteOperationRequest = $options['deleteOperationRequest'];
        $this->additionalArgs = $options['additionalOperationArguments'];
        $this->operationNameMethod = $options['operationNameMethod'];
        $this->operationStatusMethod = $options['operationStatusMethod'];
        $this->operationStatusDoneValue = $options['operationStatusDoneValue'];
        $this->operationErrorCodeMethod = $options['operationErrorCodeMethod'];
        $this->operationErrorMessageMethod = $options['operationErrorMessageMethod'];
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

    public function getOperation(GetOperationRequest $request, array $callOptions = []): Operation
    {
        $response = $this->operationsCall(
            $this->getOperationMethod,
            $this->getOperationRequest,
            $request->getName(),
            $callOptions
        );

        return $this->toOperation($response);
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

    public function toOperation(?object $response): Operation
    {
        if (is_null($response)) {
            return new Operation();
        }

        if ($response instanceof Operation) {
            return $response;
        }

        $operation = new Operation();
        if (method_exists($response, $this->operationNameMethod)) {
            $name = $response->{$this->operationNameMethod}();
            if (is_string($name)) {
                $operation->setName($name);
            }
        }

        if (!method_exists($response, $this->operationStatusMethod)) {
            return $operation;
        }

        $status = $response->{$this->operationStatusMethod}();
        $done = !is_null($status) && $status === $this->operationStatusDoneValue;
        $operation->setDone($done);

        if ($this->operationErrorCodeMethod || $this->operationErrorMessageMethod) {
            $errorCode = $this->operationErrorCodeMethod
                ? $response->{$this->operationErrorCodeMethod}()
                : null;
            if (!empty($errorCode)) {
                $errorMessage = $this->operationErrorMessageMethod
                    ? $response->{$this->operationErrorMessageMethod}()
                    : '';
                $operation->setError(
                    (new Status())
                        ->setCode(ApiStatus::rpcCodeFromHttpStatusCode($errorCode))
                        ->setMessage((string) $errorMessage)
                );
            }
        } elseif (method_exists($response, 'getError')) {
            $error = $response->getError();
            if (!empty($error)) {
                $operation->setError(
                    $error instanceof Status ? $error : (new Status())->setCode(Code::UNKNOWN)
                );
            }
        } elseif ($done) {
            throw new LogicException('Unable to determine operation error status for this service');
        }

        return $operation;
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
