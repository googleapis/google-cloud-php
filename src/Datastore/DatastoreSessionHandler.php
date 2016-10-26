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

/**
 * Custom session handler backed by Cloud Datastore.
 *
 * {@see http://php.net/manual/en/class.sessionhandlerinterface.php}
 *
 * It uses the session.save_path as the Datastore namespace for isolating the
 * session data from your application data. It replaces '/' with '_' for the
 * namespaceId.
 * It also uses session.name as the Datastore kind. It uses the session id as
 * the Datastore id. By default, it does nothing on gc for reducing the cost.
 * Pass positive value up to 1000 for $gcLimit parameter to delete entities
 * in gc.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 * use Google\Cloud\Datastore\DatastoreSessionHandler;
 *
 * $handler = new DatastoreSessionHandler(new DatastoreClient());
 * session_set_save_handler($handler, true);
 * session_start();
 *
 * # Then read and write the $_SESSION array.
 * ```
 */
class DatastoreSessionHandler implements \SessionHandlerInterface
{
    const DEFAULT_GC_LIMIT = 0;
    const DEFAULT_KIND = 'PHPSESSID';
    const DEFAULT_NAMESPACE_ID = 'sessions';

    /* @var int */
    private $gcLimit;

    /* @var DatastoreClient */
    private $datastore;

    /* @var string */
    private $kind;

    /* @var string */
    private $namespaceId;

    /* @var Transaction */
    private $transaction;

    /**
     * @param DatastoreClient $datastore Datastore client
     * @param int $gcLimit A number of entities to delete in garbage collection
     */
    public function __construct(
        DatastoreClient $datastore,
        $gcLimit = self::DEFAULT_GC_LIMIT
    ) {
        $this->datastore = $datastore;
        // Cut down to 1000
        $this->gcLimit = min($gcLimit, 1000);
        $this->kind = self::DEFAULT_KIND;
        $this->namespaceId = self::DEFAULT_NAMESPACE_ID;
    }

    public function open($savePath, $sessionName)
    {
        $this->kind = $sessionName;
        $this->namespaceId = str_replace('/', '_', $savePath);
        $this->transaction = $this->datastore->transaction();
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        try {
            $key = $this->datastore->key(
                $this->kind,
                $id,
                ['namespaceId' => $this->namespaceId]
            );
            $entity = $this->transaction->lookup($key);
            if ($entity !== null && isset($entity['data'])) {
                return $entity['data'];
            }
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore lookup failed: %s', $e->getMessage()),
                E_USER_NOTICE
            );
        }
        return '';
    }

    public function write($id, $data)
    {
        try {
            $key = $this->datastore->key(
                $this->kind,
                $id,
                ['namespaceId' => $this->namespaceId]
            );
            $entity = $this->datastore->entity(
                $key,
                [
                    'data' => $data,
                    't' => time()
                ]
            );
            $this->transaction->upsert($entity);
            $this->transaction->commit();
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore upsert failed: %s', $e->getMessage()),
                E_USER_NOTICE
            );
            return false;
        }
        return true;
    }

    public function destroy($id)
    {
        try {
            $key = $this->datastore->key(
                $this->kind,
                $id,
                ['namespaceId' => $this->namespaceId]
            );
            $this->transaction->delete($key);
            $this->transaction->commit();
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore delete failed: %s', $e->getMessage()),
                E_USER_NOTICE
            );
            return false;
        }
        return true;
    }

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
                ['namespaceId' => $this->namespaceId]
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
                E_USER_NOTICE
            );
            return false;
        }
        return true;
    }
}
