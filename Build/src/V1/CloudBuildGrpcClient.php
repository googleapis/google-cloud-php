<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\Build\V1;

/**
 * Creates and manages builds on Google Cloud Platform.
 *
 * The main concept used by this API is a `Build`, which describes the location
 * of the source to build, how to build the source, and where to store the
 * built artifacts, if any.
 *
 * A user can list previously-requested builds or get builds by their ID to
 * determine the status of the build.
 */
class CloudBuildGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Starts a build with the specified configuration.
     *
     * This method returns a long-running `Operation`, which includes the build
     * ID. Pass the build ID to `GetBuild` to determine the build status (such as
     * `SUCCESS` or `FAILURE`).
     * @param \Google\Cloud\Build\V1\CreateBuildRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBuild(\Google\Cloud\Build\V1\CreateBuildRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/CreateBuild',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about a previously requested build.
     *
     * The `Build` that is returned includes its status (such as `SUCCESS`,
     * `FAILURE`, or `WORKING`), and timing information.
     * @param \Google\Cloud\Build\V1\GetBuildRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBuild(\Google\Cloud\Build\V1\GetBuildRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/GetBuild',
        $argument,
        ['\Google\Cloud\Build\V1\Build', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists previously requested builds.
     *
     * Previously requested builds may still be in-progress, or may have finished
     * successfully or unsuccessfully.
     * @param \Google\Cloud\Build\V1\ListBuildsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBuilds(\Google\Cloud\Build\V1\ListBuildsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/ListBuilds',
        $argument,
        ['\Google\Cloud\Build\V1\ListBuildsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a build in progress.
     * @param \Google\Cloud\Build\V1\CancelBuildRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelBuild(\Google\Cloud\Build\V1\CancelBuildRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/CancelBuild',
        $argument,
        ['\Google\Cloud\Build\V1\Build', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new build based on the specified build.
     *
     * This method creates a new build using the original build request, which may
     * or may not result in an identical build.
     *
     * For triggered builds:
     *
     * * Triggered builds resolve to a precise revision; therefore a retry of a
     * triggered build will result in a build that uses the same revision.
     *
     * For non-triggered builds that specify `RepoSource`:
     *
     * * If the original build built from the tip of a branch, the retried build
     * will build from the tip of that branch, which may not be the same revision
     * as the original build.
     * * If the original build specified a commit sha or revision ID, the retried
     * build will use the identical source.
     *
     * For builds that specify `StorageSource`:
     *
     * * If the original build pulled source from Google Cloud Storage without
     * specifying the generation of the object, the new build will use the current
     * object, which may be different from the original build source.
     * * If the original build pulled source from Cloud Storage and specified the
     * generation of the object, the new build will attempt to use the same
     * object, which may or may not be available depending on the bucket's
     * lifecycle management settings.
     * @param \Google\Cloud\Build\V1\RetryBuildRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RetryBuild(\Google\Cloud\Build\V1\RetryBuildRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/RetryBuild',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new `BuildTrigger`.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\CreateBuildTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBuildTrigger(\Google\Cloud\Build\V1\CreateBuildTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/CreateBuildTrigger',
        $argument,
        ['\Google\Cloud\Build\V1\BuildTrigger', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about a `BuildTrigger`.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\GetBuildTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBuildTrigger(\Google\Cloud\Build\V1\GetBuildTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/GetBuildTrigger',
        $argument,
        ['\Google\Cloud\Build\V1\BuildTrigger', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists existing `BuildTrigger`s.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\ListBuildTriggersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBuildTriggers(\Google\Cloud\Build\V1\ListBuildTriggersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/ListBuildTriggers',
        $argument,
        ['\Google\Cloud\Build\V1\ListBuildTriggersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a `BuildTrigger` by its project ID and trigger ID.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\DeleteBuildTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBuildTrigger(\Google\Cloud\Build\V1\DeleteBuildTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/DeleteBuildTrigger',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a `BuildTrigger` by its project ID and trigger ID.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\UpdateBuildTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBuildTrigger(\Google\Cloud\Build\V1\UpdateBuildTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/UpdateBuildTrigger',
        $argument,
        ['\Google\Cloud\Build\V1\BuildTrigger', 'decode'],
        $metadata, $options);
    }

    /**
     * Runs a `BuildTrigger` at a particular source revision.
     * @param \Google\Cloud\Build\V1\RunBuildTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunBuildTrigger(\Google\Cloud\Build\V1\RunBuildTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/RunBuildTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * ReceiveTriggerWebhook [Experimental] is called when the API receives a
     * webhook request targeted at a specific trigger.
     * @param \Google\Cloud\Build\V1\ReceiveTriggerWebhookRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReceiveTriggerWebhook(\Google\Cloud\Build\V1\ReceiveTriggerWebhookRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/ReceiveTriggerWebhook',
        $argument,
        ['\Google\Cloud\Build\V1\ReceiveTriggerWebhookResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a `WorkerPool` to run the builds, and returns the new worker pool.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\CreateWorkerPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateWorkerPool(\Google\Cloud\Build\V1\CreateWorkerPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/CreateWorkerPool',
        $argument,
        ['\Google\Cloud\Build\V1\WorkerPool', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about a `WorkerPool`.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\GetWorkerPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWorkerPool(\Google\Cloud\Build\V1\GetWorkerPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/GetWorkerPool',
        $argument,
        ['\Google\Cloud\Build\V1\WorkerPool', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a `WorkerPool` by its project ID and WorkerPool name.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\DeleteWorkerPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteWorkerPool(\Google\Cloud\Build\V1\DeleteWorkerPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/DeleteWorkerPool',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a `WorkerPool`.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\UpdateWorkerPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateWorkerPool(\Google\Cloud\Build\V1\UpdateWorkerPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/UpdateWorkerPool',
        $argument,
        ['\Google\Cloud\Build\V1\WorkerPool', 'decode'],
        $metadata, $options);
    }

    /**
     * List project's `WorkerPools`.
     *
     * This API is experimental.
     * @param \Google\Cloud\Build\V1\ListWorkerPoolsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListWorkerPools(\Google\Cloud\Build\V1\ListWorkerPoolsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v1.CloudBuild/ListWorkerPools',
        $argument,
        ['\Google\Cloud\Build\V1\ListWorkerPoolsResponse', 'decode'],
        $metadata, $options);
    }

}
