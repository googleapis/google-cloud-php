<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC
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
 * Internet of Things (IoT) service. Securely connect and manage IoT devices.
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
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
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sends a command to the specified device. In order for a device to be able
     * to receive commands, it must:
     * 1) be connected to Cloud IoT Core using the MQTT protocol, and
     * 2) be subscribed to the group of MQTT topics specified by
     *    /devices/{device-id}/commands/#. This subscription will receive commands
     *    at the top-level topic /devices/{device-id}/commands as well as commands
     *    for subfolders, like /devices/{device-id}/commands/subfolder.
     *    Note that subscribing to specific subfolders is not supported.
     * If the command could not be delivered to the device, this method will
     * return an error; in particular, if the device is not subscribed, this
     * method will return FAILED_PRECONDITION. Otherwise, this method will
     * return OK. If the subscription is QoS 1, at least once delivery will be
     * guaranteed; for QoS 0, no acknowledgment will be expected from the device.
     * @param \Google\Cloud\Iot\V1\SendCommandToDeviceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SendCommandToDevice(\Google\Cloud\Iot\V1\SendCommandToDeviceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/SendCommandToDevice',
        $argument,
        ['\Google\Cloud\Iot\V1\SendCommandToDeviceResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Associates the device with the gateway.
     * @param \Google\Cloud\Iot\V1\BindDeviceToGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BindDeviceToGateway(\Google\Cloud\Iot\V1\BindDeviceToGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/BindDeviceToGateway',
        $argument,
        ['\Google\Cloud\Iot\V1\BindDeviceToGatewayResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the association between the device and the gateway.
     * @param \Google\Cloud\Iot\V1\UnbindDeviceFromGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UnbindDeviceFromGateway(\Google\Cloud\Iot\V1\UnbindDeviceFromGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iot.v1.DeviceManager/UnbindDeviceFromGateway',
        $argument,
        ['\Google\Cloud\Iot\V1\UnbindDeviceFromGatewayResponse', 'decode'],
        $metadata, $options);
    }

}
