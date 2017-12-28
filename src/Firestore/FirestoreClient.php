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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Blob;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\Retry;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Firestore\Connection\Grpc;

/**
 * Cloud Firestore is a flexible, scalable, realtime database for mobile, web, and server development.
 *
 * In production environments, it is highly recommended that you make use of the
 * Protobuf PHP extension for improved performance. Protobuf can be installed
 * via [PECL](https://pecl.php.net).
 *
 * ```
 * $ pecl install protobuf
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * ```
 */
class FirestoreClient
{
    use ClientTrait;
    use SnapshotTrait;
    use ValidateTrait;

    const VERSION = '0.3.2';

    const DEFAULT_DATABASE = '(default)';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    const MAX_RETRIES = 5;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $database = '(default)';

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * Create a Firestore client. Please note that this client requires
     * [the gRPC extension](https://cloud.google.com/php/grpc).
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. **Defaults
     *           to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws \InvalidArgumentException
     * @throws GoogleException If the gRPC extension is not enabled.
     */
    public function __construct(array $config = [])
    {
        $this->requireGrpc();
        $config += [
            'returnInt64AsObject' => false,
            'scopes' => [self::FULL_CONTROL_SCOPE],
            'database' => self::DEFAULT_DATABASE
        ];

        $this->database = $config['database'];

        $this->connection = new Grpc($this->configureAuthentication($config) + [
            'projectId' => $this->projectId
        ]);

        $this->valueMapper = new ValueMapper(
            $this->connection,
            $config['returnInt64AsObject']
        );
    }

    /**
     * Get a Batch Writer
     *
     * The {@see Google\Cloud\Firestore\WriteBatch} allows more performant
     * multi-document, atomic updates.
     *
     * Example:
     * ```
     * $batch = $firestore->batch();
     * ```
     *
     * @return WriteBatch
     */
    public function batch()
    {
        return new WriteBatch(
            $this->connection,
            $this->valueMapper,
            $this->database
        );
    }

    /**
     * Lazily instantiate a Collection reference.
     *
     * Collections hold Firestore documents. Collections cannot be created or
     * deleted directly - they exist only as implicit namespaces. Once no child
     * documents remain in a collection, it ceases to exist.
     *
     * Example:
     * ```
     * $collection = $firestore->collection('users');
     * ```
     *
     * @param string $name The name of the collection.
     * @return CollectionReference
     */
    public function collection($name)
    {
        if ($this->isRelative($name)) {
            $name = $this->fullName($this->projectId, $this->database, $name);
        }

        if (!$this->isCollection($name)) {
            throw new \InvalidArgumentException('Given path is not a valid collection path.');
        }

        return new CollectionReference($this->connection, $this->valueMapper, $name);
    }

    /**
     * List root-level collections in the database.
     *
     * Example:
     * ```
     * $collections = $firestore->collections();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.ListCollectionIds ListCollectionIds
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<CollectionReference>
     */
    public function collections(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function ($collectionId) {
                    return $this->collection($collectionId);
                },
                [$this->connection, 'listCollectionIds'],
                [
                    'parent' => $this->databaseName($this->projectId, $this->database),
                ] + $options,
                [
                    'itemsKey' => 'collectionIds',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Get a reference to a Firestore document.
     *
     * Example:
     * ```
     * $document = $firestore->document('users/john');
     * ```
     *
     * @param string $name The document name or a path, relative to the database.
     * @return DocumentReference
     * @throws \InvalidArgumentException If the given path is not a valid document path.
     */
    public function document($name)
    {
        if ($this->isRelative($name)) {
            $name = $this->fullName($this->projectId, $this->database, $name);
        }

        if (!$this->isDocument($name)) {
            throw new \InvalidArgumentException('Given path is not a valid document path.');
        }

        return new DocumentReference(
            $this->connection,
            $this->valueMapper,
            $this->collection($this->pathId($this->parentPath($name))),
            $name
        );
    }

    /**
     * Get a list of documents by their path.
     *
     * The number of results generated will be equal to the number of documents
     * requested, except in case of error.
     *
     * Note that this method will **always** return instances of
     * {@see Google\Cloud\Firestore\DocumentSnapshot}, even if the documents
     * requested do not exist. It is highly recommended that you check for
     * existence before accessing document data.
     *
     * Example:
     * ```
     * $documents = $firestore->documents([
     *     'users/john',
     *     'users/dave'
     * ]);
     * ```
     *
     * ```
     * // To check whether a given document exists, use `DocumentSnapshot::exists()`.
     * $documents = $firestore->documents([
     *     'users/deleted-user'
     * ]);
     *
     * foreach ($documents as $document) {
     *     if (!$document->exists()) {
     *         echo $document->id() . ' Does Not Exist';
     *     }
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.BatchGetDocuments BatchGetDocuments
     * @codingStandardsIgnoreEnd
     *
     * @param string[]|DocumentReference[] $paths Any combination of string paths or DocumentReference instances.
     * @param array $options Configuration options.
     * @return DocumentSnapshot[]
     */
    public function documents(array $paths, array $options = [])
    {
        array_walk($paths, function (&$path) {
            if ($path instanceof DocumentReference) {
                $path = $path->name();
            }

            $path = $this->isRelative($path)
                ? $this->fullName($this->projectId, $this->database, $path)
                : $path;
        });

        $documents = $this->connection->batchGetDocuments([
            'database' => $this->databaseName($this->projectId, $this->database),
            'documents' => $paths,
        ] + $options);

        $res = [];
        foreach ($documents as $document) {
            $exists = isset($document['found']);
            $data = $exists
                ? $document['found'] + ['readTime' => $document['readTime']]
                : ['readTime' => $document['readTime']];

            $name = $exists
                ? $document['found']['name']
                : $document['missing'];

            $res[$name] = $this->createSnapshotWithData(
                $this->valueMapper,
                $this->document($name),
                $data,
                $exists
            );
        }

        $out = [];
        foreach ($paths as $path) {
            $out[] = $res[$path];
        }

        return $out;
    }

    /**
     * Executes a function in a Firestore transaction.
     *
     * Transactions offer atomic operations, guaranteeing that either all
     * writes will be applied, or none will be applied. The Google Cloud PHP
     * Firestore client also handles automatic retry in cases where transactions
     * fail due to a retryable error.
     *
     * Transactions will be committed once the provided callable has finished
     * execution. Thrown exceptions will prevent commit and trigger a rollback,
     * and will bubble up to your level to be handled in whatever fashion is
     * appropriate.
     *
     * This method returns the return value of the given transaction callable.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\Transaction;
     *
     * $transferAmount = 500.00;
     * $from = $firestore->document('users/john');
     * $to = $firestore->document('users/dave');
     *
     * $toNewBalance = $firestore->runTransaction(function (Transaction $t) use ($from, $to, $transferAmount) {
     *     $fromSnapshot = $t->snapshot($from);
     *     $toSnapshot = $t->snapshot($to);
     *
     *     $fromNewBalance = $fromSnapshot['balance'] - $transferAmount;
     *     $toNewBalance = $toSnapshot['balance'] + $transferAmount;
     *
     *     // If the transaction cannot be completed, throwing any exception
     *     // will trigger a rollback operation.
     *     if ($fromNewBalance < 0) {
     *         throw new \Exception('User 1 has insufficient funds!');
     *     }
     *
     *     $t->update($from, [
     *         ['path' => 'balance', 'value' => $fromNewBalance]
     *     ])->update($to, [
     *         ['path' => 'balance', 'value' => $toNewBalance]
     *     ]);
     *
     *     return $toNewBalance;
     * });
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.BeginTransaction BeginTransaction
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Rollback Rollback
     * @codingStandardsIgnoreEnd
     *
     * @param callable $callable A callable function, allowing atomic operations
     *        against the Firestore API. Function signature should be of form:
     *        `function (Transaction $t)`.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type array $begin Configuration options for BeginTransaction.
     *     @type array $commit Configuration options for Commit.
     *     @type array $rollback Configuration options for rollback.
     *     @type int $maxRetries The maximum number of times to retry failures.
     *            **Defaults to** `5`.
     * }
     * @return mixed
     */
    public function runTransaction(callable $callable, array $options = [])
    {
        $options += [
            'maxRetries' => self::MAX_RETRIES,
            'begin' => [],
            'commit' => [],
            'rollback' => []
        ];

        $retryableErrors = [
            AbortedException::class
        ];

        $delayFn = function () {
            return [
                'seconds' => 0,
                'nanos' => 0
            ];
        };

        $retryFn = function (\Exception $e) use ($retryableErrors) {
            return in_array(get_class($e), $retryableErrors);
        };

        // Track the Transaction ID outside the retry function.
        // If the transaction is retried after an abort, the previous transaction
        // must be provided to the subsequent `beginTransaction` rpc.
        // It also provides a convenient indication to the user whether the
        // transaction is retried or not.
        $transactionId = null;

        $retry = new Retry($options['maxRetries'], $delayFn, $retryFn);

        return $retry->execute(function (
            callable $callable,
            array $options
        ) use (
            &$transactionId,
            $retryableErrors
        ) {
            $database = $this->databaseName($this->projectId, $this->database);

            $beginTransaction = $this->connection->beginTransaction(array_filter([
                'database' => $database,
                'retryTransaction' => $transactionId
            ]) + $options['begin']);

            $transactionId = $beginTransaction['transaction'];

            $transaction = new Transaction(
                $this->connection,
                $this->valueMapper,
                $database,
                $transactionId
            );

            try {
                $res = $callable($transaction);

                if (!$transaction->writer()->isEmpty()) {
                    $transaction->writer()->commit([
                        'transaction' => $transactionId
                    ] + $options['commit']);
                } else {
                    // trigger rollback if no writes exist.
                    $transaction->writer()->rollback($options['rollback']);
                }

                return $res;
            } catch (\Exception $e) {
                $transaction->writer()->rollback($options['rollback']);

                throw $e;
            }
        }, [
            $callable,
            $options
        ]);
    }

    /**
     * Create a new GeoPoint
     *
     * Example:
     * ```
     * $geoPoint = $firestore->geoPoint(37.4220, -122.0841);
     * ```
     *
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.type#google.type.LatLng LatLng
     *
     * @param float $latitude The latitude
     * @param float $longitude The longitude
     * @return GeoPoint
     */
    public function geoPoint($latitude, $longitude)
    {
        return new GeoPoint($latitude, $longitude);
    }

    /**
     * Create a new Blob
     *
     * Example:
     * ```
     * $blob = $firestore->blob('hello world');
     * ```
     *
     * ```
     * // Blobs can be used to store binary data
     * $blob = $firestore->blob(file_get_contents(__DIR__ .'/family-photo.jpg'));
     * ```
     *
     * @param string|resource|StreamInterface $value The value to store in a blob.
     * @return Blob
     */
    public function blob($value)
    {
        return new Blob($value);
    }

    /**
     * Returns a FieldPath class, referring to a field in a document.
     *
     * The path may consist of a single field name (referring to a top-level
     * field in the document), or a list of field names (referring to a nested
     * field in the document).
     *
     * Example:
     * ```
     * $path = $firestore->fieldPath(['accounts', 'usd']);
     * ```
     *
     * @param array $fieldNames A list of field names.
     * @return FieldPath
     */
    public function fieldPath(array $fieldNames)
    {
        return new FieldPath($fieldNames);
    }
}
