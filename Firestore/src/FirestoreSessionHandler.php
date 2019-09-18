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
 * The handler stores data in a collection provided by the value of
 * session.save_path, isolating the session data from your application data. It
 * creates documents in the specified collection where the session name and ID
 * are concatenated. By default, it does nothing on gc for reducing the cost.
 * Pass a positive value up to 1000 for $gcLimit parameter to delete entities in
 * gc.
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
     * Create a custom session handler backed by Cloud Firestore.
     *
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $database The current database
     * @param array $options [optional]
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $database,
        array $options = []
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->database = $database;
        $this->options = $options + [
            'begin' => [],
            'commit' => [],
            'rollback' => [],
            'delete' => [],
            'gcLimit' => 0,
        ];

        // Cut down gcLimit to 1000
        $this->options['gcLimit'] = min($this->options['gcLimit'], 1000);
    }

    /**
     * Start a session, by getting the Firebase collection from $savePath.
     *
     * @param string $savePath The value of `session.save_path` setting will be
     *        used here as the Firestore collection ID.
     * @param string $sessionName The value of `session.name` setting will be
     *        used here as the Firestore document ID prefix (ex: "PHPSESSID:").
     * @return bool
     */
    public function open($savePath, $sessionName)
    {
        $this->savePath = $savePath;
        $this->sessionName = $sessionName;

        $beginTransaction = $this->connection->beginTransaction([
            'database' => $this->database,
        ] + $this->options['begin']);

        $this->transaction = new Transaction(
            $this->connection,
            $this->valueMapper,
            $this->database,
            $beginTransaction['transaction']
        );

        return true;
    }

    /**
     * Just return true for this implementation.
     */
    public function close()
    {
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
        try {
            $snapshot = $this->transaction->snapshot($this->docRef($id));
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
        try {
            $this->transaction->set($this->docRef($id), [
                'data' => $data,
                't' => time()
            ]);
            $this->commitTransaction();
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Firestore upsert failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
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
        try {
            $this->transaction->delete(
                $this->docRef($id),
                $this->options['delete']
            );
            $this->commitTransaction();
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Firestore delete failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }

    /**
     * Delete the old session data from Cloud Firestore.
     *
     * @param int $maxlifetime Remove all session data older than this number
     *        in seconds.
     * @return bool
     */
    public function gc($maxlifetime)
    {
        if (0 === $this->gcLimit) {
            return true;
        }
        try {
            $query = $this->collectionRef()
                ->limit($this->gcLimit)
                ->orderBy('t')
                ->where('t', '<', time() - $maxlifetime)
                ->where('id', '>=', $this->sessionName . ':')
                ->where('id', '<', $this->sessionName . chr(ord(':') + 1));
            $querySnapshot = $this->transaction->runQuery($query);
            foreach ($querySnapshot as $snapshot) {
                $this->transaction->delete(
                    $snapshot->reference(),
                    $this->options['delete']
                );
            }
            $this->commitTransaction();
        } catch (ServiceException $e) {
            trigger_error(
                sprintf('Session gc failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }

    /**
     * Returns a Firestore document reference for the provided PHP session ID.
     *
     * @param string $id Identifier used for the session
     * @return DocumentReference
     */
    private function docRef($id)
    {
        // The Firebase document name is derived from the session ID and session
        // path, ex: "PHPSESSID:abcdef".
        $collectionRef = $this->collectionRef();
        $parent = $collectionRef->name();
        $name = sprintf('%s/%s:%s', $parent, $this->sessionName, $id);
        return new DocumentReference(
            $this->connection,
            $this->valueMapper,
            $collectionRef,
            $name
        );
    }

    /**
     * Returns a Firestore collection reference for the provided PHP session ID.
     *
     * @return CollectionReference
     */
    private function collectionRef()
    {
        // The Firebase collection path is derived from the save path.
        $name = sprintf('%s/documents/%s', $this->database, $this->savePath);
        return new CollectionReference(
            $this->connection,
            $this->valueMapper,
            $name
        );
    }

    /**
     * Commit a transaction if changes exist, otherwise rollback the
     * transaction. Also rollback if an exception is thrown.
     *
     * @throws \Exception
     */
    private function commitTransaction()
    {
        try {
            if (!$this->transaction->writer()->isEmpty()) {
                $this->transaction->writer()->commit($this->options['commit']);
            } else {
                // trigger rollback if no writes exist.
                $this->transaction->writer()->rollback($this->options['rollback']);
            }
        } catch (\Exception $e) {
            $this->transaction->writer()->rollback($this->options['rollback']);

            throw $e;
        }
    }
}
