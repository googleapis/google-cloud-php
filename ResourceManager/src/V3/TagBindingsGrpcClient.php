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
namespace Google\Cloud\ResourceManager\V3;

/**
 * Allow users to create and manage TagBindings between TagValues and
 * different cloud resources throughout the GCP resource hierarchy.
 */
class TagBindingsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the TagBindings for the given cloud resource, as specified with
     * `parent`.
     *
     * NOTE: The `parent` field is expected to be a full resource name:
     * https://cloud.google.com/apis/design/resource_names#full_resource_name
     * @param \Google\Cloud\ResourceManager\V3\ListTagBindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTagBindings(\Google\Cloud\ResourceManager\V3\ListTagBindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagBindings/ListTagBindings',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\ListTagBindingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a TagBinding between a TagValue and a cloud resource
     * (currently project, folder, or organization).
     * @param \Google\Cloud\ResourceManager\V3\CreateTagBindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTagBinding(\Google\Cloud\ResourceManager\V3\CreateTagBindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagBindings/CreateTagBinding',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TagBinding.
     * @param \Google\Cloud\ResourceManager\V3\DeleteTagBindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTagBinding(\Google\Cloud\ResourceManager\V3\DeleteTagBindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagBindings/DeleteTagBinding',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
