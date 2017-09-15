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
use Google\Cloud\Core\Exception\AbortedException;

class FirestoreClient
{
    use ClientTrait;
    use OperationTrait;
    use PathTrait;
    use ValidateTrait;

    const VERSION = 'master';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    const MAX_RETRIES = 5;

    private $connection;

    private $database = '(default)';

    private $valueMapper;

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
     * Lazily instantiate a Collection.
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
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#listinstancesrequest ListInstancesRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $filter An expression for filtering the results of the
     *           request.
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
    {}

    /**
     * Lazily instantiate a Document instance.
     *
     * @param string $relativeName The document path, relative to the database name.
     * @return Document
     * @throws InvalidArgumentException If the given path is not a valid document path.
     */
    public function document($relativeName)
    {
        if (!$this->isDocument($relativeName)) {
            throw new \InvalidArgumentException('Given path is not a valid document path.');
        }

        $name = $this->fullName(
            $this->projectId,
            $this->database,
            $relativeName
        );

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
     * @param array $paths
     * @param array $options
     * @return ItemIterator<Document>
     */
    public function documents(array $paths, array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $document) {
                    return $this->documentFactory($document['name']);
                },
                [$this->connection, 'listDocuments'],
                [
                    'parent' => $this->parent($this->name),
                    'collectionId' => $this->id($this->name),
                    'mask' => [] // do not return any fields, since we only need a list of document names.
                ] + $options, [
                    'itemsKey' => 'documents',
                    'resultLimit' => $resultLimit
                ]
            )
        );
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

                return $this->commitWrites($transaction->writer(), [
                    'transaction' => $transactionId
                ] + $transaction->commitOptions());
            } catch (\Exception $e) {
                if (!in_array(get_class($e), $retryableErrors)) {
                    $this->rollback($database, $transactionId, $transaction->commitOptions());
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

    public function runQuery(Query $query)
    {
        return $this->connection->runQuery([
            'parent' => $this->parentPath($query->name()),
            'structuredQuery' => $query->query()
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
        return new Document($this->connection, $this->valueMapper, $this, $name);
    }
}
