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
namespace Google\Cloud\AppEngine\V1;

/**
 * Manages App Engine applications.
 */
class ApplicationsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets information about an application.
     * @param \Google\Cloud\AppEngine\V1\GetApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApplication(\Google\Cloud\AppEngine\V1\GetApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Applications/GetApplication',
        $argument,
        ['\Google\Cloud\AppEngine\V1\Application', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an App Engine application for a Google Cloud Platform project.
     * Required fields:
     *
     * * `id` - The ID of the target Cloud Platform project.
     * * *location* - The [region](https://cloud.google.com/appengine/docs/locations) where you want the App Engine application located.
     *
     * For more information about App Engine applications, see [Managing Projects, Applications, and Billing](https://cloud.google.com/appengine/docs/standard/python/console/).
     * @param \Google\Cloud\AppEngine\V1\CreateApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApplication(\Google\Cloud\AppEngine\V1\CreateApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Applications/CreateApplication',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified Application resource.
     * You can update the following fields:
     *
     * * `auth_domain` - Google authentication domain for controlling user access to the application.
     * * `default_cookie_expiration` - Cookie expiration policy for the application.
     * @param \Google\Cloud\AppEngine\V1\UpdateApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApplication(\Google\Cloud\AppEngine\V1\UpdateApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Applications/UpdateApplication',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Recreates the required App Engine features for the specified App Engine
     * application, for example a Cloud Storage bucket or App Engine service
     * account.
     * Use this method if you receive an error message about a missing feature,
     * for example, *Error retrieving the App Engine service account*.
     * If you have deleted your App Engine service account, this will
     * not be able to recreate it. Instead, you should attempt to use the
     * IAM undelete API if possible at https://cloud.google.com/iam/reference/rest/v1/projects.serviceAccounts/undelete?apix_params=%7B"name"%3A"projects%2F-%2FserviceAccounts%2Funique_id"%2C"resource"%3A%7B%7D%7D .
     * If the deletion was recent, the numeric ID can be found in the Cloud
     * Console Activity Log.
     * @param \Google\Cloud\AppEngine\V1\RepairApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RepairApplication(\Google\Cloud\AppEngine\V1\RepairApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Applications/RepairApplication',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
