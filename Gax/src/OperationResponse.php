<?php
declare(strict_types=1);

/*
 * Copyright 2016 Google LLC
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
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\DeleteOperationRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\Internal\Message;
use Google\Rpc\Status;
use LogicException;

/**
 * Response object from a long running API method.
 *
 * The OperationResponse object is returned by API methods that perform
 * a long running operation. It provides methods that can be used to
 * poll the status of the operation, retrieve the results, and cancel
 * the operation.
 *
 * To support a long running operation, the server must implement the
 * Operations API, which is used by the OperationResponse object. If
 * more control is required, it is possible to make calls against the
 * Operations API directly instead of via the OperationResponse object
 * using an Operations Client instance.
 *
 * @template T = mixed
 */
class OperationResponse
{
    use PollingTrait;

    const DEFAULT_POLLING_INTERVAL = 1000;
    const DEFAULT_POLLING_MULTIPLIER = 2;
    const DEFAULT_MAX_POLLING_INTERVAL = 60000;
    const DEFAULT_MAX_POLLING_DURATION = 0;

    private string $operationName;
    private OperationsClient|OperationsClientInterface $operationsClient;

    private ?string $operationReturnType;
    private ?string $metadataReturnType;
    private array $defaultPollSettings = [
        'initialPollDelayMillis' => self::DEFAULT_POLLING_INTERVAL,
        'pollDelayMultiplier' => self::DEFAULT_POLLING_MULTIPLIER,
        'maxPollDelayMillis' => self::DEFAULT_MAX_POLLING_INTERVAL,
        'totalPollTimeoutMillis' => self::DEFAULT_MAX_POLLING_DURATION,
    ];

    private ?Operation $lastProtoResponse;
    private bool $deleted = false;

    /**
     * OperationResponse constructor.
     *
     * @param string $operationName
     * @param OperationsClient|OperationsClientInterface|object $operationsClient
     * @param array $options {
     *                       Optional. Options for configuring the operation response object.
     *
     *     @type string $operationReturnType The return type of the longrunning operation.
     *     @type string $metadataReturnType The type of the metadata returned in the operation response.
     *     @type int $initialPollDelayMillis    The initial polling interval to use, in milliseconds.
     *     @type int $pollDelayMultiplier Multiplier applied to the polling interval on each retry.
     *     @type int $maxPollDelayMillis The maximum polling interval to use, in milliseconds.
     *     @type int $totalPollTimeoutMillis The maximum amount of time to continue polling.
     *     @type Operation|object $lastProtoResponse A response already received from the server.
     *     @type string $getOperationMethod The method on $operationsClient to get the operation.
     *     @type string $cancelOperationMethod The method on $operationsClient to cancel the operation.
     *     @type string $deleteOperationMethod The method on $operationsClient to delete the operation.
     *     @type string $operationStatusMethod The method on the operation to get the status.
     *     @type mixed $operationStatusDoneValue The value on the operation indicating status is done.
     *     @type array $additionalOperationArguments Additional arguments to pass to $operationsClient methods.
     *     @type string $operationErrorCodeMethod The method on the operation to get the error code
     *     @type string $operationErrorMessageMethod The method on the operation to get the error status
     * }
     */
    public function __construct(
        string $operationName,
        object $operationsClient,
        array $options = []
    ) {
        $this->operationName = $operationName;
        $isStandardClient = $operationsClient instanceof OperationsClient
            || $operationsClient instanceof OperationsClientInterface;
        if (!$isStandardClient || CustomOperationsClient::hasCustomOptions($options)) {
            $operationsClient = new CustomOperationsClient($operationsClient, $options);
        }
        $this->operationsClient = $operationsClient;
        $this->operationReturnType = $options['operationReturnType'] ?? null;
        $this->metadataReturnType = $options['metadataReturnType'] ?? null;

        $lastProtoResponse = $options['lastProtoResponse'] ?? null;
        if ($lastProtoResponse !== null && !$lastProtoResponse instanceof Operation) {
            $customClient = $this->operationsClient instanceof CustomOperationsClient
                ? $this->operationsClient
                : new CustomOperationsClient($this->operationsClient, $options);
            $lastProtoResponse = $customClient->toOperation($lastProtoResponse);
        }
        $this->lastProtoResponse = $lastProtoResponse;

        if (isset($options['initialPollDelayMillis'])) {
            $this->defaultPollSettings['initialPollDelayMillis'] = $options['initialPollDelayMillis'];
        }
        if (isset($options['pollDelayMultiplier'])) {
            $this->defaultPollSettings['pollDelayMultiplier'] = $options['pollDelayMultiplier'];
        }
        if (isset($options['maxPollDelayMillis'])) {
            $this->defaultPollSettings['maxPollDelayMillis'] = $options['maxPollDelayMillis'];
        }
        if (isset($options['totalPollTimeoutMillis'])) {
            $this->defaultPollSettings['totalPollTimeoutMillis'] = $options['totalPollTimeoutMillis'];
        }
    }

