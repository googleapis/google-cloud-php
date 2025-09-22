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

namespace Google\Cloud\Spanner;

use Google\ApiCore\ArrayTrait;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\TransactionOptions;

/**
 * Common methods for Read-Only transactions (i.e. Snapshots)
 */
trait SnapshotTrait
{
    use TransactionalReadTrait;

    private ?Timestamp $readTimestamp;

    /**
     * @param Operation $operation The Operation instance.
     * @param SessionCache $session The session to use for spanner interactions.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $id The Transaction ID. If no ID is provided,
     *           the Transaction will be a Single-Use Transaction.
     *     @type Timestamp $readTimestamp The read timestamp.
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     *     @type array $transactionOptions The Transaction Options
     *     @type array $singleUse
     *     @type array $begin
     * }
     */
    private function initialize(
        Operation $operation,
        SessionCache $session,
        array $options = []
    ): void {
        $this->operation = $operation;
        $this->session = $session;

        $this->transactionId = $options['id'] ?? null;
        $this->readTimestamp = $options['readTimestamp'] ?? null;
        $this->type = $this->transactionId
            ? self::TYPE_PRE_ALLOCATED
            : self::TYPE_SINGLE_USE;

        $this->context = Database::CONTEXT_READ;
        $this->directedReadOptions = $options['directedReadOptions'] ?? [];
        $this->transactionSelector = array_intersect_key(
            (array) $options,
            array_flip(['singleUse', 'begin'])
        );
        $this->transactionOptions = $options['transactionOptions'] ?? new TransactionOptions();
    }

    /**
     * Retrieve the Read Timestamp.
     *
     * For snapshot read-only transactions, the read timestamp chosen for the
     * transaction.
     *
     * Example:
     * ```
     * $timestamp = $snapshot->readTimestamp();
     * ```
     *
     * @return Timestamp
     */
    public function readTimestamp(): Timestamp
    {
        return $this->readTimestamp;
    }
}
