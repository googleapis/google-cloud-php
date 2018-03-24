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

namespace Google\Cloud\Datastore;

/**
 * Represents a Read-Only Cloud Datastore Transaction.
 *
 * Read-Only Transactions allow you to execute one or more reads at the current,
 * consistent state of Cloud Datastore at the time the transaction started.
 *
 * Read-Only Transactions in Google Cloud PHP support rollback operations, but
 * do not support commit. It should be considered best practice to rollback
 * read-only transactions when you have finished using them.
 *
 * Transactions are an **optional** feature of Google Cloud Datastore. Queries,
 * lookups and mutations can be executed outside of a Transaction from
 * {@see Google\Cloud\Datastore\DatastoreClient}.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 *
 * $transaction = $datastore->readOnlyTransaction();
 * ```
 *
 * ```
 * // Read-Only Transactions should be rolled back when they are no longer needed.
 * $key = $datastore->key('Users', 'Bob');
 * $userData = $transaction->lookup($key);
 *
 * $transaction->rollback();
 * ```
 *
 * @see https://cloud.google.com/datastore/docs/concepts/transactions Transactions
 */
class ReadOnlyTransaction
{
    use TransactionTrait;
}
