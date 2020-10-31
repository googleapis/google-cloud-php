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
namespace Google\Cloud\Monitoring\V3;

/**
 * The Notification Channel API provides access to configuration that
 * controls how messages related to incidents are sent.
 */
class NotificationChannelServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the descriptors for supported channel types. The use of descriptors
     * makes it possible for new channel types to be dynamically added.
     * @param \Google\Cloud\Monitoring\V3\ListNotificationChannelDescriptorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNotificationChannelDescriptors(\Google\Cloud\Monitoring\V3\ListNotificationChannelDescriptorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/ListNotificationChannelDescriptors',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListNotificationChannelDescriptorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single channel descriptor. The descriptor indicates which fields
     * are expected / permitted for a notification channel of the given type.
     * @param \Google\Cloud\Monitoring\V3\GetNotificationChannelDescriptorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNotificationChannelDescriptor(\Google\Cloud\Monitoring\V3\GetNotificationChannelDescriptorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/GetNotificationChannelDescriptor',
        $argument,
        ['\Google\Cloud\Monitoring\V3\NotificationChannelDescriptor', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the notification channels that have been created for the project.
     * @param \Google\Cloud\Monitoring\V3\ListNotificationChannelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNotificationChannels(\Google\Cloud\Monitoring\V3\ListNotificationChannelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/ListNotificationChannels',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListNotificationChannelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single notification channel. The channel includes the relevant
     * configuration details with which the channel was created. However, the
     * response may truncate or omit passwords, API keys, or other private key
     * matter and thus the response may not be 100% identical to the information
     * that was supplied in the call to the create method.
     * @param \Google\Cloud\Monitoring\V3\GetNotificationChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNotificationChannel(\Google\Cloud\Monitoring\V3\GetNotificationChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/GetNotificationChannel',
        $argument,
        ['\Google\Cloud\Monitoring\V3\NotificationChannel', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new notification channel, representing a single notification
     * endpoint such as an email address, SMS number, or PagerDuty service.
     * @param \Google\Cloud\Monitoring\V3\CreateNotificationChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNotificationChannel(\Google\Cloud\Monitoring\V3\CreateNotificationChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/CreateNotificationChannel',
        $argument,
        ['\Google\Cloud\Monitoring\V3\NotificationChannel', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a notification channel. Fields not specified in the field mask
     * remain unchanged.
     * @param \Google\Cloud\Monitoring\V3\UpdateNotificationChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNotificationChannel(\Google\Cloud\Monitoring\V3\UpdateNotificationChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/UpdateNotificationChannel',
        $argument,
        ['\Google\Cloud\Monitoring\V3\NotificationChannel', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a notification channel.
     * @param \Google\Cloud\Monitoring\V3\DeleteNotificationChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteNotificationChannel(\Google\Cloud\Monitoring\V3\DeleteNotificationChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/DeleteNotificationChannel',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Causes a verification code to be delivered to the channel. The code
     * can then be supplied in `VerifyNotificationChannel` to verify the channel.
     * @param \Google\Cloud\Monitoring\V3\SendNotificationChannelVerificationCodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SendNotificationChannelVerificationCode(\Google\Cloud\Monitoring\V3\SendNotificationChannelVerificationCodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/SendNotificationChannelVerificationCode',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Requests a verification code for an already verified channel that can then
     * be used in a call to VerifyNotificationChannel() on a different channel
     * with an equivalent identity in the same or in a different project. This
     * makes it possible to copy a channel between projects without requiring
     * manual reverification of the channel. If the channel is not in the
     * verified state, this method will fail (in other words, this may only be
     * used if the SendNotificationChannelVerificationCode and
     * VerifyNotificationChannel paths have already been used to put the given
     * channel into the verified state).
     *
     * There is no guarantee that the verification codes returned by this method
     * will be of a similar structure or form as the ones that are delivered
     * to the channel via SendNotificationChannelVerificationCode; while
     * VerifyNotificationChannel() will recognize both the codes delivered via
     * SendNotificationChannelVerificationCode() and returned from
     * GetNotificationChannelVerificationCode(), it is typically the case that
     * the verification codes delivered via
     * SendNotificationChannelVerificationCode() will be shorter and also
     * have a shorter expiration (e.g. codes such as "G-123456") whereas
     * GetVerificationCode() will typically return a much longer, websafe base
     * 64 encoded string that has a longer expiration time.
     * @param \Google\Cloud\Monitoring\V3\GetNotificationChannelVerificationCodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNotificationChannelVerificationCode(\Google\Cloud\Monitoring\V3\GetNotificationChannelVerificationCodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/GetNotificationChannelVerificationCode',
        $argument,
        ['\Google\Cloud\Monitoring\V3\GetNotificationChannelVerificationCodeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Verifies a `NotificationChannel` by proving receipt of the code
     * delivered to the channel as a result of calling
     * `SendNotificationChannelVerificationCode`.
     * @param \Google\Cloud\Monitoring\V3\VerifyNotificationChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function VerifyNotificationChannel(\Google\Cloud\Monitoring\V3\VerifyNotificationChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.NotificationChannelService/VerifyNotificationChannel',
        $argument,
        ['\Google\Cloud\Monitoring\V3\NotificationChannel', 'decode'],
        $metadata, $options);
    }

}
