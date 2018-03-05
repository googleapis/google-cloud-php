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

use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Timestamp;

/**
 * Common methods for Read-Only transactions (i.e. Snapshots)
 */
trait SnapshotTrait
{
    use TransactionalReadTrait;

    /**
     * @var Timestamp
     */
    private $readTimestamp;

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $id The Transaction ID. If no ID is provided,
     *           the Transaction will be a Single-Use Transaction.
     *     @type Timestamp $readTimestamp The read timestamp.
     * }
     */
    private function initialize(
        Operation $operation,
        Session $session,
        array $options = []
    ) {
        $this->operation = $operation;
        $this->session = $session;

        $options += [
            'id' => null,
            'readTimestamp' => null
        ];

        if ($options['readTimestamp'] && !($options['readTimestamp'] instanceof Timestamp)) {
            throw new \InvalidArgumentException('$options.readTimestamp must be an instance of Timestamp.');
        }

        $this->transactionId = $options['id'] ?: null;
        $this->readTimestamp = $options['readTimestamp'];
        $this->type = $options['id']
            ? self::TYPE_PRE_ALLOCATED
            : self::TYPE_SINGLE_USE;

        $this->context = SessionPoolInterface::CONTEXT_READ;
        $this->options = $options;
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
    public function readTimestamp()
    {
        return $this->readTimestamp;
    }
}
