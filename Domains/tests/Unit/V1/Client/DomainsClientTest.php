<?php
/*
 * Copyright 2023 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\Domains\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Domains\V1\AuthorizationCode;
use Google\Cloud\Domains\V1\Client\DomainsClient;
use Google\Cloud\Domains\V1\ConfigureContactSettingsRequest;
use Google\Cloud\Domains\V1\ConfigureDnsSettingsRequest;
use Google\Cloud\Domains\V1\ConfigureManagementSettingsRequest;
use Google\Cloud\Domains\V1\ContactPrivacy;
use Google\Cloud\Domains\V1\ContactSettings;
use Google\Cloud\Domains\V1\ContactSettings\Contact;
use Google\Cloud\Domains\V1\DeleteRegistrationRequest;
use Google\Cloud\Domains\V1\ExportRegistrationRequest;
use Google\Cloud\Domains\V1\GetRegistrationRequest;
use Google\Cloud\Domains\V1\ListRegistrationsRequest;
use Google\Cloud\Domains\V1\ListRegistrationsResponse;
use Google\Cloud\Domains\V1\RegisterDomainRequest;
use Google\Cloud\Domains\V1\Registration;
use Google\Cloud\Domains\V1\ResetAuthorizationCodeRequest;
use Google\Cloud\Domains\V1\RetrieveAuthorizationCodeRequest;
use Google\Cloud\Domains\V1\RetrieveRegisterParametersRequest;
use Google\Cloud\Domains\V1\RetrieveRegisterParametersResponse;
use Google\Cloud\Domains\V1\RetrieveTransferParametersRequest;
use Google\Cloud\Domains\V1\RetrieveTransferParametersResponse;
use Google\Cloud\Domains\V1\SearchDomainsRequest;
use Google\Cloud\Domains\V1\SearchDomainsResponse;
use Google\Cloud\Domains\V1\TransferDomainRequest;
use Google\Cloud\Domains\V1\UpdateRegistrationRequest;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Type\Money;
use Google\Type\PostalAddress;
use stdClass;

/**
 * @group domains
 *
 * @group gapic
 */
class DomainsClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return DomainsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DomainsClient($options);
    }

    /** @test */
    public function configureContactSettingsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureContactSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/configureContactSettingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureContactSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureContactSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ConfigureContactSettings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getRegistration();
        $this->assertProtobufEquals($formattedRegistration, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureContactSettingsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function configureContactSettingsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureContactSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureContactSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureContactSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureContactSettingsTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function configureDnsSettingsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureDnsSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/configureDnsSettingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureDnsSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureDnsSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ConfigureDnsSettings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getRegistration();
        $this->assertProtobufEquals($formattedRegistration, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureDnsSettingsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function configureDnsSettingsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureDnsSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureDnsSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureDnsSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureDnsSettingsTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function configureManagementSettingsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureManagementSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/configureManagementSettingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureManagementSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureManagementSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ConfigureManagementSettings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getRegistration();
        $this->assertProtobufEquals($formattedRegistration, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureManagementSettingsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function configureManagementSettingsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureManagementSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureManagementSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureManagementSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureManagementSettingsTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteRegistrationTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteRegistrationTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteRegistrationTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new DeleteRegistrationRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteRegistration($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/DeleteRegistration', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteRegistrationTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteRegistrationExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteRegistrationTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new DeleteRegistrationRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteRegistration($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteRegistrationTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function exportRegistrationTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/exportRegistrationTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name2);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/exportRegistrationTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new ExportRegistrationRequest())
            ->setName($formattedName);
        $response = $gapicClient->exportRegistration($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ExportRegistration', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportRegistrationTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function exportRegistrationExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/exportRegistrationTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new ExportRegistrationRequest())
            ->setName($formattedName);
        $response = $gapicClient->exportRegistration($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportRegistrationTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function getRegistrationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name2);
        $expectedResponse->setDomainName($domainName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new GetRegistrationRequest())
            ->setName($formattedName);
        $response = $gapicClient->getRegistration($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/GetRegistration', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRegistrationExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new GetRegistrationRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getRegistration($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRegistrationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $registrationsElement = new Registration();
        $registrations = [
            $registrationsElement,
        ];
        $expectedResponse = new ListRegistrationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRegistrations($registrations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRegistrationsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listRegistrations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRegistrations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ListRegistrations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRegistrationsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRegistrationsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listRegistrations($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function registerDomainTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/registerDomainTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/registerDomainTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $registration = new Registration();
        $registrationDomainName = 'registrationDomainName1873916680';
        $registration->setDomainName($registrationDomainName);
        $registrationContactSettings = new ContactSettings();
        $contactSettingsPrivacy = ContactPrivacy::CONTACT_PRIVACY_UNSPECIFIED;
        $registrationContactSettings->setPrivacy($contactSettingsPrivacy);
        $contactSettingsRegistrantContact = new Contact();
        $registrantContactPostalAddress = new PostalAddress();
        $contactSettingsRegistrantContact->setPostalAddress($registrantContactPostalAddress);
        $registrantContactEmail = 'registrantContactEmail1001340839';
        $contactSettingsRegistrantContact->setEmail($registrantContactEmail);
        $registrantContactPhoneNumber = 'registrantContactPhoneNumber-2077279710';
        $contactSettingsRegistrantContact->setPhoneNumber($registrantContactPhoneNumber);
        $registrationContactSettings->setRegistrantContact($contactSettingsRegistrantContact);
        $contactSettingsAdminContact = new Contact();
        $adminContactPostalAddress = new PostalAddress();
        $contactSettingsAdminContact->setPostalAddress($adminContactPostalAddress);
        $adminContactEmail = 'adminContactEmail1687004235';
        $contactSettingsAdminContact->setEmail($adminContactEmail);
        $adminContactPhoneNumber = 'adminContactPhoneNumber-516910138';
        $contactSettingsAdminContact->setPhoneNumber($adminContactPhoneNumber);
        $registrationContactSettings->setAdminContact($contactSettingsAdminContact);
        $contactSettingsTechnicalContact = new Contact();
        $technicalContactPostalAddress = new PostalAddress();
        $contactSettingsTechnicalContact->setPostalAddress($technicalContactPostalAddress);
        $technicalContactEmail = 'technicalContactEmail-221168807';
        $contactSettingsTechnicalContact->setEmail($technicalContactEmail);
        $technicalContactPhoneNumber = 'technicalContactPhoneNumber582887508';
        $contactSettingsTechnicalContact->setPhoneNumber($technicalContactPhoneNumber);
        $registrationContactSettings->setTechnicalContact($contactSettingsTechnicalContact);
        $registration->setContactSettings($registrationContactSettings);
        $yearlyPrice = new Money();
        $request = (new RegisterDomainRequest())
            ->setParent($formattedParent)
            ->setRegistration($registration)
            ->setYearlyPrice($yearlyPrice);
        $response = $gapicClient->registerDomain($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/RegisterDomain', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getRegistration();
        $this->assertProtobufEquals($registration, $actualValue);
        $actualValue = $actualApiRequestObject->getYearlyPrice();
        $this->assertProtobufEquals($yearlyPrice, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/registerDomainTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function registerDomainExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/registerDomainTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $registration = new Registration();
        $registrationDomainName = 'registrationDomainName1873916680';
        $registration->setDomainName($registrationDomainName);
        $registrationContactSettings = new ContactSettings();
        $contactSettingsPrivacy = ContactPrivacy::CONTACT_PRIVACY_UNSPECIFIED;
        $registrationContactSettings->setPrivacy($contactSettingsPrivacy);
        $contactSettingsRegistrantContact = new Contact();
        $registrantContactPostalAddress = new PostalAddress();
        $contactSettingsRegistrantContact->setPostalAddress($registrantContactPostalAddress);
        $registrantContactEmail = 'registrantContactEmail1001340839';
        $contactSettingsRegistrantContact->setEmail($registrantContactEmail);
        $registrantContactPhoneNumber = 'registrantContactPhoneNumber-2077279710';
        $contactSettingsRegistrantContact->setPhoneNumber($registrantContactPhoneNumber);
        $registrationContactSettings->setRegistrantContact($contactSettingsRegistrantContact);
        $contactSettingsAdminContact = new Contact();
        $adminContactPostalAddress = new PostalAddress();
        $contactSettingsAdminContact->setPostalAddress($adminContactPostalAddress);
        $adminContactEmail = 'adminContactEmail1687004235';
        $contactSettingsAdminContact->setEmail($adminContactEmail);
        $adminContactPhoneNumber = 'adminContactPhoneNumber-516910138';
        $contactSettingsAdminContact->setPhoneNumber($adminContactPhoneNumber);
        $registrationContactSettings->setAdminContact($contactSettingsAdminContact);
        $contactSettingsTechnicalContact = new Contact();
        $technicalContactPostalAddress = new PostalAddress();
        $contactSettingsTechnicalContact->setPostalAddress($technicalContactPostalAddress);
        $technicalContactEmail = 'technicalContactEmail-221168807';
        $contactSettingsTechnicalContact->setEmail($technicalContactEmail);
        $technicalContactPhoneNumber = 'technicalContactPhoneNumber582887508';
        $contactSettingsTechnicalContact->setPhoneNumber($technicalContactPhoneNumber);
        $registrationContactSettings->setTechnicalContact($contactSettingsTechnicalContact);
        $registration->setContactSettings($registrationContactSettings);
        $yearlyPrice = new Money();
        $request = (new RegisterDomainRequest())
            ->setParent($formattedParent)
            ->setRegistration($registration)
            ->setYearlyPrice($yearlyPrice);
        $response = $gapicClient->registerDomain($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/registerDomainTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function resetAuthorizationCodeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $code = 'code3059181';
        $expectedResponse = new AuthorizationCode();
        $expectedResponse->setCode($code);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new ResetAuthorizationCodeRequest())
            ->setRegistration($formattedRegistration);
        $response = $gapicClient->resetAuthorizationCode($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ResetAuthorizationCode', $actualFuncCall);
        $actualValue = $actualRequestObject->getRegistration();
        $this->assertProtobufEquals($formattedRegistration, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function resetAuthorizationCodeExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new ResetAuthorizationCodeRequest())
            ->setRegistration($formattedRegistration);
        try {
            $gapicClient->resetAuthorizationCode($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveAuthorizationCodeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $code = 'code3059181';
        $expectedResponse = new AuthorizationCode();
        $expectedResponse->setCode($code);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new RetrieveAuthorizationCodeRequest())
            ->setRegistration($formattedRegistration);
        $response = $gapicClient->retrieveAuthorizationCode($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/RetrieveAuthorizationCode', $actualFuncCall);
        $actualValue = $actualRequestObject->getRegistration();
        $this->assertProtobufEquals($formattedRegistration, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveAuthorizationCodeExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $request = (new RetrieveAuthorizationCodeRequest())
            ->setRegistration($formattedRegistration);
        try {
            $gapicClient->retrieveAuthorizationCode($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveRegisterParametersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RetrieveRegisterParametersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $domainName = 'domainName104118566';
        $formattedLocation = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new RetrieveRegisterParametersRequest())
            ->setDomainName($domainName)
            ->setLocation($formattedLocation);
        $response = $gapicClient->retrieveRegisterParameters($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/RetrieveRegisterParameters', $actualFuncCall);
        $actualValue = $actualRequestObject->getDomainName();
        $this->assertProtobufEquals($domainName, $actualValue);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($formattedLocation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveRegisterParametersExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $domainName = 'domainName104118566';
        $formattedLocation = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new RetrieveRegisterParametersRequest())
            ->setDomainName($domainName)
            ->setLocation($formattedLocation);
        try {
            $gapicClient->retrieveRegisterParameters($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveTransferParametersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RetrieveTransferParametersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $domainName = 'domainName104118566';
        $formattedLocation = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new RetrieveTransferParametersRequest())
            ->setDomainName($domainName)
            ->setLocation($formattedLocation);
        $response = $gapicClient->retrieveTransferParameters($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/RetrieveTransferParameters', $actualFuncCall);
        $actualValue = $actualRequestObject->getDomainName();
        $this->assertProtobufEquals($domainName, $actualValue);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($formattedLocation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveTransferParametersExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $domainName = 'domainName104118566';
        $formattedLocation = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new RetrieveTransferParametersRequest())
            ->setDomainName($domainName)
            ->setLocation($formattedLocation);
        try {
            $gapicClient->retrieveTransferParameters($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchDomainsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SearchDomainsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $query = 'query107944136';
        $formattedLocation = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new SearchDomainsRequest())
            ->setQuery($query)
            ->setLocation($formattedLocation);
        $response = $gapicClient->searchDomains($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/SearchDomains', $actualFuncCall);
        $actualValue = $actualRequestObject->getQuery();
        $this->assertProtobufEquals($query, $actualValue);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($formattedLocation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchDomainsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $query = 'query107944136';
        $formattedLocation = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new SearchDomainsRequest())
            ->setQuery($query)
            ->setLocation($formattedLocation);
        try {
            $gapicClient->searchDomains($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function transferDomainTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/transferDomainTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/transferDomainTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $registration = new Registration();
        $registrationDomainName = 'registrationDomainName1873916680';
        $registration->setDomainName($registrationDomainName);
        $registrationContactSettings = new ContactSettings();
        $contactSettingsPrivacy = ContactPrivacy::CONTACT_PRIVACY_UNSPECIFIED;
        $registrationContactSettings->setPrivacy($contactSettingsPrivacy);
        $contactSettingsRegistrantContact = new Contact();
        $registrantContactPostalAddress = new PostalAddress();
        $contactSettingsRegistrantContact->setPostalAddress($registrantContactPostalAddress);
        $registrantContactEmail = 'registrantContactEmail1001340839';
        $contactSettingsRegistrantContact->setEmail($registrantContactEmail);
        $registrantContactPhoneNumber = 'registrantContactPhoneNumber-2077279710';
        $contactSettingsRegistrantContact->setPhoneNumber($registrantContactPhoneNumber);
        $registrationContactSettings->setRegistrantContact($contactSettingsRegistrantContact);
        $contactSettingsAdminContact = new Contact();
        $adminContactPostalAddress = new PostalAddress();
        $contactSettingsAdminContact->setPostalAddress($adminContactPostalAddress);
        $adminContactEmail = 'adminContactEmail1687004235';
        $contactSettingsAdminContact->setEmail($adminContactEmail);
        $adminContactPhoneNumber = 'adminContactPhoneNumber-516910138';
        $contactSettingsAdminContact->setPhoneNumber($adminContactPhoneNumber);
        $registrationContactSettings->setAdminContact($contactSettingsAdminContact);
        $contactSettingsTechnicalContact = new Contact();
        $technicalContactPostalAddress = new PostalAddress();
        $contactSettingsTechnicalContact->setPostalAddress($technicalContactPostalAddress);
        $technicalContactEmail = 'technicalContactEmail-221168807';
        $contactSettingsTechnicalContact->setEmail($technicalContactEmail);
        $technicalContactPhoneNumber = 'technicalContactPhoneNumber582887508';
        $contactSettingsTechnicalContact->setPhoneNumber($technicalContactPhoneNumber);
        $registrationContactSettings->setTechnicalContact($contactSettingsTechnicalContact);
        $registration->setContactSettings($registrationContactSettings);
        $yearlyPrice = new Money();
        $request = (new TransferDomainRequest())
            ->setParent($formattedParent)
            ->setRegistration($registration)
            ->setYearlyPrice($yearlyPrice);
        $response = $gapicClient->transferDomain($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/TransferDomain', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getRegistration();
        $this->assertProtobufEquals($registration, $actualValue);
        $actualValue = $actualApiRequestObject->getYearlyPrice();
        $this->assertProtobufEquals($yearlyPrice, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/transferDomainTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function transferDomainExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/transferDomainTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $registration = new Registration();
        $registrationDomainName = 'registrationDomainName1873916680';
        $registration->setDomainName($registrationDomainName);
        $registrationContactSettings = new ContactSettings();
        $contactSettingsPrivacy = ContactPrivacy::CONTACT_PRIVACY_UNSPECIFIED;
        $registrationContactSettings->setPrivacy($contactSettingsPrivacy);
        $contactSettingsRegistrantContact = new Contact();
        $registrantContactPostalAddress = new PostalAddress();
        $contactSettingsRegistrantContact->setPostalAddress($registrantContactPostalAddress);
        $registrantContactEmail = 'registrantContactEmail1001340839';
        $contactSettingsRegistrantContact->setEmail($registrantContactEmail);
        $registrantContactPhoneNumber = 'registrantContactPhoneNumber-2077279710';
        $contactSettingsRegistrantContact->setPhoneNumber($registrantContactPhoneNumber);
        $registrationContactSettings->setRegistrantContact($contactSettingsRegistrantContact);
        $contactSettingsAdminContact = new Contact();
        $adminContactPostalAddress = new PostalAddress();
        $contactSettingsAdminContact->setPostalAddress($adminContactPostalAddress);
        $adminContactEmail = 'adminContactEmail1687004235';
        $contactSettingsAdminContact->setEmail($adminContactEmail);
        $adminContactPhoneNumber = 'adminContactPhoneNumber-516910138';
        $contactSettingsAdminContact->setPhoneNumber($adminContactPhoneNumber);
        $registrationContactSettings->setAdminContact($contactSettingsAdminContact);
        $contactSettingsTechnicalContact = new Contact();
        $technicalContactPostalAddress = new PostalAddress();
        $contactSettingsTechnicalContact->setPostalAddress($technicalContactPostalAddress);
        $technicalContactEmail = 'technicalContactEmail-221168807';
        $contactSettingsTechnicalContact->setEmail($technicalContactEmail);
        $technicalContactPhoneNumber = 'technicalContactPhoneNumber582887508';
        $contactSettingsTechnicalContact->setPhoneNumber($technicalContactPhoneNumber);
        $registrationContactSettings->setTechnicalContact($contactSettingsTechnicalContact);
        $registration->setContactSettings($registrationContactSettings);
        $yearlyPrice = new Money();
        $request = (new TransferDomainRequest())
            ->setParent($formattedParent)
            ->setRegistration($registration)
            ->setYearlyPrice($yearlyPrice);
        $response = $gapicClient->transferDomain($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/transferDomainTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateRegistrationTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateRegistrationTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateRegistrationTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateRegistrationRequest())
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateRegistration($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/UpdateRegistration', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateRegistrationTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateRegistrationExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateRegistrationTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateRegistrationRequest())
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateRegistration($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateRegistrationTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function configureContactSettingsAsyncTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/configureContactSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $domainName = 'domainName104118566';
        $expectedResponse = new Registration();
        $expectedResponse->setName($name);
        $expectedResponse->setDomainName($domainName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/configureContactSettingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedRegistration = $gapicClient->registrationName('[PROJECT]', '[LOCATION]', '[REGISTRATION]');
        $updateMask = new FieldMask();
        $request = (new ConfigureContactSettingsRequest())
            ->setRegistration($formattedRegistration)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->configureContactSettingsAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.domains.v1.Domains/ConfigureContactSettings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getRegistration();
        $this->assertProtobufEquals($formattedRegistration, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/configureContactSettingsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
