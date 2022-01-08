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
namespace Google\Cloud\Functions\V1;

/**
 * A service that application uses to manipulate triggers and functions.
 */
class CloudFunctionsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns a list of functions that belong to the requested project.
     * @param \Google\Cloud\Functions\V1\ListFunctionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFunctions(\Google\Cloud\Functions\V1\ListFunctionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/ListFunctions',
        $argument,
        ['\Google\Cloud\Functions\V1\ListFunctionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a function with the given name from the requested project.
     * @param \Google\Cloud\Functions\V1\GetFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFunction(\Google\Cloud\Functions\V1\GetFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/GetFunction',
        $argument,
        ['\Google\Cloud\Functions\V1\CloudFunction', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new function. If a function with the given name already exists in
     * the specified project, the long running operation will return
     * `ALREADY_EXISTS` error.
     * @param \Google\Cloud\Functions\V1\CreateFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFunction(\Google\Cloud\Functions\V1\CreateFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/CreateFunction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates existing function.
     * @param \Google\Cloud\Functions\V1\UpdateFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFunction(\Google\Cloud\Functions\V1\UpdateFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/UpdateFunction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a function with the given name from the specified project. If the
     * given function is used by some trigger, the trigger will be updated to
     * remove this function.
     * @param \Google\Cloud\Functions\V1\DeleteFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFunction(\Google\Cloud\Functions\V1\DeleteFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/DeleteFunction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Synchronously invokes a deployed Cloud Function. To be used for testing
     * purposes as very limited traffic is allowed. For more information on
     * the actual limits, refer to
     * [Rate Limits](https://cloud.google.com/functions/quotas#rate_limits).
     * @param \Google\Cloud\Functions\V1\CallFunctionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CallFunction(\Google\Cloud\Functions\V1\CallFunctionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/CallFunction',
        $argument,
        ['\Google\Cloud\Functions\V1\CallFunctionResponse', 'decode'],
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
     * * Source file size should not exceed 100MB limit.
     * * No credentials should be attached - the signed URLs provide access to the
     *   target bucket using internal service identity; if credentials were
     *   attached, the identity from the credentials would be used, but that
     *   identity does not have permissions to upload files to the URL.
     *
     * When making a HTTP PUT request, these two headers need to be specified:
     *
     * * `content-type: application/zip`
     * * `x-goog-content-length-range: 0,104857600`
     *
     * And this header SHOULD NOT be specified:
     *
     * * `Authorization: Bearer YOUR_TOKEN`
     * @param \Google\Cloud\Functions\V1\GenerateUploadUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateUploadUrl(\Google\Cloud\Functions\V1\GenerateUploadUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/GenerateUploadUrl',
        $argument,
        ['\Google\Cloud\Functions\V1\GenerateUploadUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a signed URL for downloading deployed function source code.
     * The URL is only valid for a limited period and should be used within
     * minutes after generation.
     * For more information about the signed URL usage see:
     * https://cloud.google.com/storage/docs/access-control/signed-urls
     * @param \Google\Cloud\Functions\V1\GenerateDownloadUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateDownloadUrl(\Google\Cloud\Functions\V1\GenerateDownloadUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/GenerateDownloadUrl',
        $argument,
        ['\Google\Cloud\Functions\V1\GenerateDownloadUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the IAM access control policy on the specified function.
     * Replaces any existing policy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM access control policy for a function.
     * Returns an empty policy if the function exists and does not have a policy
     * set.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Tests the specified permissions against the IAM access control policy
     * for a function.
     * If the function does not exist, this will return an empty set of
     * permissions, not a NOT_FOUND error.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.functions.v1.CloudFunctionsService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
