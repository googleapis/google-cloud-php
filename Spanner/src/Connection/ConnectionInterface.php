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

use Google\ApiCore\OperationResponse;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Describes a connection to the Cloud Spanner API
 *
 * @internal
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     * @return array
     */
    public function listInstanceConfigs(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getInstanceConfig(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function createInstanceConfig(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function updateInstanceConfig(array $args);

    /**
     * @param array $args
     * @return null
     */
    public function deleteInstanceConfig(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function listInstanceConfigOperations(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function listInstances(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getInstance(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function createInstance(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function updateInstance(array $args);

    /**
     * @param array $args
     * @return null
     */
    public function deleteInstance(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getInstanceIamPolicy(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function setInstanceIamPolicy(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function testInstanceIamPermissions(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function listBackups(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function listBackupOperations(array $args);
    /**
     * @param array $args
     * @return array
     */
    public function listDatabaseOperations(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function restoreDatabase(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function updateBackup(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function createBackup(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function copyBackup(array $args);

    /**
     * @param array $args
     * @return null
     */
    public function deleteBackup(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getBackup(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function listDatabases(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function createDatabase(array $args);

    /**
     * @param array $args
     * @return OperationResponse
     */
    public function updateDatabase(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function updateDatabaseDdl(array $args);

    /**
     * @param array $args
     * @return null
     */
    public function dropDatabase(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getDatabase(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getDatabaseDDL(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getDatabaseIamPolicy(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function setDatabaseIamPolicy(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function testDatabaseIamPermissions(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function createSession(array $args);

    /**
     * @param array $args
     * @return PromiseInterface
     */
    public function createSessionAsync(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function batchCreateSessions(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getSession(array $args);

    /**
     * @param array $args
     * @return null
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
     * @return array
     */
    public function executeBatchDml(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function beginTransaction(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function commit(array $args);

    /**
     * @param array $args
     * @return null
     */
    public function rollback(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function getOperation(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function cancelOperation(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function deleteOperation(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function listOperations(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function partitionQuery(array $args);

    /**
     * @param array $args
     * @return array
     */
    public function partitionRead(array $args);

    /**
     * @param array $args
     * @return \Generator
     */
    public function batchWrite(array $args);
}
