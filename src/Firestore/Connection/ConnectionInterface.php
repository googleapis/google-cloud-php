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

namespace Google\Cloud\Firestore\Connection;

interface ConnectionInterface
{
    /**
     * @param array $args
     */
    public function batchGetDocuments(array $args);

    /**
     * @param array $args
     */
    public function beginTransaction(array $args);

    /**
     * @param array $args
     */
    public function commit(array $args);

    /**
     * @param array $args
     */
    public function createDocument(array $args);

    /**
     * @param array $args
     */
    public function createIndex(array $args);

    /**
     * @param array $args
     */
    public function deleteDocument(array $args);

    /**
     * @param array $args
     */
    public function deleteIndex(array $args);

    /**
     * @param array $args
     */
    public function disableIndex(array $args);

    /**
     * @param array $args
     */
    public function enableIndex(array $args);

    /**
     * @param array $args
     */
    public function getCollectionGroup(array $args);

    /**
     * @param array $args
     */
    public function getDatabase(array $args);

    /**
     * @param array $args
     */
    public function getDocument(array $args);

    /**
     * @param array $args
     */
    public function getField(array $args);

    /**
     * @param array $args
     */
    public function getIndex(array $args);

    /**
     * @param array $args
     */
    public function getNamespace(array $args);

    /**
     * @param array $args
     */
    public function listCollectionGroups(array $args);

    /**
     * @param array $args
     */
    public function listCollectionIds(array $args);

    /**
     * @param array $args
     */
    public function listDatabases(array $args);

    /**
     * @param array $args
     */
    public function listDocuments(array $args);

    /**
     * @param array $args
     */
    public function listFields(array $args);

    /**
     * @param array $args
     */
    public function listIndexes(array $args);

    /**
     * @param array $args
     */
    public function listNamespaces(array $args);

    /**
     * @param array $args
     */
    public function listen(array $args);

    /**
     * @param array $args
     */
    public function rollback(array $args);

    /**
     * @param array $args
     */
    public function runQuery(array $args);

    /**
     * @param array $args
     */
    public function updateDocument(array $args);

    /**
     * @param array $args
     */
    public function write(array $args);
}
