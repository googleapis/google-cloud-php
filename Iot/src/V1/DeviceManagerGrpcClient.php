<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google Inc.
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
namespace Google\Cloud\Iot\V1;

/**
 * Internet of things (IoT) service. Allows to manipulate device registry
 * instances and the registration of devices (Things) to the cloud.
 */
class DeviceManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a device registry that contains devices.
     * @param \Google\Cloud\Iot\V1\CreateDeviceRegistryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateDeviceRegistry(\Google\Cloud\Iot\V1\CreateDeviceRegistryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/CreateDeviceRegistry',
        $argument,
        ['\Google\Cloud\Iot\V1\DeviceRegistry', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a device registry configuration.
     * @param \Google\Cloud\Iot\V1\GetDeviceRegistryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetDeviceRegistry(\Google\Cloud\Iot\V1\GetDeviceRegistryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/GetDeviceRegistry',
        $argument,
        ['\Google\Cloud\Iot\V1\DeviceRegistry', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a device registry configuration.
     * @param \Google\Cloud\Iot\V1\UpdateDeviceRegistryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateDeviceRegistry(\Google\Cloud\Iot\V1\UpdateDeviceRegistryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/UpdateDeviceRegistry',
        $argument,
        ['\Google\Cloud\Iot\V1\DeviceRegistry', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a device registry configuration.
     * @param \Google\Cloud\Iot\V1\DeleteDeviceRegistryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteDeviceRegistry(\Google\Cloud\Iot\V1\DeleteDeviceRegistryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/DeleteDeviceRegistry',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists device registries.
     * @param \Google\Cloud\Iot\V1\ListDeviceRegistriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListDeviceRegistries(\Google\Cloud\Iot\V1\ListDeviceRegistriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/ListDeviceRegistries',
        $argument,
        ['\Google\Cloud\Iot\V1\ListDeviceRegistriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a device in a device registry.
     * @param \Google\Cloud\Iot\V1\CreateDeviceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateDevice(\Google\Cloud\Iot\V1\CreateDeviceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/CreateDevice',
        $argument,
        ['\Google\Cloud\Iot\V1\Device', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details about a device.
     * @param \Google\Cloud\Iot\V1\GetDeviceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetDevice(\Google\Cloud\Iot\V1\GetDeviceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/GetDevice',
        $argument,
        ['\Google\Cloud\Iot\V1\Device', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a device.
     * @param \Google\Cloud\Iot\V1\UpdateDeviceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateDevice(\Google\Cloud\Iot\V1\UpdateDeviceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/UpdateDevice',
        $argument,
        ['\Google\Cloud\Iot\V1\Device', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a device.
     * @param \Google\Cloud\Iot\V1\DeleteDeviceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteDevice(\Google\Cloud\Iot\V1\DeleteDeviceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/DeleteDevice',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * List devices in a device registry.
     * @param \Google\Cloud\Iot\V1\ListDevicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListDevices(\Google\Cloud\Iot\V1\ListDevicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/ListDevices',
        $argument,
        ['\Google\Cloud\Iot\V1\ListDevicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies the configuration for the device, which is eventually sent from
     * the Cloud IoT Core servers. Returns the modified configuration version and
     * its metadata.
     * @param \Google\Cloud\Iot\V1\ModifyCloudToDeviceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ModifyCloudToDeviceConfig(\Google\Cloud\Iot\V1\ModifyCloudToDeviceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/ModifyCloudToDeviceConfig',
        $argument,
        ['\Google\Cloud\Iot\V1\DeviceConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the last few versions of the device configuration in descending
     * order (i.e.: newest first).
     * @param \Google\Cloud\Iot\V1\ListDeviceConfigVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListDeviceConfigVersions(\Google\Cloud\Iot\V1\ListDeviceConfigVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/ListDeviceConfigVersions',
        $argument,
        ['\Google\Cloud\Iot\V1\ListDeviceConfigVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the last few versions of the device state in descending order (i.e.:
     * newest first).
     * @param \Google\Cloud\Iot\V1\ListDeviceStatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListDeviceStates(\Google\Cloud\Iot\V1\ListDeviceStatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/ListDeviceStates',
        $argument,
        ['\Google\Cloud\Iot\V1\ListDeviceStatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on the specified resource. Replaces any
     * existing policy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a resource.
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on the specified resource.
     * If the resource does not exist, this will return an empty set of
     * permissions, not a NOT_FOUND error.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
