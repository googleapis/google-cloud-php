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
 * It uses the $savePath for the custom namespace which isolates the session
 * data from your application data.
 *
 * Class DatastoreSessionHandler
 * @package Google\Cloud\Datastore
 */
class DatastoreSessionHandler implements \SessionHandlerInterface
{
    const KIND = 'Session';

    const GC_LIMIT = 1000;

    /* @var DatastoreClient */
    private $datastore;

    public function open($savePath, $sessionName)
    {
        $this->datastore = new DatastoreClient(
            ['namespaceId' => $savePath]
        );
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        try {
            $key = $this->datastore->key(self::KIND, $id);
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
            $key = $this->datastore->key(self::KIND, $id);
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
            $key = $this->datastore->key(self::KIND, $id);
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
                ->kind(self::KIND)
                ->filter('t', '<', time() - $maxlifetime)
                ->order('t')
                ->keysOnly()
                ->limit(self::GC_LIMIT);
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
                sprintf('Datastore deleteBatch failed: %s', $e->getMessage()),
                E_USER_NOTICE
            );
            return false;
        }
        return true;
    }
}
