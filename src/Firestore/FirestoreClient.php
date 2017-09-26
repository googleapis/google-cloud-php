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

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Firestore\Connection\Gapic;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\Exception\AbortedException;

/**
 * Cloud Firestore is a flexible, scalable, realtime database for mobile, web, and server development.
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
    use OperationTrait;
    use PathTrait;
    use ValidateTrait;

    const VERSION = 'master';

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
     * @var bool
     */
    private $isRunningTransaction = false;

    /**
     * Create a Firestore client.
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
     */
    public function __construct(array $config = [])
    {
        $config += [
            'returnInt64AsObject' => false,
            'scopes' => [self::FULL_CONTROL_SCOPE]
        ];

        $this->connection = new Gapic($this->configureAuthentication($config));
        $this->valueMapper = new ValueMapper(
            $this->connection,
            $config['returnInt64AsObject']
        );
    }

    /**
     * Get a Batch Writer
     *
     * The {@see Google\Cloud\Firestore\WriteBatch} class is useful for closer
     * to direct database writes. Most operations can be accomplished via other
     * means.
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
     * Lazily instantiate a Collection.
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
     * @param string $relativeName
     * @return Collection
     */
    public function collection($relativeName)
    {
        if (!$this->isCollection($relativeName)) {
            throw new \InvalidArgumentException('Given path is not a valid collection path.');
        }

        return new Collection($this->connection, $this->valueMapper, $this->fullName(
            $this->projectId,
            $this->database,
            $relativeName
        ));
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
     * @return ItemIterator<Collection>
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
                ] + $options, [
                    'itemsKey' => 'collectionIds',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lazily instantiate a Document instance.
     *
     * Example:
     * ```
     * $document = $firestore->document('users/john');
     * ```
     *
     * @param string $name The document name or a path, relative to the database.
     * @return Document
     * @throws InvalidArgumentException If the given path is not a valid document path.
     */
    public function document($name)
    {
        if ($this->isRelative($name)) {
            $name = $this->fullName($this->projectId, $this->database, $name);
        }

        if (!$this->isDocument($name)) {
            throw new \InvalidArgumentException('Given path is not a valid document path.');
        }

        return new Document(
            $this->connection,
            $this->valueMapper,
            $this->collection($this->pathId(
                $this->parentPath(
                    $name
                )
            )),
            $name
        );
    }

    /**
     * Get a list of documents by their path.
     *
     * Example:
     * ```
     * $documents = $firestore->documents([
     *     'users/john',
     *     'users/dave'
     * ]);
     * ```
     *
     * @param array $paths
     * @param array $options
     * @return \Generator
     */
    public function documents(array $paths, array $options = [])
    {
        array_walk($paths, function (&$path) {
            $path = $this->isRelative($path)
                ? $this->fullName($this->projectId, $this->database, $path)
                : $path;
        });

        $documents = $this->connection->batchGetDocuments([
            'database' => $this->databaseName($this->projectId, $this->database),
            'documents' => $paths,
        ] + $options);

        foreach ($documents as $document) {
            $exists = isset($document['found']);
            $data = $exists
                ? $document['found'] + ['readTime' => $document['readTime']]
                : ['readTime' => $document['readTime']];

            $name = $exists
                ? $document['found']['name']
                : $document['missing'];

            yield $this->document($name)->snapshot([
                'data' => $data,
                'exists' => $exists
            ]);
        }
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
     * Example:
     * ```
     * $transferAmount = 500.00;
     * $from = $firestore->document('users/john');
     * $to = $firestore->document('users/dave');
     *
     * $firestore->runTransaction(function (Transaction $t) use ($from, $to, $transferAmount) {
     *
     *     $fromSnapshot = $t->snapshot($from);
     *     $toSnapshot = $t->snapshot($to);
     *
     *     $fromNewBalance = $fromSnapshot['balance'] - $transferAmount;
     *     $toNewBalance = $toSnapshot['balance'] + $transferAmount;
     *
     *     if ($fromNewBalance < 0) {
     *         throw new \Exception('User 1 has insufficient funds!');
     *     }
     *
     *     $t->update($from, [
     *         'balance' => $fromNewBalance
     *     ])->update($to, [
     *         'balance' => $toNewBalance
     *     ]);
     * });
     * ```
     *
     * @param callable $callable A callable function, allowing atomic operations
     *        against the Firestore API. Function signature:
     *        `function (Transaction $t, bool $isRetry)`.
     * @param array $options Configuration Options for BeginTransaction.
     * @return array
     */
    public function runTransaction(callable $callable, array $options = [])
    {
        $options += [
            'maxRetries' => self::MAX_RETRIES
        ];

        $retryableErrors = [
            AbortedException::class
        ];

        $retryFn = function (\Exception $e) use ($retryableErrors) {
            return in_array(get_class($e), $retryableErrors);
        };

        // Track the Transaction ID outside the retry function.
        // If the transaction is retried after an abort, the previous transaction
        // must be provided to the subsequent `beginTransaction` rpc.
        // It also provides a convenient indication to the user whether the
        // transaction is retried or not.
        $transactionId = null;

        $backoff = new ExponentialBackoff($options['maxRetries'], $retryFn);

        return $backoff->execute(function (callable $callable, array $options) use (&$transactionId, $retryableErrors) {
            $this->isRunningTransaction = true;

            $database = $this->fullName($this->projectId, $this->database);

            $beginTransaction = $this->connection->beginTransaction(array_filter([
                'database' => $database,
                'retryTransaction' => $transactionId
            ]) + $options);
            $transactionId = $beginTransaction['transaction'];

            $transaction = new Transaction($this->connection, $this->valueMapper, $database, $transactionId);

            try {
                $callable($transaction, ($transaction !== null));

                return $transaction->writer()->commit([
                    'transaction' => $transactionId
                ] + $transaction->commitOptions());
            } catch (\Exception $e) {
                if (!in_array(get_class($e), $retryableErrors)) {
                    $transaction->writer()->rollback($database, $transactionId, $transaction->commitOptions());
                }

                throw $e;
            } finally {
                $this->isRunningTransaction = false;
            }
        }, [
            $callable,
            $options
        ]);
    }

    /**
     * Create a document instance with the given document name.
     *
     * @param string $name
     * @return Document
     */
    private function documentFactory($name)
    {
        $collectionId = $this->relativeName($this->parentPath($name));
        $collection = $this->collection($collectionId);
        return new Document($this->connection, $this->valueMapper, $collection, $name);
    }
}
