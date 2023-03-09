<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner\Connection;

use GuzzleHttp\Promise\PromiseInterface;

/**
 * Describes a connection to the Cloud Spanner API
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     */
    public function listInstanceConfigs(array $args);

    /**
     * @param array $args
     */
    public function getInstanceConfig(array $args);

    /**
     * @param array $args
     */
    public function createInstanceConfig(array $args);

    /**
     * @param array $args
     */
    public function updateInstanceConfig(array $args);

    /**
     * @param array $args
     */
    public function deleteInstanceConfig(array $args);

    /**
     * @param array $args
     */
    public function listInstanceConfigOperations(array $args);

    /**
     * @param array $args
     */
    public function listInstances(array $args);

    /**
     * @param array $args
     */
    public function getInstance(array $args);

    /**
     * @param array $args
     */
    public function createInstance(array $args);

    /**
     * @param array $args
     */
    public function updateInstance(array $args);

    /**
     * @param array $args
     */
    public function deleteInstance(array $args);

    /**
     * @param array $args
     */
    public function getInstanceIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function setInstanceIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function testInstanceIamPermissions(array $args);

    /**
     * @param array $args
     */
    public function listBackups(array $args);

    /**
     * @param array $args
     */
    public function listBackupOperations(array $args);
    /**
     * @param array $args
     */
    public function listDatabaseOperations(array $args);

    /**
     * @param array $args
     */
    public function restoreDatabase(array $args);

    /**
     * @param array $args
     */
    public function updateBackup(array $args);

    /**
     * @param array $args
     */
    public function createBackup(array $args);

    /**
     * @param array $args
     */
    public function copyBackup(array $args);

    /**
     * @param array $args
     */
    public function deleteBackup(array $args);

    /**
     * @param array $args
     */
    public function getBackup(array $args);

    /**
     * @param array $args
     */
    public function listDatabases(array $args);

    /**
     * @param array $args
     */
    public function createDatabase(array $args);

    /**
     * @param array $args
     */
    public function updateDatabaseDdl(array $args);

    /**
     * @param array $args
     */
    public function dropDatabase(array $args);

    /**
     * @param array $args
     */
    public function getDatabase(array $args);

    /**
     * @param array $args
     */
    public function getDatabaseDDL(array $args);

    /**
     * @param array $args
     */
    public function getDatabaseIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function setDatabaseIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function testDatabaseIamPermissions(array $args);

    /**
     * @param array $args
     */
    public function createSession(array $args);

    /**
     * @param array $args
     * @return PromiseInterface
     */
    public function createSessionAsync(array $args);

    /**
     * @param array $args
     */
    public function batchCreateSessions(array $args);

    /**
     * @param array $args
     */
    public function getSession(array $args);

    /**
     * @param array $args
     */
    public function deleteSession(array $args);

    /**
     * @param array $args
     * @return PromiseInterface
     */
    public function deleteSessionAsync(array $args);

    /**
     * @param array $args
     * @return \Generator
     */
    public function executeStreamingSql(array $args);

    /**
     * @param array $args
     * @return \Generator
     */
    public function streamingRead(array $args);

    /**
     * @param array $args
     */
    public function executeBatchDml(array $args);

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
    public function rollback(array $args);

    /**
     * @param array $args
     */
    public function getOperation(array $args);

    /**
     * @param array $args
     */
    public function cancelOperation(array $args);

    /**
     * @param array $args
     */
    public function deleteOperation(array $args);

    /**
     * @param array $args
     */
    public function listOperations(array $args);

    /**
     * @param array $args
     */
    public function partitionQuery(array $args);

    /**
     * @param array $args
     */
    public function partitionRead(array $args);
}
