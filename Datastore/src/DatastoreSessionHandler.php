<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Datastore;

use Exception;
use InvalidArgumentException;
use SessionHandlerInterface;

/**
 * Custom session handler backed by Cloud Datastore.
 *
 * Instead of storing the session data in a local file, this handler stores the
 * data in Cloud Datastore. The biggest benefit of doing this is the data can be
 * shared by multiple instances, making it suitable for cloud applications.
 *
 * The downside of using Cloud Datastore is that write operations will cost you
 * some money, so it is highly recommended to minimize the write operations
 * while using this handler. In order to do so, keep the data in the session as
 * limited as possible; for example, it is ok to put only signed-in state and
 * the user id in the session with this handler. However, for example, it is
 * definitely not recommended that you store your application's whole undo
 * history in the session, because every user operation will cause a Datastore
 * write, potentially costing you a lot of money.
 *
 * This handler doesn't provide pessimistic lock for session data. Instead, it
 * uses Datastore Transaction for data consistency. This means that if
 * multiple requests are modifying the same session data simultaneously, there
 * will be more probablity that some of the `write` operations will fail.
 *
 * If you are building an ajax application which may issue multiple requests
 * to the server, please design your session data carefully in order to avoid
 * possible data contentions. Also please see the 2nd example below for how to
 * properly handle errors on `write` operations.
 *
 * The handler sets the Datastore namespace to the value of session.save_path,
 * isolating the session data from your application data, it also uses the
 * session.name as the Datastore kind, and the session id as the Datastore id.
 * By default, it does nothing on gc for reducing the cost. Pass positive value
 * up to 1000 for $gcLimit parameter to delete entities in gc.
 *
 * Note: The datastore transaction only lasts 60 seconds. If this handler is
 * used for long running requests, it will fail on `write`.
 *
 * The first example automatically writes the session data. It's handy, but
 * the code doesn't stop even if it fails to write the session data, because
 * the `write` happens when the code exits. If you want to know whether the
 * session data is correctly written to the Datastore, you need to call
 * `session_write_close()` explicitly and then handle `E_USER_WARNING`
 * properly. See the second example for a demonstration.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 * use Google\Cloud\Datastore\DatastoreSessionHandler;
 *
 * $datastore = new DatastoreClient();
 *
 * $handler = new DatastoreSessionHandler($datastore);
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
 * // Session Handler with Error Handling
 * use Google\Cloud\Datastore\DatastoreClient;
 * use Google\Cloud\Datastore\DatastoreSessionHandler;
 *
 * $datastore = new DatastoreClient();
 *
 * $handler = new DatastoreSessionHandler($datastore);
 * session_set_save_handler($handler, true);
 * session_save_path('sessions');
 * session_start();
 *
 * // Then read and write the $_SESSION array.
 * $_SESSION['name'] = 'Bob';
 *
 * function handle_session_error($errNo, $errStr, $errFile, $errLine) {
 *     // We throw an exception here, but you can do whatever you need.
 *     throw new RuntimeException("$errStr in $errFile on line $errLine", $errNo);
 * }
 *
 * set_error_handler('handle_session_error', E_USER_WARNING);
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
class DatastoreSessionHandler implements SessionHandlerInterface
{
    const DEFAULT_GC_LIMIT = 0;
    /*
     * @see https://cloud.google.com/datastore/docs/reference/rpc/google.datastore.v1#google.datastore.v1.PartitionId
     */
    const NAMESPACE_ALLOWED_PATTERN = '/^[A-Za-z\d\.\-_]{0,100}$/';
    const NAMESPACE_RESERVED_PATTERN = '/^__.*__$/';

    /* @var int */
    private $gcLimit;

    /* @var DatastoreClient */
    private $datastore;

    /* @var string */
    private $kind;

    /* @var string */
    private $namespaceId;

    /* @var string */
    private $databaseId;

    /* @var Transaction */
    private $transaction;

    /* @var array */
    private $options;

    /**
     * Create a custom session handler backed by Cloud Datastore.
     *
     * @param DatastoreClient $datastore Datastore client.
     * @param int $gcLimit [optional] A number of entities to delete in the
     *        garbage collection.  Defaults to 0 which means it does nothing.
     *        The value larger than 1000 will be cut down to 1000.
     * @param array $options [optional]  {
     *     Configuration Options
     *
     *     @type array $entityOptions Default options to be passed to the
     *           {@see \Google\Cloud\Datastore\DatastoreClient::entity()} method when writing session data to Datastore.
     *           If not specified, defaults to `['excludeFromIndexes' => ['data']]`.
     *     @type string $databaseId ID of the database to which the entities belong.
     * }
     */
    public function __construct(
        DatastoreClient $datastore,
        $gcLimit = self::DEFAULT_GC_LIMIT,
        array $options = []
    ) {
        $this->datastore = $datastore;
        // Cut down to 1000
        $this->gcLimit = min($gcLimit, 1000);

        $options += [
            'databaseId' => '',
        ];
        $this->databaseId = $options['databaseId'];
        if (!isset($options['entityOptions'])) {
            $options['entityOptions'] = [
                'excludeFromIndexes' => ['data']
            ];
        }
        if (!is_array($options['entityOptions'])) {
            throw new InvalidArgumentException(
                'Optional argument `entityOptions` must be an array, got ' .
                (is_object($options['entityOptions'])
                    ? get_class($options['entityOptions'])
                    : gettype($options['entityOptions']))
            );
        }

        $this->options = $options;
    }

    /**
     * Start a session, by creating a transaction for the later `write`.
     *
     * @param string $savePath The value of `session.save_path` setting will be
     *        used here. It will use this value as the Datastore namespaceId.
     * @param string $sessionName The value of `session.name` setting will be
     *        used here. It will use this value as the Datastore kind.
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function open($savePath, $sessionName)
    {
        $this->kind = $sessionName;
        if (preg_match(self::NAMESPACE_ALLOWED_PATTERN, $savePath) !== 1 ||
            preg_match(self::NAMESPACE_RESERVED_PATTERN, $savePath) === 1) {
            throw new InvalidArgumentException(
                sprintf('The given save_path "%s" not allowed', $savePath)
            );
        }
        $this->namespaceId = $savePath;
        $this->transaction = $this->datastore->transaction([
            'databaseId' => $this->databaseId
        ]);
        return true;
    }

    /**
     * Just return true for this implementation.
     */
    #[\ReturnTypeWillChange]
    public function close()
    {
        return true;
    }

    /**
     * Read the session data from Cloud Datastore.
     */
    #[\ReturnTypeWillChange]
    public function read($id)
    {
        try {
            $key = $this->datastore->key(
                $this->kind,
                $id,
                array_filter([
                    'namespaceId' => $this->namespaceId,
                    'databaseId' => $this->databaseId,
                ])
            );
            $entity = $this->transaction->lookup($key);
            if ($entity !== null && isset($entity['data'])) {
                return $entity['data'];
            }
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore lookup failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
        }
        return '';
    }

    /**
     * Write the session data to Cloud Datastore.
     *
     * @param string $id Identifier used to construct a {@see \Google\Cloud\Datastore\Key}
     *        for the {@see \Google\Cloud\Datastore\Entity} to be written.
     * @param string $data The session data to write to the {@see \Google\Cloud\Datastore\Entity}.
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function write($id, $data)
    {
        try {
            $key = $this->datastore->key(
                $this->kind,
                $id,
                array_filter([
                    'namespaceId' => $this->namespaceId,
                    'databaseId' => $this->databaseId,
                ])
            );
            $entity = $this->datastore->entity(
                $key,
                [
                    'data' => $data,
                    't' => time()
                ],
                $this->options['entityOptions']
            );
            $this->transaction->upsert($entity);
            $this->transaction->commit();
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore upsert failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }

    /**
     * Delete the session data from Cloud Datastore.
     */
    #[\ReturnTypeWillChange]
    public function destroy($id)
    {
        try {
            $key = $this->datastore->key(
                $this->kind,
                $id,
                array_filter([
                    'namespaceId' => $this->namespaceId,
                    'databaseId' => $this->databaseId,
                ])
            );
            $this->transaction->delete($key);
            $this->transaction->commit();
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore delete failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }

    /**
     * Delete the old session data from Cloud Datastore.
     */
    #[\ReturnTypeWillChange]
    public function gc($maxlifetime)
    {
        if ($this->gcLimit === 0) {
            return true;
        }
        try {
            $query = $this->datastore->query()
                ->kind($this->kind)
                ->filter('t', '<', time() - $maxlifetime)
                ->order('t')
                ->keysOnly()
                ->limit($this->gcLimit);
            $result = $this->datastore->runQuery(
                $query,
                array_filter([
                    'namespaceId' => $this->namespaceId,
                    'databaseId' => $this->databaseId,
                ])
            );
            $keys = [];
            /* @var Entity $e */
            foreach ($result as $e) {
                $keys[] = $e->key();
            }
            if (!empty($keys)) {
                $this->datastore->deleteBatch($keys);
            }
        } catch (Exception $e) {
            trigger_error(
                sprintf('Session gc failed: %s', $e->getMessage()),
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }
}
