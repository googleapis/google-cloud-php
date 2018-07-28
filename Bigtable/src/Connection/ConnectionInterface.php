<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Connection;

/**
 * Represents a connection to Cloud Bigtable.
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     */
    public function createInstance(array $args);

    /**
     * @param array $args
     */
    public function getInstance(array $args);

    /**
     * @param array $args
     */
    public function listInstances(array $args);

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
    public function createCluster(array $args);

    /**
     * @param array $args
     */
    public function getCluster(array $args);

    /**
     * @param array $args
     */
    public function listClusters(array $args);

    /**
     * @param array $args
     */
    public function updateCluster(array $args);

    /**
     * @param array $args
     */
    public function deleteCluster(array $args);

    /**
     * @param array $args
     */
    public function createAppProfile(array $args);

    /**
     * @param array $args
     */
    public function getAppProfile(array $args);

    /**
     * @param array $args
     */
    public function listAppProfiles(array $args);

    /**
     * @param array $args
     */
    public function updateAppProfile(array $args);

    /**
     * @param array $args
     */
    public function deleteAppProfile(array $args);

    /**
     * @param array $args
     */
    public function getIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function setIamPolicy(array $args);

    /**
     * @param array $args
     */
    public function testIamPermissions(array $args);

    /**
     * @param array $args
     */
    public function createTable(array $args);

    /**
     * @param array $args
     */
    public function createTableFromSnapshot(array $args);

    /**
     * @param array $args
     */
    public function listTables(array $args);

    /**
     * @param array $args
     */
    public function getTable(array $args);

    /**
     * @param array $args
     */
    public function deleteTable(array $args);

    /**
     * @param array $args
     */
    public function modifyColumnFamilies(array $args);

    /**
     * @param array $args
     */
    public function dropRowRange(array $args);

    /**
     * @param array $args
     */
    public function checkConsistency(array $args);

    /**
     * @param array $args
     */
    public function generateConsistencyToken(array $args);

    /**
     * @param array $args
     */
    public function snapshotTable(array $args);

    /**
     * @param array $args
     */
    public function getSnapshot(array $args);

    /**
     * @param array $args
     */
    public function listSnapshots(array $args);

    /**
     * @param array $args
     */
    public function deleteSnapshot(array $args);

    /**
     * @param array $args
     */
    public function readRows(array $args);

    /**
     * @param array $args
     */
    public function sampleRowKeys(array $args);

    /**
     * @param array $args
     */
    public function mutateRow(array $args);

    /**
     * @param array $args
     */
    public function mutateRows(array $args);

    /**
     * @param array $args
     */
    public function checkAndMutateRow(array $args);

    /**
     * @param array $args
     */
    public function readModifyWriteRow(array $args);

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
