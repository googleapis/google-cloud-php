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
namespace Google\Cloud\Speech\V1p1beta1;

/**
 * Service that implements Google Cloud Speech Adaptation API.
 */
class AdaptationGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a set of phrase hints. Each item in the set can be a single word or
     * a multi-word phrase. The items in the PhraseSet are favored by the
     * recognition model when you send a call that includes the PhraseSet.
     * @param \Google\Cloud\Speech\V1p1beta1\CreatePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePhraseSet(\Google\Cloud\Speech\V1p1beta1\CreatePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/CreatePhraseSet',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\PhraseSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a phrase set.
     * @param \Google\Cloud\Speech\V1p1beta1\GetPhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPhraseSet(\Google\Cloud\Speech\V1p1beta1\GetPhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/GetPhraseSet',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\PhraseSet', 'decode'],
        $metadata, $options);
    }

    /**
     * List phrase sets.
     * @param \Google\Cloud\Speech\V1p1beta1\ListPhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPhraseSet(\Google\Cloud\Speech\V1p1beta1\ListPhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/ListPhraseSet',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\ListPhraseSetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a phrase set.
     * @param \Google\Cloud\Speech\V1p1beta1\UpdatePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePhraseSet(\Google\Cloud\Speech\V1p1beta1\UpdatePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/UpdatePhraseSet',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\PhraseSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a phrase set.
     * @param \Google\Cloud\Speech\V1p1beta1\DeletePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePhraseSet(\Google\Cloud\Speech\V1p1beta1\DeletePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/DeletePhraseSet',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a custom class.
     * @param \Google\Cloud\Speech\V1p1beta1\CreateCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomClass(\Google\Cloud\Speech\V1p1beta1\CreateCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/CreateCustomClass',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\CustomClass', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a custom class.
     * @param \Google\Cloud\Speech\V1p1beta1\GetCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomClass(\Google\Cloud\Speech\V1p1beta1\GetCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/GetCustomClass',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\CustomClass', 'decode'],
        $metadata, $options);
    }

    /**
     * List custom classes.
     * @param \Google\Cloud\Speech\V1p1beta1\ListCustomClassesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomClasses(\Google\Cloud\Speech\V1p1beta1\ListCustomClassesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/ListCustomClasses',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\ListCustomClassesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a custom class.
     * @param \Google\Cloud\Speech\V1p1beta1\UpdateCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomClass(\Google\Cloud\Speech\V1p1beta1\UpdateCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/UpdateCustomClass',
        $argument,
        ['\Google\Cloud\Speech\V1p1beta1\CustomClass', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a custom class.
     * @param \Google\Cloud\Speech\V1p1beta1\DeleteCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCustomClass(\Google\Cloud\Speech\V1p1beta1\DeleteCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1p1beta1.Adaptation/DeleteCustomClass',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
