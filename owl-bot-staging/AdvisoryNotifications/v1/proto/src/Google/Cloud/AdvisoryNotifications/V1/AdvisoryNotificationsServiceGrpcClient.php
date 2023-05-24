<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\AdvisoryNotifications\V1;

/**
 * Service to manage Security and Privacy Notifications.
 */
class AdvisoryNotificationsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists notifications under a given parent.
     * @param \Google\Cloud\AdvisoryNotifications\V1\ListNotificationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNotifications(\Google\Cloud\AdvisoryNotifications\V1\ListNotificationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.advisorynotifications.v1.AdvisoryNotificationsService/ListNotifications',
        $argument,
        ['\Google\Cloud\AdvisoryNotifications\V1\ListNotificationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a notification.
     * @param \Google\Cloud\AdvisoryNotifications\V1\GetNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNotification(\Google\Cloud\AdvisoryNotifications\V1\GetNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.advisorynotifications.v1.AdvisoryNotificationsService/GetNotification',
        $argument,
        ['\Google\Cloud\AdvisoryNotifications\V1\Notification', 'decode'],
        $metadata, $options);
    }

}
