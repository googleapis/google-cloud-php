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
 * It ignores the $savePath. It is highly recommended to use namespaceId for
 * isolating the session data from your application data.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 * use Google\Cloud\Datastore\DatastoreSessionHandler;
 *
 * $handler = new DatastoreSessionHandler(
 *     new DatastoreClient(['namespaceId' => 'sessions'])
 * );
 * session_set_save_handler($handler, true);
 * session_start();
 * ```
 */
class DatastoreSessionHandler implements \SessionHandlerInterface
{
    const DEFAULT_GC_LIMIT = 1000;
    const DEFAULT_KIND = 'PHPSESSID';

    /* @var int */
    private $gcLimit;

    /* @var DatastoreClient */
    private $datastore;

    /* @var string */
    private $kind;

    /**
     * @param DatastoreClient $datastore Datastore client
     * @param int $gcLimit A number of entities to delete in garbage collection
     */
    public function __construct(
        DatastoreClient $datastore,
        $gcLimit = self::DEFAULT_GC_LIMIT
    ) {
        $this->datastore = $datastore;
        $this->gcLimit = $gcLimit;
        $this->kind = self::DEFAULT_KIND;
    }

    public function open($savePath, $sessionName)
    {
        $this->kind = $sessionName;
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        try {
            $key = $this->datastore->key($this->kind, $id);
            $entity = $this->datastore->lookup($key);
            if ($entity === null) {
                return '';
            }
            return isset($entity['data']) ? $entity['data'] : '';
        } catch (Exception $e) {
            trigger_error(
                sprintf('Datastore lookup failed: %s', $e->getMessage()),
                E_USER_NOTICE
            );
            return '';
        }
    }

    public function write($id, $data)
    {
        try {
            $key = $this->datastore->key($this->kind, $id);
            $entity = $this->datastore->entity(
                $key,
                [
                    'data' => $data,
                    't' => time()
                ]
            );
            $this->datastore->upsert($entity);
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
            $key = $this->datastore->key($this->kind, $id);
            $this->datastore->delete($key);
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
        try {
            $query = $this->datastore->query()
                ->kind($this->kind)
                ->filter('t', '<', time() - $maxlifetime)
                ->order('t')
                ->keysOnly()
                ->limit($this->gcLimit);
            $result = $this->datastore->runQuery($query);
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
