<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Google\Cloud\Firestore;

use Google\Cloud\Core\Exception\ServiceException;
use SessionHandlerInterface;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Custom session handler backed by Cloud Firestore.
 *
 * Instead of storing the session data in a local file, this handler stores the
 * data in Firestore. The biggest benefit of doing this is the data can be
 * shared by multiple instances, making it suitable for cloud applications.
 *
 * The downside of using Firestore is that write operations will cost you some
 * money, so it is highly recommended to minimize the write operations while
 * using this handler. In order to do so, keep the data in the session as
 * limited as possible; for example, it is ok to put only signed-in state and
 * the user id in the session with this handler. However, for example, it is
 * definitely not recommended that you store your application's whole undo
 * history in the session, because every user operation will cause a Firestore
 * write, potentially costing you a lot of money.
 *
 * This handler doesn't provide pessimistic lock for session data. Instead, it
 * uses a Firestore transaction for data consistency. This means that if
 * multiple requests are modifying the same session data simultaneously, there
 * will be more probablity that some of the `write` operations will fail.
 *
 * If you are building an AJAX application which may issue multiple requests
 * to the server, please design your session data carefully in order to avoid
 * possible data contentions. Also please see the 2nd example below for how to
 * properly handle errors on `write` operations.
 *
 * The handler stores data in a collection formatted from the values of
 * session.save_path and session.name, which can be customized using the
 * $collectionNameTemplate option. This isolates the session data from your
 * application data. It creates documents in the specified collection where the
 * ID is the session ID. By default, it does nothing on gc for reducing the
 * cost. Pass a positive value up to 500 for $gcLimit option to delete entities
 * in gc.
 *
 * The first example automatically writes the session data. It's handy, but
 * the code doesn't stop even if it fails to write the session data, because
 * the `write` happens when the code exits. If you want to know whether the
 * session data is correctly written to Firestore, you need to call
 * `session_write_close()` explicitly and then handle `E_USER_WARNING`
 * properly. See the second example for a demonstration.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 *
 * $handler = $firestore->sessionHandler();
 *
 * session_set_save_handler($handler, true);
 * session_save_path('sessions');
 * session_start();
 *
 * // Then write and read the $_SESSION array.
 * $_SESSION['name'] = 'Bob';
 * echo $_SESSION['name'];
 * ```
 *
 * ```
 * // Session handler with error handling:
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 *
 * $handler = $firestore->sessionHandler();
 * session_set_save_handler($handler, true);
 * session_save_path('sessions');
 * session_start();
 *
 * // Then read and write the $_SESSION array.
 * $_SESSION['name'] = 'Bob';
 *
 * function handle_session_error($errNo, $errStr, $errFile, $errLine) {
 *     // We throw an exception here, but you can do whatever you need.
 *     throw new RuntimeException(
 *         "$errStr in $errFile on line $errLine",
 *         $errNo
 *     );
 * }
 * set_error_handler('handle_session_error', E_USER_WARNING);
 *
 * // If `write` fails for any reason, an exception will be thrown.
 * session_write_close();
 * restore_error_handler();
 *
 * // You can still read the $_SESSION array after closing the session.
 * echo $_SESSION['name'];
 * ```
 *
 * @see http://php.net/manual/en/class.sessionhandlerinterface.php SessionHandlerInterface
 */
class FirestoreSessionHandler implements SessionHandlerInterface
{
    use SnapshotTrait;

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
    private $projectId;
    /**
     * @var string
     */
    private $database;
    /**
     * @var array
     */
    private $options;
    /**
     * @var string
     */
    private $savePath;
    /**
     * @var string
     */
    private $sessionName;
    /**
     * @var Transaction
     */
    private $transaction;
    /**
     * @var string
     */
    private $id;

    /**
     * Create a custom session handler backed by Cloud Firestore.
     *
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $projectId The current project id.
     * @param string $database The database id.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type int $gcLimit The number of entities to delete in the garbage
     *        collection. Values larger than 500 will be limited to 500.
     *        **Defaults to** `0`, indicating garbage collection is disabled by
     *        default.
     *     @type string $collectionNameTemplate A sprintf compatible template
     *        for formatting the collection name where sessions will be stored.
     *        The template receives two values, the first being the save path
     *        and the latter being the session name.
     *     @type array $begin Configuration options for beginTransaction.
     *     @type array $commit Configuration options for commit.
     *     @type array $rollback Configuration options for rollback.
     *     @type array $read Configuration options for read.
     *     @type array $query Configuration options for runQuery.
     * }
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $projectId,
        $database,
        array $options = []
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->projectId = $projectId;
        $this->database = $database;
        $this->options = $options + [
            'begin' => [],
            'commit' => [],
            'rollback' => [],
            'query' => [],
            'read' => [],
            'gcLimit' => 0,
            'collectionNameTemplate' => '%1$s:%2$s',
        ];

        // Cut down gcLimit to 500, as this is the Firestore batch limit.
        $this->options['gcLimit'] = min($this->options['gcLimit'], 500);
    }

    /**
     * Start a session, by getting the Firebase collection from $savePath.
     *
     * @param string $savePath The value of `session.save_path` setting will be
     *        used in the Firestore collection ID.
     * @param string $sessionName The value of `session.name` setting will be
     *        used in the Firestore collection ID.
     * @return bool
     */
    public function open($savePath, $sessionName)
    {
        $this->savePath = $savePath;
        $this->sessionName = $sessionName;
        $database = $this->databaseName($this->projectId, $this->database);

        try {
            $beginTransaction = $this->connection->beginTransaction([
                'database' => $database
            ] + $this->options['begin']);
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Firestore beginTransaction failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
        }

        $this->transaction = new Transaction(
            $this->connection,
            $this->valueMapper,
            $database,
            $beginTransaction['transaction']
        );

        return true;
    }

    /**
     * Close the transaction and commit any changes.
     */
    public function close()
    {
        if (is_null($this->transaction)) {
            throw new \LogicException('open() must be called before close()');
        }
        try {
            $this->commitTransaction($this->transaction);
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Session close failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }

    /**
     * Read the session data from Cloud Firestore.
     *
     * @param string $id Identifier used for the session.
     * @return string
     */
    public function read($id)
    {
        $this->id = $id;
        try {
            $docRef = $this->getDocumentReference(
                $this->connection,
                $this->valueMapper,
                $this->projectId,
                $this->database,
                $this->docId($id)
            );
            $snapshot = $this->transaction->snapshot(
                $docRef,
                $this->options['read']
            );
            if ($snapshot->exists() && isset($snapshot['data'])) {
                return $snapshot->get('data');
            }
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Firestore lookup failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
        }
        return '';
    }

    /**
     * Write the session data to Cloud Firestore.
     *
     * @param string $id Identifier used for the session.
     * @param string $data The session data to write to the Firestore document.
     * @return bool
     */
    public function write($id, $data)
    {
        $docRef = $this->getDocumentReference(
            $this->connection,
            $this->valueMapper,
            $this->projectId,
            $this->database,
            $this->docId($id)
        );
        $this->transaction->set($docRef, [
            'data' => $data,
            't' => time()
        ]);
        return true;
    }

    /**
     * Delete the session data from Cloud Firestore.
     *
     * @param string $id Identifier used for the session
     * @return bool
     */
    public function destroy($id)
    {
        $docRef = $this->getDocumentReference(
            $this->connection,
            $this->valueMapper,
            $this->projectId,
            $this->database,
            $this->docId($id)
        );
        $this->transaction->delete($docRef);
        return true;
    }

    /**
     * Delete the old session data from Cloud Firestore.
     *
     * @param int $maxlifetime Remove all session data older than this number
     *        in seconds.
     * @return int|bool
     */
    public function gc($maxlifetime)
    {
        if (0 === $this->options['gcLimit']) {
            return true;
        }
        $deleteCount = 0;
        try {
            $database = $this->databaseName($this->projectId, $this->database);
            $beginTransaction = $this->connection->beginTransaction([
                'database' => $database
            ] + $this->options['begin']);

            $transaction = new Transaction(
                $this->connection,
                $this->valueMapper,
                $database,
                $beginTransaction['transaction']
            );

            $collectionRef = $this->getCollectionReference(
                $this->connection,
                $this->valueMapper,
                $this->projectId,
                $this->database,
                $this->collectionId()
            );
            $query = $collectionRef
                ->limit($this->options['gcLimit'])
                ->where('t', '<', time() - $maxlifetime)
                ->orderBy('t');
            $querySnapshot = $transaction->runQuery(
                $query,
                $this->options['query']
            );
            foreach ($querySnapshot as $snapshot) {
                if ($snapshot->id() != $this->id) {
                    $transaction->delete($snapshot->reference());
                    $deleteCount++;
                }
            }
            $this->commitTransaction($transaction);
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Session gc failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return $deleteCount;
    }

    /**
     * Commit a transaction if changes exist, otherwise rollback the
     * transaction. Also rollback if an exception is thrown.
     *
     * @param Transaction $transaction The transaction to commit.
     * @throws ServiceException
     */
    private function commitTransaction(Transaction $transaction)
    {
        try {
            if (!$transaction->writer()->isEmpty()) {
                $transaction->writer()->commit($this->options['commit']);
            } else {
                // trigger rollback if no writes exist.
                $transaction->writer()->rollback($this->options['rollback']);
            }
        } catch (ServiceException $e) {
            $transaction->writer()->rollback($this->options['rollback']);

            throw $e;
        }
    }

    /**
     * Format the Firebase collection ID from the PHP session ID and session
     * name according to the $collectionNameTemplate option.
     * ex: sessions:PHPSESSID
     *
     * @param string $id Identifier used for the session.
     * @return string
     */
    private function collectionId()
    {
        return sprintf(
            $this->options['collectionNameTemplate'],
            $this->savePath,
            $this->sessionName
        );
    }

    /**
     * Format the Firebase document ID from the collection ID.
     * ex: sessions:PHPSESSID/abcdef
     *
     * @param string $id Identifier used for the session.
     * @return string
     */
    private function docId($id)
    {
        return sprintf('%s/%s', $this->collectionId(), $id);
    }
}
