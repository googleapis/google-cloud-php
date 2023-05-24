<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\DataCatalog\Lineage\V1;

/**
 * Lineage is used to track data flows between assets over time. You can
 * create [LineageEvents][google.cloud.datacatalog.lineage.v1.LineageEvent]
 * to record lineage between multiple sources and a single target, for
 * example, when table data is based on data from multiple tables.
 */
class LineageGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new process.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\CreateProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateProcess(\Google\Cloud\DataCatalog\Lineage\V1\CreateProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/CreateProcess',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\Process', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a process.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\UpdateProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateProcess(\Google\Cloud\DataCatalog\Lineage\V1\UpdateProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/UpdateProcess',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\Process', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of the specified process.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\GetProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProcess(\Google\Cloud\DataCatalog\Lineage\V1\GetProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/GetProcess',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\Process', 'decode'],
        $metadata, $options);
    }

    /**
     * List processes in the given project and location. List order is descending
     * by insertion time.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\ListProcessesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProcesses(\Google\Cloud\DataCatalog\Lineage\V1\ListProcessesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/ListProcesses',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\ListProcessesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the process with the specified name.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\DeleteProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProcess(\Google\Cloud\DataCatalog\Lineage\V1\DeleteProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/DeleteProcess',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new run.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\CreateRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRun(\Google\Cloud\DataCatalog\Lineage\V1\CreateRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/CreateRun',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\Run', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a run.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\UpdateRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRun(\Google\Cloud\DataCatalog\Lineage\V1\UpdateRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/UpdateRun',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\Run', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of the specified run.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\GetRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRun(\Google\Cloud\DataCatalog\Lineage\V1\GetRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/GetRun',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\Run', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists runs in the given project and location. List order is descending by
     * `start_time`.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\ListRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRuns(\Google\Cloud\DataCatalog\Lineage\V1\ListRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/ListRuns',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\ListRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the run with the specified name.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\DeleteRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRun(\Google\Cloud\DataCatalog\Lineage\V1\DeleteRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/DeleteRun',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new lineage event.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\CreateLineageEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateLineageEvent(\Google\Cloud\DataCatalog\Lineage\V1\CreateLineageEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/CreateLineageEvent',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\LineageEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a specified lineage event.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\GetLineageEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLineageEvent(\Google\Cloud\DataCatalog\Lineage\V1\GetLineageEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/GetLineageEvent',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\LineageEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists lineage events in the given project and location. The list order is
     * not defined.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\ListLineageEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLineageEvents(\Google\Cloud\DataCatalog\Lineage\V1\ListLineageEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/ListLineageEvents',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\ListLineageEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the lineage event with the specified name.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\DeleteLineageEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteLineageEvent(\Google\Cloud\DataCatalog\Lineage\V1\DeleteLineageEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/DeleteLineageEvent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve a list of links connected to a specific asset.
     * Links represent the data flow between **source** (upstream)
     * and **target** (downstream) assets in transformation pipelines.
     * Links are stored in the same project as the Lineage Events that create
     * them.
     *
     * You can retrieve links in every project where you have the
     * `datalineage.events.get` permission. The project provided in the URL
     * is used for Billing and Quota.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\SearchLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchLinks(\Google\Cloud\DataCatalog\Lineage\V1\SearchLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/SearchLinks',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\SearchLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve information about LineageProcesses associated with specific
     * links. LineageProcesses are transformation pipelines that result in data
     * flowing from **source** to **target** assets. Links between assets
     * represent this operation.
     *
     * If you have specific link names, you can use this method to
     * verify which LineageProcesses contribute to creating those links.
     * See the
     * [SearchLinks][google.cloud.datacatalog.lineage.v1.Lineage.SearchLinks]
     * method for more information on how to retrieve link name.
     *
     * You can retrieve the LineageProcess information in every project where you
     * have the `datalineage.events.get` permission. The project provided in the
     * URL is used for Billing and Quota.
     * @param \Google\Cloud\DataCatalog\Lineage\V1\BatchSearchLinkProcessesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchSearchLinkProcesses(\Google\Cloud\DataCatalog\Lineage\V1\BatchSearchLinkProcessesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.lineage.v1.Lineage/BatchSearchLinkProcesses',
        $argument,
        ['\Google\Cloud\DataCatalog\Lineage\V1\BatchSearchLinkProcessesResponse', 'decode'],
        $metadata, $options);
    }

}
