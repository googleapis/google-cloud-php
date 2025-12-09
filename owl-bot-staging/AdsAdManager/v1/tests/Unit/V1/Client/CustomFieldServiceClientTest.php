<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\BatchActivateCustomFieldsRequest;
use Google\Ads\AdManager\V1\BatchActivateCustomFieldsResponse;
use Google\Ads\AdManager\V1\BatchCreateCustomFieldsRequest;
use Google\Ads\AdManager\V1\BatchCreateCustomFieldsResponse;
use Google\Ads\AdManager\V1\BatchDeactivateCustomFieldsRequest;
use Google\Ads\AdManager\V1\BatchDeactivateCustomFieldsResponse;
use Google\Ads\AdManager\V1\BatchUpdateCustomFieldsRequest;
use Google\Ads\AdManager\V1\BatchUpdateCustomFieldsResponse;
use Google\Ads\AdManager\V1\Client\CustomFieldServiceClient;
use Google\Ads\AdManager\V1\CreateCustomFieldRequest;
use Google\Ads\AdManager\V1\CustomField;
use Google\Ads\AdManager\V1\CustomFieldDataTypeEnum\CustomFieldDataType;
use Google\Ads\AdManager\V1\CustomFieldEntityTypeEnum\CustomFieldEntityType;
use Google\Ads\AdManager\V1\CustomFieldVisibilityEnum\CustomFieldVisibility;
use Google\Ads\AdManager\V1\GetCustomFieldRequest;
use Google\Ads\AdManager\V1\ListCustomFieldsRequest;
use Google\Ads\AdManager\V1\ListCustomFieldsResponse;
use Google\Ads\AdManager\V1\UpdateCustomFieldRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class CustomFieldServiceClientTest extends GeneratedTest
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

    /** @return CustomFieldServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CustomFieldServiceClient($options);
    }

    /** @test */
    public function batchActivateCustomFieldsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateCustomFieldsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]'),
        ];
        $request = (new BatchActivateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchActivateCustomFields($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/BatchActivateCustomFields', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateCustomFieldsExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]'),
        ];
        $request = (new BatchActivateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchActivateCustomFields($request);
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
    public function batchCreateCustomFieldsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateCustomFieldsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateCustomFields($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/BatchCreateCustomFields', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateCustomFieldsExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchCreateCustomFields($request);
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
    public function batchDeactivateCustomFieldsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateCustomFieldsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]'),
        ];
        $request = (new BatchDeactivateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchDeactivateCustomFields($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/BatchDeactivateCustomFields', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateCustomFieldsExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]'),
        ];
        $request = (new BatchDeactivateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchDeactivateCustomFields($request);
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
    public function batchUpdateCustomFieldsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateCustomFieldsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchUpdateCustomFields($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/BatchUpdateCustomFields', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateCustomFieldsExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchUpdateCustomFields($request);
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
    public function createCustomFieldTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $customFieldId = 66688114;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new CustomField();
        $expectedResponse->setName($name);
        $expectedResponse->setCustomFieldId($customFieldId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $customField = new CustomField();
        $customFieldDisplayName = 'customFieldDisplayName-1447155036';
        $customField->setDisplayName($customFieldDisplayName);
        $customFieldEntityType = CustomFieldEntityType::CUSTOM_FIELD_ENTITY_TYPE_UNSPECIFIED;
        $customField->setEntityType($customFieldEntityType);
        $customFieldDataType = CustomFieldDataType::CUSTOM_FIELD_DATA_TYPE_UNSPECIFIED;
        $customField->setDataType($customFieldDataType);
        $customFieldVisibility = CustomFieldVisibility::CUSTOM_FIELD_VISIBILITY_UNSPECIFIED;
        $customField->setVisibility($customFieldVisibility);
        $request = (new CreateCustomFieldRequest())
            ->setParent($formattedParent)
            ->setCustomField($customField);
        $response = $gapicClient->createCustomField($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/CreateCustomField', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCustomField();
        $this->assertProtobufEquals($customField, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomFieldExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $customField = new CustomField();
        $customFieldDisplayName = 'customFieldDisplayName-1447155036';
        $customField->setDisplayName($customFieldDisplayName);
        $customFieldEntityType = CustomFieldEntityType::CUSTOM_FIELD_ENTITY_TYPE_UNSPECIFIED;
        $customField->setEntityType($customFieldEntityType);
        $customFieldDataType = CustomFieldDataType::CUSTOM_FIELD_DATA_TYPE_UNSPECIFIED;
        $customField->setDataType($customFieldDataType);
        $customFieldVisibility = CustomFieldVisibility::CUSTOM_FIELD_VISIBILITY_UNSPECIFIED;
        $customField->setVisibility($customFieldVisibility);
        $request = (new CreateCustomFieldRequest())
            ->setParent($formattedParent)
            ->setCustomField($customField);
        try {
            $gapicClient->createCustomField($request);
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
    public function getCustomFieldTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $customFieldId = 66688114;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new CustomField();
        $expectedResponse->setName($name2);
        $expectedResponse->setCustomFieldId($customFieldId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]');
        $request = (new GetCustomFieldRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCustomField($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/GetCustomField', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomFieldExceptionTest()
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
        $formattedName = $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]');
        $request = (new GetCustomFieldRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCustomField($request);
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
    public function listCustomFieldsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $customFieldsElement = new CustomField();
        $customFields = [
            $customFieldsElement,
        ];
        $expectedResponse = new ListCustomFieldsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setCustomFields($customFields);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCustomFieldsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCustomFields($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomFields()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/ListCustomFields', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomFieldsExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCustomFieldsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCustomFields($request);
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
    public function updateCustomFieldTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $customFieldId = 66688114;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new CustomField();
        $expectedResponse->setName($name);
        $expectedResponse->setCustomFieldId($customFieldId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $customField = new CustomField();
        $customFieldDisplayName = 'customFieldDisplayName-1447155036';
        $customField->setDisplayName($customFieldDisplayName);
        $customFieldEntityType = CustomFieldEntityType::CUSTOM_FIELD_ENTITY_TYPE_UNSPECIFIED;
        $customField->setEntityType($customFieldEntityType);
        $customFieldDataType = CustomFieldDataType::CUSTOM_FIELD_DATA_TYPE_UNSPECIFIED;
        $customField->setDataType($customFieldDataType);
        $customFieldVisibility = CustomFieldVisibility::CUSTOM_FIELD_VISIBILITY_UNSPECIFIED;
        $customField->setVisibility($customFieldVisibility);
        $updateMask = new FieldMask();
        $request = (new UpdateCustomFieldRequest())
            ->setCustomField($customField)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateCustomField($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/UpdateCustomField', $actualFuncCall);
        $actualValue = $actualRequestObject->getCustomField();
        $this->assertProtobufEquals($customField, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCustomFieldExceptionTest()
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
        $customField = new CustomField();
        $customFieldDisplayName = 'customFieldDisplayName-1447155036';
        $customField->setDisplayName($customFieldDisplayName);
        $customFieldEntityType = CustomFieldEntityType::CUSTOM_FIELD_ENTITY_TYPE_UNSPECIFIED;
        $customField->setEntityType($customFieldEntityType);
        $customFieldDataType = CustomFieldDataType::CUSTOM_FIELD_DATA_TYPE_UNSPECIFIED;
        $customField->setDataType($customFieldDataType);
        $customFieldVisibility = CustomFieldVisibility::CUSTOM_FIELD_VISIBILITY_UNSPECIFIED;
        $customField->setVisibility($customFieldVisibility);
        $updateMask = new FieldMask();
        $request = (new UpdateCustomFieldRequest())
            ->setCustomField($customField)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateCustomField($request);
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
    public function batchActivateCustomFieldsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateCustomFieldsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->customFieldName('[NETWORK_CODE]', '[CUSTOM_FIELD]'),
        ];
        $request = (new BatchActivateCustomFieldsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchActivateCustomFieldsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CustomFieldService/BatchActivateCustomFields', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
