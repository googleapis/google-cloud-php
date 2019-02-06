<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC.
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
namespace Google\Cloud\Talent\V4beta1;

/**
 * A service that handles resume parsing.
 */
class ResumeServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Parses a resume into a [Profile][google.cloud.talent.v4beta1.Profile]. The API attempts to fill out the
     * following profile fields if present within the resume:
     *
     * * personNames
     * * addresses
     * * emailAddress
     * * phoneNumbers
     * * personalUris
     * * employmentRecords
     * * educationRecords
     * * skills
     *
     * Note that some attributes in these fields may not be populated if they're
     * not present within the resume or unrecognizable by the resume parser.
     *
     * This API does not save the resume or profile. To create a profile from this
     * resume, clients need to call the CreateProfile method again with the
     * profile returned.
     *
     * This API supports the following list of formats:
     *
     * * PDF
     * * TXT
     * * DOC
     * * RTF
     * * DOCX
     *
     * An error is thrown if the input format is not supported.
     * @param \Google\Cloud\Talent\V4beta1\ParseResumeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ParseResume(\Google\Cloud\Talent\V4beta1\ParseResumeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ResumeService/ParseResume',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ParseResumeResponse', 'decode'],
        $metadata, $options);
    }

}
