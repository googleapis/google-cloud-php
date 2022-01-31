<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\Monitoring\V3;

/**
 * The Group API lets you inspect and manage your
 * [groups](#google.monitoring.v3.Group).
 *
 * A group is a named filter that is used to identify
 * a collection of monitored resources. Groups are typically used to
 * mirror the physical and/or logical topology of the environment.
 * Because group membership is computed dynamically, monitored
 * resources that are started in the future are automatically placed
 * in matching groups. By using a group to name monitored resources in,
 * for example, an alert policy, the target of that alert policy is
 * updated automatically as monitored resources are added and removed
 * from the infrastructure.
 */
class GroupServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the existing groups.
     * @param \Google\Cloud\Monitoring\V3\ListGroupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGroups(\Google\Cloud\Monitoring\V3\ListGroupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.GroupService/ListGroups',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListGroupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single group.
     * @param \Google\Cloud\Monitoring\V3\GetGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGroup(\Google\Cloud\Monitoring\V3\GetGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.GroupService/GetGroup',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Group', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new group.
     * @param \Google\Cloud\Monitoring\V3\CreateGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateGroup(\Google\Cloud\Monitoring\V3\CreateGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.GroupService/CreateGroup',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Group', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing group.
     * You can change any group attributes except `name`.
     * @param \Google\Cloud\Monitoring\V3\UpdateGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGroup(\Google\Cloud\Monitoring\V3\UpdateGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.GroupService/UpdateGroup',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Group', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing group.
     * @param \Google\Cloud\Monitoring\V3\DeleteGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteGroup(\Google\Cloud\Monitoring\V3\DeleteGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.GroupService/DeleteGroup',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the monitored resources that are members of a group.
     * @param \Google\Cloud\Monitoring\V3\ListGroupMembersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGroupMembers(\Google\Cloud\Monitoring\V3\ListGroupMembersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.GroupService/ListGroupMembers',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListGroupMembersResponse', 'decode'],
        $metadata, $options);
    }

}