    /**
     * Check whether the operation has completed.
     *
     * @return bool
     */
    public function isDone(): bool
    {
        return (bool) $this->lastProtoResponse?->getDone();
    }

    /**
     * Check whether the operation completed successfully. If the operation is not complete, or if the operation
     * failed, return false.
     *
     * @return bool
     */
    public function operationSucceeded(): bool
    {
        return $this->isDone() && !$this->operationFailed();
    }

    /**
     * Check whether the operation failed. If the operation is not complete, or if the operation
     * succeeded, return false.
     *
     * @return bool
     */
    public function operationFailed(): bool
    {
        return !is_null($this->lastProtoResponse?->getError());
    }

    /**
     * Get the formatted name of the operation
     *
     * @return string The formatted name of the operation
     */
    public function getName(): string
    {
        return $this->operationName;
    }

    /**
     * Poll the server in a loop until the operation is complete.
     *
     * Return true if the operation completed, otherwise return false. If the
     * $options['totalPollTimeoutMillis'] setting is not set (or set <= 0) then
     * pollUntilComplete will continue polling until the operation completes,
     * and therefore will always return true.
     *
     * @param array $options {
     *                       Options for configuring the polling behaviour.
     *
     *     @type int $initialPollDelayMillis The initial polling interval to use, in milliseconds.
     *     @type int $pollDelayMultiplier    Multiplier applied to the polling interval on each retry.
     *     @type int $maxPollDelayMillis     The maximum polling interval to use, in milliseconds.
     *     @type int $totalPollTimeoutMillis The maximum amount of time to continue polling, in milliseconds.
     * }
     * @throws ApiException If an API call fails.
     * @throws ValidationException
     * @return bool Indicates if the operation completed.
     */
    public function pollUntilComplete(array $options = []): bool
    {
        if ($this->isDone()) {
            return true;
        }

        $pollSettings = array_merge($this->defaultPollSettings, $options);
        return $this->poll(function () {
            $this->reload();
            return $this->isDone();
        }, $pollSettings);
    }

    /**
     * Reload the status of the operation with a request to the service.
     *
     * @throws ApiException If the API call fails.
     * @throws ValidationException If called on a deleted operation.
     */
    public function reload(): void
    {
        if ($this->deleted) {
            throw new ValidationException('Cannot call reload() on a deleted operation');
        }

        $request = GetOperationRequest::build($this->getName());
        $this->lastProtoResponse = $this->operationsClient->getOperation($request);
    }

    /**
     * Return the result of the operation. If operationSucceeded() is false,
     * return null.
     *
     * @return T|null
     */
    public function getResult(): mixed
    {
        if (!$this->operationSucceeded()) {
            return null;
        }

        /** @var Any|null $anyResponse */
        $anyResponse = $this->lastProtoResponse?->getResponse();
        if (is_null($anyResponse)) {
            return null;
        }
        if (is_null($this->operationReturnType)) {
            return $anyResponse;
        }
        $operationReturnType = $this->operationReturnType;
        /** @var Message $response */
        $response = new $operationReturnType();
        $response->mergeFromString($anyResponse->getValue());
        return $response;
    }

