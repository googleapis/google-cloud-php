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
namespace Google\Cloud\AppEngine\V1;

/**
 * Manages instances of a version.
 */
class InstancesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the instances of a version.
     *
     * Tip: To aggregate details about instances over time, see the
     * [Stackdriver Monitoring API](https://cloud.google.com/monitoring/api/ref_v3/rest/v3/projects.timeSeries/list).
     * @param \Google\Cloud\AppEngine\V1\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\AppEngine\V1\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Instances/ListInstances',
        $argument,
        ['\Google\Cloud\AppEngine\V1\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets instance information.
     * @param \Google\Cloud\AppEngine\V1\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\AppEngine\V1\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Instances/GetInstance',
        $argument,
        ['\Google\Cloud\AppEngine\V1\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a running instance.
     *
     * The instance might be automatically recreated based on the scaling settings
     * of the version. For more information, see "How Instances are Managed"
     * ([standard environment](https://cloud.google.com/appengine/docs/standard/python/how-instances-are-managed) |
     * [flexible environment](https://cloud.google.com/appengine/docs/flexible/python/how-instances-are-managed)).
     *
     * To ensure that instances are not re-created and avoid getting billed, you
     * can stop all instances within the target version by changing the serving
     * status of the version to `STOPPED` with the
     * [`apps.services.versions.patch`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions/patch)
     * method.
     * @param \Google\Cloud\AppEngine\V1\DeleteInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstance(\Google\Cloud\AppEngine\V1\DeleteInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Instances/DeleteInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables debugging on a VM instance. This allows you to use the SSH
     * command to connect to the virtual machine where the instance lives.
     * While in "debug mode", the instance continues to serve live traffic.
     * You should delete the instance when you are done debugging and then
     * allow the system to take over and determine if another instance
     * should be started.
     *
     * Only applicable for instances in App Engine flexible environment.
     * @param \Google\Cloud\AppEngine\V1\DebugInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DebugInstance(\Google\Cloud\AppEngine\V1\DebugInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Instances/DebugInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
