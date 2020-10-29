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
namespace Google\Cloud\RecaptchaEnterprise\V1;

/**
 * Service to determine the likelihood an event is legitimate.
 */
class RecaptchaEnterpriseServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates an Assessment of the likelihood an event is legitimate.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAssessment(\Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/CreateAssessment',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1\Assessment', 'decode'],
        $metadata, $options);
    }

    /**
     * Annotates a previously created Assessment to provide additional information
     * on whether the event turned out to be authentic or fradulent.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AnnotateAssessment(\Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/AnnotateAssessment',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new reCAPTCHA Enterprise key.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\CreateKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateKey(\Google\Cloud\RecaptchaEnterprise\V1\CreateKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/CreateKey',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1\Key', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the list of all keys that belong to a project.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\ListKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListKeys(\Google\Cloud\RecaptchaEnterprise\V1\ListKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/ListKeys',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1\ListKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified key.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\GetKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetKey(\Google\Cloud\RecaptchaEnterprise\V1\GetKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/GetKey',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1\Key', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified key.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\UpdateKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateKey(\Google\Cloud\RecaptchaEnterprise\V1\UpdateKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/UpdateKey',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1\Key', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified key.
     * @param \Google\Cloud\RecaptchaEnterprise\V1\DeleteKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteKey(\Google\Cloud\RecaptchaEnterprise\V1\DeleteKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService/DeleteKey',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
