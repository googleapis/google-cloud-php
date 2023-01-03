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
namespace Google\Cloud\ResourceSettings\V1;

/**
 * An interface to interact with resource settings and setting values throughout
 * the resource hierarchy.
 *
 * Services may surface a number of settings for users to control how their
 * resources behave. Values of settings applied on a given Cloud resource are
 * evaluated hierarchically and inherited by all descendants of that resource.
 *
 * For all requests, returns a `google.rpc.Status` with
 * `google.rpc.Code.PERMISSION_DENIED` if the IAM check fails or the `parent`
 * resource is not in a Cloud Organization.
 * For all requests, returns a `google.rpc.Status` with
 * `google.rpc.Code.INVALID_ARGUMENT` if the request is malformed.
 */
class ResourceSettingsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all the settings that are available on the Cloud resource `parent`.
     * @param \Google\Cloud\ResourceSettings\V1\ListSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSettings(\Google\Cloud\ResourceSettings\V1\ListSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcesettings.v1.ResourceSettingsService/ListSettings',
        $argument,
        ['\Google\Cloud\ResourceSettings\V1\ListSettingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a setting.
     *
     * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
     * setting does not exist.
     * @param \Google\Cloud\ResourceSettings\V1\GetSettingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSetting(\Google\Cloud\ResourceSettings\V1\GetSettingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcesettings.v1.ResourceSettingsService/GetSetting',
        $argument,
        ['\Google\Cloud\ResourceSettings\V1\Setting', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a setting.
     *
     * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
     * setting does not exist.
     * Returns a `google.rpc.Status` with `google.rpc.Code.FAILED_PRECONDITION` if
     * the setting is flagged as read only.
     * Returns a `google.rpc.Status` with `google.rpc.Code.ABORTED` if the etag
     * supplied in the request does not match the persisted etag of the setting
     * value.
     *
     * On success, the response will contain only `name`, `local_value` and
     * `etag`.  The `metadata` and `effective_value` cannot be updated through
     * this API.
     *
     * Note: the supplied setting will perform a full overwrite of the
     * `local_value` field.
     * @param \Google\Cloud\ResourceSettings\V1\UpdateSettingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSetting(\Google\Cloud\ResourceSettings\V1\UpdateSettingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcesettings.v1.ResourceSettingsService/UpdateSetting',
        $argument,
        ['\Google\Cloud\ResourceSettings\V1\Setting', 'decode'],
        $metadata, $options);
    }

}
