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
namespace Google\Cloud\Functions\V2;

/**
 * Google Cloud Functions is used to deploy functions that are executed by
 * Google in response to various events. Data connected with that event is
 * passed to a function as the input data.
 *
 * A **function** is a resource which describes a function that should be
 * executed and how it is triggered.
 */
class FunctionServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns a function with the given name from the requested project.
     * @param \Google\Cloud\Functions\V2\GetFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFunction(\Google\Cloud\Functions\V2\GetFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/GetFunction',
        $argument,
        ['\Google\Cloud\Functions\V2\PBFunction', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of functions that belong to the requested project.
     * @param \Google\Cloud\Functions\V2\ListFunctionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFunctions(\Google\Cloud\Functions\V2\ListFunctionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/ListFunctions',
        $argument,
        ['\Google\Cloud\Functions\V2\ListFunctionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new function. If a function with the given name already exists in
     * the specified project, the long running operation will return
     * `ALREADY_EXISTS` error.
     * @param \Google\Cloud\Functions\V2\CreateFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFunction(\Google\Cloud\Functions\V2\CreateFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/CreateFunction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates existing function.
     * @param \Google\Cloud\Functions\V2\UpdateFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFunction(\Google\Cloud\Functions\V2\UpdateFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/UpdateFunction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a function with the given name from the specified project. If the
     * given function is used by some trigger, the trigger will be updated to
     * remove this function.
     * @param \Google\Cloud\Functions\V2\DeleteFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFunction(\Google\Cloud\Functions\V2\DeleteFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/DeleteFunction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a signed URL for uploading a function source code.
     * For more information about the signed URL usage see:
     * https://cloud.google.com/storage/docs/access-control/signed-urls.
     * Once the function source code upload is complete, the used signed
     * URL should be provided in CreateFunction or UpdateFunction request
     * as a reference to the function source code.
     *
     * When uploading source code to the generated signed URL, please follow
     * these restrictions:
     *
     * * Source file type should be a zip file.
     * * No credentials should be attached - the signed URLs provide access to the
     *   target bucket using internal service identity; if credentials were
     *   attached, the identity from the credentials would be used, but that
     *   identity does not have permissions to upload files to the URL.
     *
     * When making a HTTP PUT request, these two headers need to be specified:
     *
     * * `content-type: application/zip`
     *
     * And this header SHOULD NOT be specified:
     *
     * * `Authorization: Bearer YOUR_TOKEN`
     * @param \Google\Cloud\Functions\V2\GenerateUploadUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateUploadUrl(\Google\Cloud\Functions\V2\GenerateUploadUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/GenerateUploadUrl',
        $argument,
        ['\Google\Cloud\Functions\V2\GenerateUploadUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a signed URL for downloading deployed function source code.
     * The URL is only valid for a limited period and should be used within
     * 30 minutes of generation.
     * For more information about the signed URL usage see:
     * https://cloud.google.com/storage/docs/access-control/signed-urls
     * @param \Google\Cloud\Functions\V2\GenerateDownloadUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateDownloadUrl(\Google\Cloud\Functions\V2\GenerateDownloadUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/GenerateDownloadUrl',
        $argument,
        ['\Google\Cloud\Functions\V2\GenerateDownloadUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of runtimes that are supported for the requested project.
     * @param \Google\Cloud\Functions\V2\ListRuntimesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRuntimes(\Google\Cloud\Functions\V2\ListRuntimesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v2.FunctionService/ListRuntimes',
        $argument,
        ['\Google\Cloud\Functions\V2\ListRuntimesResponse', 'decode'],
        $metadata, $options);
    }

}
