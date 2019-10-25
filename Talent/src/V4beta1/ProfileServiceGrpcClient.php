<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
 * A service that handles profile management, including profile CRUD,
 * enumeration and search.
 */
class ProfileServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists profiles by filter. The order is unspecified.
     * @param \Google\Cloud\Talent\V4beta1\ListProfilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListProfiles(\Google\Cloud\Talent\V4beta1\ListProfilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ProfileService/ListProfiles',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ListProfilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates and returns a new profile.
     * @param \Google\Cloud\Talent\V4beta1\CreateProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateProfile(\Google\Cloud\Talent\V4beta1\CreateProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ProfileService/CreateProfile',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Profile', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the specified profile.
     * @param \Google\Cloud\Talent\V4beta1\GetProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetProfile(\Google\Cloud\Talent\V4beta1\GetProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ProfileService/GetProfile',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Profile', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified profile and returns the updated result.
     * @param \Google\Cloud\Talent\V4beta1\UpdateProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateProfile(\Google\Cloud\Talent\V4beta1\UpdateProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ProfileService/UpdateProfile',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Profile', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified profile.
     * Prerequisite: The profile has no associated applications or assignments
     * associated.
     * @param \Google\Cloud\Talent\V4beta1\DeleteProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteProfile(\Google\Cloud\Talent\V4beta1\DeleteProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ProfileService/DeleteProfile',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches for profiles within a tenant.
     *
     * For example, search by raw queries "software engineer in Mountain View" or
     * search by structured filters (location filter, education filter, etc.).
     *
     * See
     * [SearchProfilesRequest][google.cloud.talent.v4beta1.SearchProfilesRequest]
     * for more information.
     * @param \Google\Cloud\Talent\V4beta1\SearchProfilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SearchProfiles(\Google\Cloud\Talent\V4beta1\SearchProfilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ProfileService/SearchProfiles',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\SearchProfilesResponse', 'decode'],
        $metadata, $options);
    }

}
