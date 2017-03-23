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

interface ConnectionInterface
{
    /**
     * @param array $args [optional]
     */
    public function listConfigs(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function getConfig(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function listInstances(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function getInstance(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function createInstance(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function updateInstance(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function deleteInstance(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function getInstanceIamPolicy(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function setInstanceIamPolicy(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function testInstanceIamPermissions(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function listDatabases(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function createDatabase(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function updateDatabase(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function dropDatabase(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function getDatabaseDDL(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function getDatabaseIamPolicy(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function setDatabaseIamPolicy(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function testDatabaseIamPermissions(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function createSession(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function getSession(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function deleteSession(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function executeSql(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function read(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function beginTransaction(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function commit(array $args = []);

    /**
     * @param array $args [optional]
     */
    public function rollback(array $args = []);

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
}
