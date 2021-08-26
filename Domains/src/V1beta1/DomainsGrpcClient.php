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
namespace Google\Cloud\Domains\V1beta1;

/**
 * The Cloud Domains API enables management and configuration of domain names.
 */
class DomainsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Searches for available domain names similar to the provided query.
     *
     * Availability results from this method are approximate; call
     * `RetrieveRegisterParameters` on a domain before registering to confirm
     * availability.
     * @param \Google\Cloud\Domains\V1beta1\SearchDomainsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchDomains(\Google\Cloud\Domains\V1beta1\SearchDomainsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/SearchDomains',
        $argument,
        ['\Google\Cloud\Domains\V1beta1\SearchDomainsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets parameters needed to register a new domain name, including price and
     * up-to-date availability. Use the returned values to call `RegisterDomain`.
     * @param \Google\Cloud\Domains\V1beta1\RetrieveRegisterParametersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RetrieveRegisterParameters(\Google\Cloud\Domains\V1beta1\RetrieveRegisterParametersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/RetrieveRegisterParameters',
        $argument,
        ['\Google\Cloud\Domains\V1beta1\RetrieveRegisterParametersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Registers a new domain name and creates a corresponding `Registration`
     * resource.
     *
     * Call `RetrieveRegisterParameters` first to check availability of the domain
     * name and determine parameters like price that are needed to build a call to
     * this method.
     *
     * A successful call creates a `Registration` resource in state
     * `REGISTRATION_PENDING`, which resolves to `ACTIVE` within 1-2
     * minutes, indicating that the domain was successfully registered. If the
     * resource ends up in state `REGISTRATION_FAILED`, it indicates that the
     * domain was not registered successfully, and you can safely delete the
     * resource and retry registration.
     * @param \Google\Cloud\Domains\V1beta1\RegisterDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RegisterDomain(\Google\Cloud\Domains\V1beta1\RegisterDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/RegisterDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the `Registration` resources in a project.
     * @param \Google\Cloud\Domains\V1beta1\ListRegistrationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRegistrations(\Google\Cloud\Domains\V1beta1\ListRegistrationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/ListRegistrations',
        $argument,
        ['\Google\Cloud\Domains\V1beta1\ListRegistrationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a `Registration` resource.
     * @param \Google\Cloud\Domains\V1beta1\GetRegistrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRegistration(\Google\Cloud\Domains\V1beta1\GetRegistrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/GetRegistration',
        $argument,
        ['\Google\Cloud\Domains\V1beta1\Registration', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates select fields of a `Registration` resource, notably `labels`. To
     * update other fields, use the appropriate custom update method:
     *
     * * To update management settings, see `ConfigureManagementSettings`
     * * To update DNS configuration, see `ConfigureDnsSettings`
     * * To update contact information, see `ConfigureContactSettings`
     * @param \Google\Cloud\Domains\V1beta1\UpdateRegistrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRegistration(\Google\Cloud\Domains\V1beta1\UpdateRegistrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/UpdateRegistration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a `Registration`'s management settings.
     * @param \Google\Cloud\Domains\V1beta1\ConfigureManagementSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ConfigureManagementSettings(\Google\Cloud\Domains\V1beta1\ConfigureManagementSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/ConfigureManagementSettings',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a `Registration`'s DNS settings.
     * @param \Google\Cloud\Domains\V1beta1\ConfigureDnsSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ConfigureDnsSettings(\Google\Cloud\Domains\V1beta1\ConfigureDnsSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/ConfigureDnsSettings',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a `Registration`'s contact settings. Some changes require
     * confirmation by the domain's registrant contact .
     * @param \Google\Cloud\Domains\V1beta1\ConfigureContactSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ConfigureContactSettings(\Google\Cloud\Domains\V1beta1\ConfigureContactSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/ConfigureContactSettings',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports a `Registration` that you no longer want to use with
     * Cloud Domains. You can continue to use the domain in
     * [Google Domains](https://domains.google/) until it expires.
     *
     * If the export is successful:
     *
     * * The resource's `state` becomes `EXPORTED`, meaning that it is no longer
     * managed by Cloud Domains
     * * Because individual users can own domains in Google Domains, the calling
     * user becomes the domain's sole owner. Permissions for the domain are
     * subsequently managed in Google Domains.
     * * Without further action, the domain does not renew automatically.
     * The new owner can set up billing in Google Domains to renew the domain
     * if needed.
     * @param \Google\Cloud\Domains\V1beta1\ExportRegistrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportRegistration(\Google\Cloud\Domains\V1beta1\ExportRegistrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/ExportRegistration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a `Registration` resource.
     *
     * This method only works on resources in one of the following states:
     *
     * * `state` is `EXPORTED` with `expire_time` in the past
     * * `state` is `REGISTRATION_FAILED`
     * @param \Google\Cloud\Domains\V1beta1\DeleteRegistrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRegistration(\Google\Cloud\Domains\V1beta1\DeleteRegistrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/DeleteRegistration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the authorization code of the `Registration` for the purpose of
     * transferring the domain to another registrar.
     *
     * You can call this method only after 60 days have elapsed since the initial
     * domain registration.
     * @param \Google\Cloud\Domains\V1beta1\RetrieveAuthorizationCodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RetrieveAuthorizationCode(\Google\Cloud\Domains\V1beta1\RetrieveAuthorizationCodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/RetrieveAuthorizationCode',
        $argument,
        ['\Google\Cloud\Domains\V1beta1\AuthorizationCode', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets the authorization code of the `Registration` to a new random string.
     *
     * You can call this method only after 60 days have elapsed since the initial
     * domain registration.
     * @param \Google\Cloud\Domains\V1beta1\ResetAuthorizationCodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetAuthorizationCode(\Google\Cloud\Domains\V1beta1\ResetAuthorizationCodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.domains.v1beta1.Domains/ResetAuthorizationCode',
        $argument,
        ['\Google\Cloud\Domains\V1beta1\AuthorizationCode', 'decode'],
        $metadata, $options);
    }

}
