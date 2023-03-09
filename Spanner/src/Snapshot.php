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
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * $transaction = $database->snapshot();
 * ```
 */
class Snapshot implements TransactionalReadInterface
{
    use SnapshotTrait;

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
     * @throws \InvalidArgumentException if a tag is specified as this is a read-only transaction.
     */
    public function __construct(Operation $operation, Session $session, array $options = [])
    {
        if (isset($options['tag'])) {
            throw new \InvalidArgumentException(
                "Cannot set a transaction tag on a read-only transaction."
            );
        }
        $this->initialize($operation, $session, $options);
    }
}
