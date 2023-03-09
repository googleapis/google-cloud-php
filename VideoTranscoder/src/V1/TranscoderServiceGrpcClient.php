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
namespace Google\Cloud\Video\Transcoder\V1;

/**
 * Using the Transcoder API, you can queue asynchronous jobs for transcoding
 * media into various output formats. Output formats may include different
 * streaming standards such as HTTP Live Streaming (HLS) and Dynamic Adaptive
 * Streaming over HTTP (DASH). You can also customize jobs using advanced
 * features such as Digital Rights Management (DRM), audio equalization, content
 * concatenation, and digital ad-stitch ready content generation.
 */
class TranscoderServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a job in the specified region.
     * @param \Google\Cloud\Video\Transcoder\V1\CreateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateJob(\Google\Cloud\Video\Transcoder\V1\CreateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/CreateJob',
        $argument,
        ['\Google\Cloud\Video\Transcoder\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists jobs in the specified region.
     * @param \Google\Cloud\Video\Transcoder\V1\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobs(\Google\Cloud\Video\Transcoder\V1\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/ListJobs',
        $argument,
        ['\Google\Cloud\Video\Transcoder\V1\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the job data.
     * @param \Google\Cloud\Video\Transcoder\V1\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJob(\Google\Cloud\Video\Transcoder\V1\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/GetJob',
        $argument,
        ['\Google\Cloud\Video\Transcoder\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a job.
     * @param \Google\Cloud\Video\Transcoder\V1\DeleteJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteJob(\Google\Cloud\Video\Transcoder\V1\DeleteJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/DeleteJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a job template in the specified region.
     * @param \Google\Cloud\Video\Transcoder\V1\CreateJobTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateJobTemplate(\Google\Cloud\Video\Transcoder\V1\CreateJobTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/CreateJobTemplate',
        $argument,
        ['\Google\Cloud\Video\Transcoder\V1\JobTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists job templates in the specified region.
     * @param \Google\Cloud\Video\Transcoder\V1\ListJobTemplatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobTemplates(\Google\Cloud\Video\Transcoder\V1\ListJobTemplatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/ListJobTemplates',
        $argument,
        ['\Google\Cloud\Video\Transcoder\V1\ListJobTemplatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the job template data.
     * @param \Google\Cloud\Video\Transcoder\V1\GetJobTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJobTemplate(\Google\Cloud\Video\Transcoder\V1\GetJobTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/GetJobTemplate',
        $argument,
        ['\Google\Cloud\Video\Transcoder\V1\JobTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a job template.
     * @param \Google\Cloud\Video\Transcoder\V1\DeleteJobTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteJobTemplate(\Google\Cloud\Video\Transcoder\V1\DeleteJobTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.transcoder.v1.TranscoderService/DeleteJobTemplate',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
