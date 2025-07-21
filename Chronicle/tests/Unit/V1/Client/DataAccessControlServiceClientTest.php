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
use Google\Cloud\Chronicle\V1\Client\DataAccessControlServiceClient;
use Google\Cloud\Chronicle\V1\CreateDataAccessLabelRequest;
use Google\Cloud\Chronicle\V1\CreateDataAccessScopeRequest;
use Google\Cloud\Chronicle\V1\DataAccessLabel;
use Google\Cloud\Chronicle\V1\DataAccessScope;
use Google\Cloud\Chronicle\V1\DeleteDataAccessLabelRequest;
use Google\Cloud\Chronicle\V1\DeleteDataAccessScopeRequest;
use Google\Cloud\Chronicle\V1\GetDataAccessLabelRequest;
use Google\Cloud\Chronicle\V1\GetDataAccessScopeRequest;
use Google\Cloud\Chronicle\V1\ListDataAccessLabelsRequest;
use Google\Cloud\Chronicle\V1\ListDataAccessLabelsResponse;
use Google\Cloud\Chronicle\V1\ListDataAccessScopesRequest;
use Google\Cloud\Chronicle\V1\ListDataAccessScopesResponse;
use Google\Cloud\Chronicle\V1\UpdateDataAccessLabelRequest;
use Google\Cloud\Chronicle\V1\UpdateDataAccessScopeRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class DataAccessControlServiceClientTest extends GeneratedTest
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

    /** @return DataAccessControlServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataAccessControlServiceClient($options);
    }

    /** @test */
    public function createDataAccessLabelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $udmQuery = 'udmQuery-2050033401';
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $expectedResponse = new DataAccessLabel();
        $expectedResponse->setUdmQuery($udmQuery);
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $dataAccessLabel = new DataAccessLabel();
        $dataAccessLabelId = 'dataAccessLabelId-1688134612';
        $request = (new CreateDataAccessLabelRequest())
            ->setParent($formattedParent)
            ->setDataAccessLabel($dataAccessLabel)
            ->setDataAccessLabelId($dataAccessLabelId);
        $response = $gapicClient->createDataAccessLabel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/CreateDataAccessLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataAccessLabel();
        $this->assertProtobufEquals($dataAccessLabel, $actualValue);
        $actualValue = $actualRequestObject->getDataAccessLabelId();
        $this->assertProtobufEquals($dataAccessLabelId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataAccessLabelExceptionTest()
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
        $dataAccessLabel = new DataAccessLabel();
        $dataAccessLabelId = 'dataAccessLabelId-1688134612';
        $request = (new CreateDataAccessLabelRequest())
            ->setParent($formattedParent)
            ->setDataAccessLabel($dataAccessLabel)
            ->setDataAccessLabelId($dataAccessLabelId);
        try {
            $gapicClient->createDataAccessLabel($request);
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
    public function createDataAccessScopeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $allowAll = false;
        $expectedResponse = new DataAccessScope();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAllowAll($allowAll);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $dataAccessScope = new DataAccessScope();
        $dataAccessScopeName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $dataAccessScope->setName($dataAccessScopeName);
        $dataAccessScopeId = 'dataAccessScopeId-216227636';
        $request = (new CreateDataAccessScopeRequest())
            ->setParent($formattedParent)
            ->setDataAccessScope($dataAccessScope)
            ->setDataAccessScopeId($dataAccessScopeId);
        $response = $gapicClient->createDataAccessScope($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/CreateDataAccessScope', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataAccessScope();
        $this->assertProtobufEquals($dataAccessScope, $actualValue);
        $actualValue = $actualRequestObject->getDataAccessScopeId();
        $this->assertProtobufEquals($dataAccessScopeId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataAccessScopeExceptionTest()
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
        $dataAccessScope = new DataAccessScope();
        $dataAccessScopeName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $dataAccessScope->setName($dataAccessScopeName);
        $dataAccessScopeId = 'dataAccessScopeId-216227636';
        $request = (new CreateDataAccessScopeRequest())
            ->setParent($formattedParent)
            ->setDataAccessScope($dataAccessScope)
            ->setDataAccessScopeId($dataAccessScopeId);
        try {
            $gapicClient->createDataAccessScope($request);
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
    public function deleteDataAccessLabelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataAccessLabelName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_LABEL]'
        );
        $request = (new DeleteDataAccessLabelRequest())->setName($formattedName);
        $gapicClient->deleteDataAccessLabel($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/DeleteDataAccessLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDataAccessLabelExceptionTest()
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
        $formattedName = $gapicClient->dataAccessLabelName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_LABEL]'
        );
        $request = (new DeleteDataAccessLabelRequest())->setName($formattedName);
        try {
            $gapicClient->deleteDataAccessLabel($request);
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
    public function deleteDataAccessScopeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $request = (new DeleteDataAccessScopeRequest())->setName($formattedName);
        $gapicClient->deleteDataAccessScope($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/DeleteDataAccessScope', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDataAccessScopeExceptionTest()
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
        $formattedName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $request = (new DeleteDataAccessScopeRequest())->setName($formattedName);
        try {
            $gapicClient->deleteDataAccessScope($request);
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
    public function getDataAccessLabelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $udmQuery = 'udmQuery-2050033401';
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $expectedResponse = new DataAccessLabel();
        $expectedResponse->setUdmQuery($udmQuery);
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataAccessLabelName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_LABEL]'
        );
        $request = (new GetDataAccessLabelRequest())->setName($formattedName);
        $response = $gapicClient->getDataAccessLabel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/GetDataAccessLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataAccessLabelExceptionTest()
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
        $formattedName = $gapicClient->dataAccessLabelName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_LABEL]'
        );
        $request = (new GetDataAccessLabelRequest())->setName($formattedName);
        try {
            $gapicClient->getDataAccessLabel($request);
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
    public function getDataAccessScopeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $allowAll = false;
        $expectedResponse = new DataAccessScope();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAllowAll($allowAll);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $request = (new GetDataAccessScopeRequest())->setName($formattedName);
        $response = $gapicClient->getDataAccessScope($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/GetDataAccessScope', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataAccessScopeExceptionTest()
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
        $formattedName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $request = (new GetDataAccessScopeRequest())->setName($formattedName);
        try {
            $gapicClient->getDataAccessScope($request);
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
    public function listDataAccessLabelsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataAccessLabelsElement = new DataAccessLabel();
        $dataAccessLabels = [$dataAccessLabelsElement];
        $expectedResponse = new ListDataAccessLabelsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataAccessLabels($dataAccessLabels);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListDataAccessLabelsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDataAccessLabels($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataAccessLabels()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/ListDataAccessLabels', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataAccessLabelsExceptionTest()
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
        $request = (new ListDataAccessLabelsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDataAccessLabels($request);
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
    public function listDataAccessScopesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $globalDataAccessScopeGranted = true;
        $nextPageToken = '';
        $dataAccessScopesElement = new DataAccessScope();
        $dataAccessScopes = [$dataAccessScopesElement];
        $expectedResponse = new ListDataAccessScopesResponse();
        $expectedResponse->setGlobalDataAccessScopeGranted($globalDataAccessScopeGranted);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataAccessScopes($dataAccessScopes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListDataAccessScopesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDataAccessScopes($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataAccessScopes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/ListDataAccessScopes', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataAccessScopesExceptionTest()
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
        $request = (new ListDataAccessScopesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDataAccessScopes($request);
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
    public function updateDataAccessLabelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $udmQuery = 'udmQuery-2050033401';
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $expectedResponse = new DataAccessLabel();
        $expectedResponse->setUdmQuery($udmQuery);
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataAccessLabel = new DataAccessLabel();
        $request = (new UpdateDataAccessLabelRequest())->setDataAccessLabel($dataAccessLabel);
        $response = $gapicClient->updateDataAccessLabel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/UpdateDataAccessLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getDataAccessLabel();
        $this->assertProtobufEquals($dataAccessLabel, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataAccessLabelExceptionTest()
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
        $dataAccessLabel = new DataAccessLabel();
        $request = (new UpdateDataAccessLabelRequest())->setDataAccessLabel($dataAccessLabel);
        try {
            $gapicClient->updateDataAccessLabel($request);
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
    public function updateDataAccessScopeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $allowAll = false;
        $expectedResponse = new DataAccessScope();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAllowAll($allowAll);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataAccessScope = new DataAccessScope();
        $dataAccessScopeName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $dataAccessScope->setName($dataAccessScopeName);
        $request = (new UpdateDataAccessScopeRequest())->setDataAccessScope($dataAccessScope);
        $response = $gapicClient->updateDataAccessScope($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/UpdateDataAccessScope', $actualFuncCall);
        $actualValue = $actualRequestObject->getDataAccessScope();
        $this->assertProtobufEquals($dataAccessScope, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataAccessScopeExceptionTest()
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
        $dataAccessScope = new DataAccessScope();
        $dataAccessScopeName = $gapicClient->dataAccessScopeName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_ACCESS_SCOPE]'
        );
        $dataAccessScope->setName($dataAccessScopeName);
        $request = (new UpdateDataAccessScopeRequest())->setDataAccessScope($dataAccessScope);
        try {
            $gapicClient->updateDataAccessScope($request);
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
    public function createDataAccessLabelAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $udmQuery = 'udmQuery-2050033401';
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $author = 'author-1406328437';
        $lastEditor = 'lastEditor1620154166';
        $description = 'description-1724546052';
        $expectedResponse = new DataAccessLabel();
        $expectedResponse->setUdmQuery($udmQuery);
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAuthor($author);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $dataAccessLabel = new DataAccessLabel();
        $dataAccessLabelId = 'dataAccessLabelId-1688134612';
        $request = (new CreateDataAccessLabelRequest())
            ->setParent($formattedParent)
            ->setDataAccessLabel($dataAccessLabel)
            ->setDataAccessLabelId($dataAccessLabelId);
        $response = $gapicClient->createDataAccessLabelAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataAccessControlService/CreateDataAccessLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataAccessLabel();
        $this->assertProtobufEquals($dataAccessLabel, $actualValue);
        $actualValue = $actualRequestObject->getDataAccessLabelId();
        $this->assertProtobufEquals($dataAccessLabelId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
