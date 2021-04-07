<?php
/*
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\Compute\V1;

use Google\ApiCore\PollingTrait;
use Google\Cloud\Compute\V1\Operation\Status;

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
 * using an OperationsClient instance.
 */
class OperationResponse
{
    use PollingTrait;

    private $operationName;
    private $operationsClient;

    private const DEFAULT_POLLING_INTERVAL = 1000;
    private const DEFAULT_POLLING_MULTIPLIER = 2;
    private const DEFAULT_MAX_POLLING_INTERVAL = 60000;
    private const DEFAULT_MAX_POLLING_DURATION = 0;

    private $defaultPollSettings = [
        'initialPollDelayMillis' => self::DEFAULT_POLLING_INTERVAL,
        'pollDelayMultiplier' => self::DEFAULT_POLLING_MULTIPLIER,
        'maxPollDelayMillis' => self::DEFAULT_MAX_POLLING_INTERVAL,
        'totalPollTimeoutMillis' => self::DEFAULT_MAX_POLLING_DURATION,
    ];

    private $lastOperation;
    private $deleted = false;

    /**
     * OperationResponse constructor.
     *
     * @param string $operationName
     * @param string $project
     * @param string $zone
     * @param ZoneOperationsClient $operationsClient
     * @param array $options {
     *                       Optional. Options for configuring the Operation response object.
     *
     *     @type int $initialPollDelayMillis    The initial polling interval to use, in milliseconds.
     *     @type int $pollDelayMultiplier Multiplier applied to the polling interval on each retry.
     *     @type int $maxPollDelayMillis The maximum polling interval to use, in milliseconds.
     *     @type int $totalPollTimeoutMillis The maximum amount of time to continue polling.
     *     @type Operation $lastOperation A response already received from the server.
     * }
     */
    public function __construct($operationName, $project, $zone, $operationsClient, $options = [])
    {
        $this->operationName = $operationName;
        $this->project = $project;
        $this->zone = $zone;
        $this->operationsClient = $operationsClient;
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
        if (isset($options['lastOperation'])) {
            $this->lastOperation = $options['lastOperation'];
        }
    }

    /**
     * Check whether the operation has completed.
     *
     * @return bool
     */
    public function isDone()
    {
        if (is_null($this->lastOperation) || is_null($this->lastOperation->getStatus())) {
            return false;
        }

        return $this->lastOperation->getStatus() === Status::DONE;
    }

    /**
     * Check whether the operation completed successfully. If the operation is not complete, or if the operation
     * failed, return false.
     *
     * @return bool
     */
    public function operationSucceeded()
    {
        return $this->isDone() && is_null($this->getError());
    }

    /**
     * Check whether the operation failed. If the operation is not complete, or if the operation
     * succeeded, return false.
     *
     * @return bool
     */
    public function operationFailed()
    {
        return !is_null($this->getError());
    }

    /**
     * Get the formatted name of the operation
     *
     * @return string The formatted name of the operation
     */
    public function getName()
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
    public function pollUntilComplete($options = [])
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
    public function reload()
    {
        if ($this->deleted) {
            throw new ValidationException("Cannot call reload() on a deleted operation");
        }
        $name = $this->getName();
        $this->lastOperation = $this->operationsClient->get($name, $this->project, $this->zone);
    }

    /**
     * If the operation failed, return the status. If operationFailed() is false, return null.
     *
     * @return Status|null The status of the operation in case of failure, or null if
     *                                 operationFailed() is false.
     */
    public function getError()
    {
        if (!$this->isDone() || is_null($this->lastOperation->getError())) {
            return null;
        }
        return $this->lastOperation->getError();
    }

    /**
     * @return Operation|null The last Operation object received from the server.
     */
    public function getlastOperation()
    {
        return $this->lastOperation;
    }

    /**
     * @return OperationsClient The OperationsClient object used to make
     * requests to the operations API.
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Delete the long-running operation. This method indicates that the client is
     * no longer interested in the operation result. It does not cancel the operation.
     * If the server doesn't support this method, it will throw an ApiException with
     * code \Google\Rpc\Code::UNIMPLEMENTED.
     *
     * @throws ApiException If the API call fails.
     */
    public function delete()
    {
        $this->operationsClient->delete($this->getName(), $this->project, $this->zone);
        $this->deleted = true;
    }
}
