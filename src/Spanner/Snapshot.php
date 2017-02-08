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

namespace Google\Cloud\Spanner;

use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Read-only snapshot Transaction.
 *
 * For full usage details, please refer to
 * {@see Google\Cloud\Spanner\Database::snapshot()}.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder;
 * $spanner = $cloud->spanner();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * $snapshot = $database->snapshot();
 * ```
 */
class Snapshot
{
    use TransactionReadTrait;

    /**
     * @var Timestamp
     */
    private $readTimestamp;

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param string $transactionId The Transaction ID.
     * @param Timestamp $readTimestamp [optional] The read timestamp.
     */
    public function __construct(
        Operation $operation,
        Session $session,
        $transactionId,
        Timestamp $readTimestamp = null
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->transactionId = $transactionId;
        $this->readTimestamp = $readTimestamp;
        $this->context = SessionPoolInterface::CONTEXT_READWRITE;
    }

    /**
     * Retrieve the Read Timestamp.
     *
     * For snapshot read-only transactions, the read timestamp chosen for the
     * transaction.
     *
     * Example:
     * ```
     * $timestamp = $transaction->readTimestamp();
     * ```
     *
     * @return Timestamp
     */
    public function readTimestamp()
    {
        return $this->readTimestamp;
    }
}
