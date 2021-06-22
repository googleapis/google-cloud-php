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
namespace Google\Cloud\EssentialContacts\V1;

/**
 * Manages contacts for important Google Cloud notifications.
 */
class EssentialContactsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Adds a new contact for a resource.
     * @param \Google\Cloud\EssentialContacts\V1\CreateContactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateContact(\Google\Cloud\EssentialContacts\V1\CreateContactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/CreateContact',
        $argument,
        ['\Google\Cloud\EssentialContacts\V1\Contact', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a contact.
     * Note: A contact's email address cannot be changed.
     * @param \Google\Cloud\EssentialContacts\V1\UpdateContactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateContact(\Google\Cloud\EssentialContacts\V1\UpdateContactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/UpdateContact',
        $argument,
        ['\Google\Cloud\EssentialContacts\V1\Contact', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the contacts that have been set on a resource.
     * @param \Google\Cloud\EssentialContacts\V1\ListContactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListContacts(\Google\Cloud\EssentialContacts\V1\ListContactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/ListContacts',
        $argument,
        ['\Google\Cloud\EssentialContacts\V1\ListContactsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single contact.
     * @param \Google\Cloud\EssentialContacts\V1\GetContactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetContact(\Google\Cloud\EssentialContacts\V1\GetContactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/GetContact',
        $argument,
        ['\Google\Cloud\EssentialContacts\V1\Contact', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a contact.
     * @param \Google\Cloud\EssentialContacts\V1\DeleteContactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteContact(\Google\Cloud\EssentialContacts\V1\DeleteContactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/DeleteContact',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all contacts for the resource that are subscribed to the
     * specified notification categories, including contacts inherited from
     * any parent resources.
     * @param \Google\Cloud\EssentialContacts\V1\ComputeContactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ComputeContacts(\Google\Cloud\EssentialContacts\V1\ComputeContactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/ComputeContacts',
        $argument,
        ['\Google\Cloud\EssentialContacts\V1\ComputeContactsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Allows a contact admin to send a test message to contact to verify that it
     * has been configured correctly.
     * @param \Google\Cloud\EssentialContacts\V1\SendTestMessageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SendTestMessage(\Google\Cloud\EssentialContacts\V1\SendTestMessageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.essentialcontacts.v1.EssentialContactsService/SendTestMessage',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
