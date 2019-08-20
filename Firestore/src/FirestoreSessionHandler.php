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

use Exception;
use InvalidArgumentException;
use SessionHandlerInterface;

/**
 * Custom session handler backed by Cloud Firestore.
 *
 * Instead of storing the session data in a local file, it stores the data to
 * Cloud Firestore. The biggest benefit of doing this is the data can be
 * shared by multiple instances, so it's suitable for cloud applications.
 *
 * The downside of using Cloud Firestore is the write operations will cost you
 * some money, so it is highly recommended to minimize the write operations
 * with your session data with this handler. In order to do so, keep the data
 * in the session as limited as possible; for example, it is ok to put only
 * signed-in state and the user id in the session with this handler. However,
 * for example, it is definitely not recommended that you store your
 * application's whole undo history in the session, because every user
 * operations will cause the Firestore write and then it will cost you lot of
 * money.
 *
 * If you are building an AJAX application which may issue multiple requests
 * to the server, please design the session data carefully, in order to avoid
 * possible data contentions. Also please see the 2nd example below for how to
 * properly handle errors on `write` operations.
 *
 * It uses the session.save_path as the Firestore namespace for isolating the
 * session data from your application data, it also uses the session.name as
 * the Firestore kind, the session id as the Firestore id. By default, it
 * does nothing on gc for reducing the cost. Pass positive value up to 1000
 * for $gcLimit parameter to delete entities in gc.
 *
 *
 * Example without error handling:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient(['projectId' => $projectId]);
 *
 * $handler = new FirestoreSessionHandler($firestore);
 *
 * session_set_save_handler($handler, true);
 * session_save_path('sessions');
 * session_start();
 *
 * // Then read and write the $_SESSION array.
 *
 * ```
 *
 * The above example automatically writes the session data. It's handy, but
 * the code doesn't stop even if it fails to write the session data, because
 * the `write` happens when the code exits. If you want to know the session
 * data is correctly written to the Firestore, you need to call
 * `session_write_close()` explicitly and then handle `E_USER_WARNING`
 * properly like the following example.
 *
 * Example with error handling:
 *
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient(['projectId' => $projectId]);
 *
 * $handler = new FirestoreSessionHandler($firestore);
 * session_set_save_handler($handler, true);
 * session_save_path('sessions');
 * session_start();
 *
 * // Then read and write the $_SESSION array.
 *
 * function handle_session_error($errNo, $errStr, $errFile, $errLine) {
 *     # We throw an exception here, but you can do whatever you need.
 *     throw new Exception("$errStr in $errFile on line $errLine", $errNo);
 * }
 * set_error_handler('handle_session_error', E_USER_WARNING);
 * // If `write` fails for any reason, an exception will be thrown.
 * session_write_close();
 * restore_error_handler();
 * // You can still read the $_SESSION array after closing the session.
 * ```
 * @see http://php.net/manual/en/class.sessionhandlerinterface.php SessionHandlerInterface
 */
class FirestoreSessionHandler implements SessionHandlerInterface
{
    /* @var int */
    private $gcLimit;
    /* @var FirestoreClient */
    private $firestore;
    /* @var CollectionReference */
    private $collection;

    /**
     * Create a custom session handler backed by Cloud Firestore.
     *
     * @param FirestoreClient $firestore Firestore client.
     * @param int $gcLimit [optional] A number of entities to delete in the
     *        garbage collection.  Defaults to 0 which means it does nothing.
     *        The value larger than 1000 will be cut down to 1000.
     */
    public function __construct(
        FirestoreClient $firestore,
        $gcLimit = 0
    ) {
        $this->firestore = $firestore;
        // Cut down to 1000
        $this->gcLimit = min($gcLimit, 1000);
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
        if (false !== strpos($savePath, '/')) {
            throw new InvalidArgumentException(
                sprintf('The given save_path "%s" not allowed', $savePath)
            );
        }
        $this->sessionName = $sessionName;
        $this->collection = $this->firestore->collection($savePath);
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
            $docRef = $this->collection->document($this->formatId($id));
            $snapshot = $docRef->snapshot();
            if ($snapshot->exists() && isset($snapshot['data'])) {
                return $snapshot->get('data');
            }
        } catch (Exception $e) {
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
            $docRef = $this->collection->document($this->formatId($id));
            $docRef->set([
                'data' => $data,
                't' => time()
            ]);
        } catch (Exception $e) {
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
            $this->collection->document($this->formatId($id))->delete();
        } catch (Exception $e) {
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
            $query = $this->collection
                ->limit($this->gcLimit)
                ->orderBy('t')
                ->where('t', '<', time() - $maxlifetime);
            foreach ($query->documents() as $snapshot) {
                $snapshot->reference()->delete();
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

    /**
     * Format the Firebase document ID from the PHP session ID and session name.
     * ex: PHPSESSID:abcdef
     *
     * @param string $id Identifier used for the session
     * @return string
     */
    private function formatId($id)
    {
        return sprintf('%s:%s', $this->sessionName, $id);
    }
}
