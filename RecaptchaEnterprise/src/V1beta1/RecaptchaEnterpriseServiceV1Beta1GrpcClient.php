<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\RecaptchaEnterprise\V1beta1;

/**
 * Service to determine the likelihood an event is legitimate.
 */
class RecaptchaEnterpriseServiceV1Beta1GrpcClient extends \Grpc\BaseStub {

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
     * @param \Google\Cloud\RecaptchaEnterprise\V1beta1\CreateAssessmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateAssessment(\Google\Cloud\RecaptchaEnterprise\V1beta1\CreateAssessmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1beta1.RecaptchaEnterpriseServiceV1Beta1/CreateAssessment',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1beta1\Assessment', 'decode'],
        $metadata, $options);
    }

    /**
     * Annotates a previously created Assessment to provide additional information
     * on whether the event turned out to be authentic or fradulent.
     * @param \Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AnnotateAssessment(\Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recaptchaenterprise.v1beta1.RecaptchaEnterpriseServiceV1Beta1/AnnotateAssessment',
        $argument,
        ['\Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentResponse', 'decode'],
        $metadata, $options);
    }

}
