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

namespace Google\Cloud\Bigtable;

/**
* Represents a connection to Cloud Bigtable.
*/
interface ConnectionInterface
{

    /**
    * @param array $args
    */
    public function CreateInstance(array $args);

    /**
    * @param array $args
    */
    public function GetInstance(array $args);

    /**
    * @param array $args
    */
    public function ListInstances(array $args);

    /**
    * @param array $args
    */
    public function UpdateInstance(array $args);

    /**
    * @param array $args
    */
    public function PartialUpdateInstance(array $args);

    /**
    * @param array $args
    */
    public function DeleteInstance(array $args);

    /**
    * @param array $args
    */
    public function CreateCluster(array $args);

    /**
    * @param array $args
    */
    public function GetCluster(array $args);

    /**
    * @param array $args
    */
    public function ListClusters(array $args);

    /**
    * @param array $args
    */
    public function UpdateCluster(array $args);

    /**
    * @param array $args
    */
    public function DeleteCluster(array $args);

    /**
    * @param array $args
    */
    public function CreateAppProfile(array $args);

    /**
    * @param array $args
    */
    public function GetAppProfile(array $args);

    /**
    * @param array $args
    */
    public function ListAppProfiles(array $args);

    /**
    * @param array $args
    */
    public function UpdateAppProfile(array $args);

    /**
    * @param array $args
    */
    public function DeleteAppProfile(array $args);

    /**
    * @param array $args
    */
    public function GetIamPolicy(array $args);

    /**
    * @param array $args
    */
    public function SetIamPolicy(array $args);
    
    /**
    * @param array $args
    */
    public function CreateTable(array $args);
    
    /**
    * @param array $args
    */
    public function CreateTableFromSnapshot(array $args);
    
    /**
    * @param array $args
    */
    public function ListTables(array $args);
    
    /**
    * @param array $args
    */
    public function GetTable(array $args);

    /**
    * @param array $args
    */
    public function DeleteTable(array $args);

    /**
    * @param array $args
    */
    public function ModifyColumnFamilies(array $args);

    /**
    * @param array $args
    */
    public function DropRowRange(array $args);

    /**
    * @param array $args
    */
    public function GenerateConsistencyToken(array $args);

    /**
    * @param array $args
    */
    public function CheckConsistency(array $args);

    /**
    * @param array $args
    */
    public function SnapshotTable(array $args);

    /**
    * @param array $args
    */
    public function GetSnapshot(array $args);

    /**
    * @param array $args
    */
    public function ListSnapshots(array $args);

    /**
    * @param array $args
    */
    public function DeleteSnapshot(array $args);

    /**
    * @param array $args
    */
    public function ReadRows(array $args);

    /**
    * @param array $args
    */
    public function SampleRowKeys(array $args);

    /**
    * @param array $args
    */
    public function MutateRow(array $args);
    
    /**
    * @param array $args
    */
    public function MutateRows(array $args);
    
    /**
    * @param array $args
    */
    public function CheckAndMutateRow(array $args);

    /**
    * @param array $args
    */
    public function ReadModifyWriteRow(array $args);
}