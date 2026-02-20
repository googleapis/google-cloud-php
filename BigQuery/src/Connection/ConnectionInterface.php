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

namespace Google\Cloud\BigQuery\Connection;

use Google\Cloud\Core\Upload\AbstractUploader;

/**
 * Represents a connection to
 * [BigQuery](https://cloud.google.com/bigquery/).
 *
 * @internal
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     * @return array
     */
    public function deleteDataset(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function patchDataset(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getDataset(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listDatasets(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function insertDataset(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function deleteTable(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function patchTable(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getTable(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function insertTable(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listTables(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listTableData(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function insertAllTableData(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function query(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getQueryResults(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getJob(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listJobs(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function cancelJob(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function insertJob(array $args = []);

    /**
     * @param array $args
     * @return AbstractUploader
     */
    public function insertJobUpload(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getServiceAccount(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getModel(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function deleteModel(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function patchModel(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listModels(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function insertRoutine(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function updateRoutine(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getRoutine(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function deleteRoutine(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listRoutines(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getTableIamPolicy(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function setTableIamPolicy(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function testTableIamPermissions(array $args = []);
}
