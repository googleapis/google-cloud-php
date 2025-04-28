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

namespace Google\Cloud\Chronicle\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Chronicle\V1\Client\ReferenceListServiceClient;
use Google\Cloud\Chronicle\V1\CreateReferenceListRequest;
use Google\Cloud\Chronicle\V1\GetReferenceListRequest;
use Google\Cloud\Chronicle\V1\ListReferenceListsRequest;
use Google\Cloud\Chronicle\V1\ListReferenceListsResponse;
use Google\Cloud\Chronicle\V1\ReferenceList;
use Google\Cloud\Chronicle\V1\ReferenceListSyntaxType;
use Google\Cloud\Chronicle\V1\UpdateReferenceListRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class ReferenceListServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return ReferenceListServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ReferenceListServiceClient($options);
    }

    /** @test */
    public function createReferenceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $ruleAssociationsCount = 1522562875;
        $expectedResponse = new ReferenceList();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $referenceList = new ReferenceList();
        $referenceListDescription = 'referenceListDescription-265280077';
        $referenceList->setDescription($referenceListDescription);
        $referenceListEntries = [];
        $referenceList->setEntries($referenceListEntries);
        $referenceListSyntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
        $referenceList->setSyntaxType($referenceListSyntaxType);
        $referenceListId = 'referenceListId-1667170456';
        $request = (new CreateReferenceListRequest())
            ->setParent($formattedParent)
            ->setReferenceList($referenceList)
            ->setReferenceListId($referenceListId);
        $response = $gapicClient->createReferenceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.ReferenceListService/CreateReferenceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReferenceList();
        $this->assertProtobufEquals($referenceList, $actualValue);
        $actualValue = $actualRequestObject->getReferenceListId();
        $this->assertProtobufEquals($referenceListId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createReferenceListExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $referenceList = new ReferenceList();
        $referenceListDescription = 'referenceListDescription-265280077';
        $referenceList->setDescription($referenceListDescription);
        $referenceListEntries = [];
        $referenceList->setEntries($referenceListEntries);
        $referenceListSyntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
        $referenceList->setSyntaxType($referenceListSyntaxType);
        $referenceListId = 'referenceListId-1667170456';
        $request = (new CreateReferenceListRequest())
            ->setParent($formattedParent)
            ->setReferenceList($referenceList)
            ->setReferenceListId($referenceListId);
        try {
            $gapicClient->createReferenceList($request);
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
    public function getReferenceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $ruleAssociationsCount = 1522562875;
        $expectedResponse = new ReferenceList();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->referenceListName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[REFERENCE_LIST]');
        $request = (new GetReferenceListRequest())->setName($formattedName);
        $response = $gapicClient->getReferenceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.ReferenceListService/GetReferenceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getReferenceListExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->referenceListName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[REFERENCE_LIST]');
        $request = (new GetReferenceListRequest())->setName($formattedName);
        try {
            $gapicClient->getReferenceList($request);
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
    public function listReferenceListsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $referenceListsElement = new ReferenceList();
        $referenceLists = [$referenceListsElement];
        $expectedResponse = new ListReferenceListsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setReferenceLists($referenceLists);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListReferenceListsRequest())->setParent($formattedParent);
        $response = $gapicClient->listReferenceLists($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getReferenceLists()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.ReferenceListService/ListReferenceLists', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listReferenceListsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListReferenceListsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listReferenceLists($request);
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
    public function updateReferenceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $ruleAssociationsCount = 1522562875;
        $expectedResponse = new ReferenceList();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $referenceList = new ReferenceList();
        $referenceListDescription = 'referenceListDescription-265280077';
        $referenceList->setDescription($referenceListDescription);
        $referenceListEntries = [];
        $referenceList->setEntries($referenceListEntries);
        $referenceListSyntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
        $referenceList->setSyntaxType($referenceListSyntaxType);
        $request = (new UpdateReferenceListRequest())->setReferenceList($referenceList);
        $response = $gapicClient->updateReferenceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.ReferenceListService/UpdateReferenceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getReferenceList();
        $this->assertProtobufEquals($referenceList, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateReferenceListExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $referenceList = new ReferenceList();
        $referenceListDescription = 'referenceListDescription-265280077';
        $referenceList->setDescription($referenceListDescription);
        $referenceListEntries = [];
        $referenceList->setEntries($referenceListEntries);
        $referenceListSyntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
        $referenceList->setSyntaxType($referenceListSyntaxType);
        $request = (new UpdateReferenceListRequest())->setReferenceList($referenceList);
        try {
            $gapicClient->updateReferenceList($request);
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
    public function createReferenceListAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $ruleAssociationsCount = 1522562875;
        $expectedResponse = new ReferenceList();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $referenceList = new ReferenceList();
        $referenceListDescription = 'referenceListDescription-265280077';
        $referenceList->setDescription($referenceListDescription);
        $referenceListEntries = [];
        $referenceList->setEntries($referenceListEntries);
        $referenceListSyntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
        $referenceList->setSyntaxType($referenceListSyntaxType);
        $referenceListId = 'referenceListId-1667170456';
        $request = (new CreateReferenceListRequest())
            ->setParent($formattedParent)
            ->setReferenceList($referenceList)
            ->setReferenceListId($referenceListId);
        $response = $gapicClient->createReferenceListAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.ReferenceListService/CreateReferenceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReferenceList();
        $this->assertProtobufEquals($referenceList, $actualValue);
        $actualValue = $actualRequestObject->getReferenceListId();
        $this->assertProtobufEquals($referenceListId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
