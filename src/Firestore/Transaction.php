<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Represents a Firestore transaction.
 *
 * This class should be accessed inside a transaction callable, obtained via
 * {@see Google\Cloud\Firestore\FirestoreClient::runTransaction()}.
 *
 * Note that method examples, while shown as being called directly for the sake
 * of brevity, should be called only within the context of a transaction
 * callable, as noted above.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 * use Google\Cloud\Firestore\Transaction;
 *
 * $firestore = new FirestoreClient();
 * $document = $firestore->document('users/john');
 * $firestore->runTransaction(function (Transaction $transaction) use ($document) {
 *     // Manage Transaction.
 * });
 * ```
 */
class Transaction
{
    use SnapshotTrait;
    use DebugInfoTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var string
     */
    private $transaction;

    /**
     * @var string
     */
    private $database;

    /**
     * @var WriteBatch
     */
    private $writer;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $database The database name.
     * @param string $transaction The transaction ID.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $database,
        $transaction
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->database = $database;
        $this->transaction = $transaction;

        $this->writer = new WriteBatch($connection, $valueMapper, $database, $transaction);
    }

    /**
     * Lazily instantiate a Collection with the current Transaction ID applied.
     *
     * Collections hold Firestore documents. Collections cannot be created or
     * deleted directly - they exist only as implicit namespaces. Once no child
     * documents remain in a collection, it ceases to exist.
     *
     * Creating a Collection within a Transaction is required in order to run
     * queries as part of a Firestore Transaction.
     *
     * Example:
     * ```
     * $collection = $transaction->collection('users');
     * ```
     *
     * @param string $name The name of the collection.
     * @return CollectionReference
     */
    public function collection($name)
    {
        if ($this->isRelative($name)) {
            $name = $this->fullNameFromDatabase($this->database, $name);
        }

        if (!$this->isCollection($name)) {
            throw new \InvalidArgumentException('Given path is not a valid collection path.');
        }

        return new CollectionReference($this->connection, $this->valueMapper, $name, $this->transaction);
    }

    /**
     * Get a Document Snapshot.
     *
     * Unlike {@see Google\Cloud\Firestore\Document::snapshot()}, if the document
     * does not exist, this method will throw
     * {@see Google\Cloud\Core\Exception\NotFoundException}.
     *
     * Example:
     * ```
     * $snapshot = $transaction->snapshot($document);
     * ```
     *
     * @param DocumentReference $document The document to retrieve.
     * @param array $options Configuration options.
     * @return DocumentSnapshot
     * @throws NotFoundException If the document does not exist.
     */
    public function snapshot(DocumentReference $document, array $options = [])
    {
        return $this->createSnapshot($document, [
            'transaction' => $this->transaction,
            'allowNonExistence' => false
        ] + $options);
    }

    /**
     * Create a Firestore document.
     *
     * Example:
     * ```
     * $transaction->create($document, [
     *     'name' => 'John',
     *     'country' => 'USA'
     * ]);
     * ```
     *
     * @param DocumentReference $document The document to create.
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\Document::update()},
     *        field paths are NOT supported by this method.
     * @return Transaction
     */
    public function create(DocumentReference $document, array $fields)
    {
        $this->writer->create($document->name(), $fields);

        return $this;
    }

    /**
     * Modify or replace a Firestore document.
     *
     * Example:
     * ```
     * // In this example, all field not explicitly specified will be removed.
     * $transaction->set($document, [
     *     'name' => 'Johnny'
     * ]);
     * ```
     *
     * ```
     * // To specify MERGE over REPLACE, set `$options.merge` to `true`.
     * $transaction->set($document, [
     *     'name' => 'Johnny'
     * ], [
     *     'merge' => true
     * ]);
     * ```
     *
     * @param DocumentReference $document The document to modify or replace.
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\Document::update()},
     *        field paths are NOT supported by this method.
     * @param array $options {
     *     Configuration options.
     *
     *     @type bool $merge If true, unwritten fields will be preserved.
     *           Otherwise, they will be overwritten (removed). **Defaults to**
     *           `false`.
     * }
     * @return Transaction
     */
    public function set(DocumentReference $document, array $fields, array $options = [])
    {
        $this->writer->set($document->name(), $fields, $options);

        return $this;
    }

    /**
     * Update a Firestore document.
     *
     * Merges provided data with data stored in Firestore.
     *
     * By default, this method will fail if the document does not exist.
     *
     * To remove a field, set the field value to `FirestoreClient::DELETE_FIELD`.
     *
     * Example:
     * ```
     * $transaction->update($document, [
     *     'name' => 'John'
     * ]);
     * ```
     *
     * ```
     * // Fields may be deleted by setting them to a special value.
     * $transaction->update($document, [
     *     'country' => FirestoreClient::DELETE_FIELD
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param string $documentName The document to update.
     * @param array $fields An array containing field names paired with their value.
     *        Accepts a nested array, or a simple array of field paths.
     * @param array $options {
     *     Configuration options
     *
     *     @type array $precondition An optional precondition on the document. If
     *           this is set and not met by the target document, the write will
     *           fail. Allowed arguments are `(bool) $exists` and
     *           {@see Google\Cloud\Core\Timestamp} `$updateTime`.
     *           To completely disable precondition checks, provide an empty array
     *           as the value of `$precondition`. **Defaults to**
     *           `['exists' => true]` (i.e. Document must exist in Firestore).
     *           For more information, refer to the [Precondition](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Precondition)
     *           documentation.
     * }
     * @return Transaction
     * @codingStandardsIgnoreEnd
     */
    public function update(DocumentReference $document, array $fields, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true]
        ];

        $this->writer->update($document->name(), $fields, $options);

        return $this;
    }

    /**
     * Delete a Firestore document.
     *
     * Example:
     * ```
     * $transaction->delete($document);
     * ```
     *
     * @param DocumentReference $document The document to delete.
     * @param array $options Configuration Options.
     * @return Transaction
     * @throws ConflictException If the precondition is not met.
     */
    public function delete(DocumentReference $document, array $options = [])
    {
        $this->writer->delete($document->name(), $options);

        return $this;
    }

    /**
     * Get the WriteBatch object.
     *
     * @access private
     * @return WriteBatch
     */
    public function writer()
    {
        return $this->writer;
    }
}