    /**
     * If the operation failed, return the status. If operationFailed() is false, return null.
     *
     * @return Status|null The status of the operation in case of failure, or null if
     *                                 operationFailed() is false.
     */
    public function getError(): ?Status
    {
        if (!$this->isDone()) {
            return null;
        }

        return $this->lastProtoResponse?->getError();
    }

    /**
     * Get an array containing the values of 'operationReturnType', 'metadataReturnType', and
     * the polling options `initialPollDelayMillis`, `pollDelayMultiplier`, `maxPollDelayMillis`,
     * and `totalPollTimeoutMillis`. The array can be passed as the $options argument to the
     * constructor when creating another OperationResponse object.
     *
     * @return array
     */
    public function getDescriptorOptions(): array
    {
        return [
            'operationReturnType' => $this->operationReturnType,
            'metadataReturnType' => $this->metadataReturnType,
        ] + $this->defaultPollSettings;
    }

    /**
     * @return Operation|null The last Operation object received from the server.
     */
    public function getLastProtoResponse(): ?Operation
    {
        return $this->lastProtoResponse;
    }

    /**
     * @return OperationsClient|OperationsClientInterface The OperationsClient object used to make
     * requests to the operations API.
     */
    public function getOperationsClient(): OperationsClient|OperationsClientInterface
    {
        return $this->operationsClient;
    }

    /**
     * Cancel the long-running operation.
     *
     * For operations of type Google\LongRunning\Operation, this method starts
     * asynchronous cancellation on a long-running operation. The server
     * makes a best effort to cancel the operation, but success is not
     * guaranteed. If the server doesn't support this method, it will throw an
     * ApiException with code \Google\Rpc\Code::UNIMPLEMENTED. Clients can continue
     * to use reload and pollUntilComplete methods to check whether the cancellation
     * succeeded or whether the operation completed despite cancellation.
     * On successful cancellation, the operation is not deleted; instead, it becomes
     * an operation with a getError() value with a \Google\Rpc\Status code of 1,
     * corresponding to \Google\Rpc\Code::CANCELLED.
     *
     * @throws ApiException If the API call fails.
     * @throws LogicException If the API call method has not been configured
     */
    public function cancel(): void
    {
        $request = CancelOperationRequest::build($this->getName());
        $this->operationsClient->cancelOperation($request);
    }

    /**
     * Delete the long-running operation.
     *
     * For operations of type Google\LongRunning\Operation, this method
     * indicates that the client is no longer interested in the operation result.
     * It does not cancel the operation. If the server doesn't support this method,
     * it will throw an ApiException with code \Google\Rpc\Code::UNIMPLEMENTED.
     *
     * @throws ApiException If the API call fails.
     * @throws LogicException If the API call method has not been configured
     */
    public function delete(): void
    {
        $request = DeleteOperationRequest::build($this->getName());
        $this->operationsClient->deleteOperation($request);
        $this->deleted = true;
    }

    /**
     * Get the metadata returned with the last proto response. If a metadata type was provided, then
     * the return value will be of that type - otherwise, the return value will be of type Any. If
     * no metadata object is available, returns null.
     *
     * @return mixed The metadata returned from the server in the last response.
     */
    public function getMetadata(): mixed
    {
        /** @var Any|null $any */
        $any = $this->lastProtoResponse?->getMetadata();
        if (is_null($any) || is_null($this->metadataReturnType)) {
            return $any;
        }
        $metadataReturnType = $this->metadataReturnType;
        /** @var Message $metadata */
        $metadata = new $metadataReturnType();
        $metadata->mergeFromString($any->getValue());
        return $metadata;
    }
}
