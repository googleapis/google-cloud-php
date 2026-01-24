<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\GkeRecommender\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\GkeRecommender\V1\Client\GkeInferenceQuickstartClient;
use Google\Cloud\GkeRecommender\V1\FetchBenchmarkingDataRequest;
use Google\Cloud\GkeRecommender\V1\FetchBenchmarkingDataResponse;
use Google\Cloud\GkeRecommender\V1\FetchModelServerVersionsRequest;
use Google\Cloud\GkeRecommender\V1\FetchModelServerVersionsResponse;
use Google\Cloud\GkeRecommender\V1\FetchModelServersRequest;
use Google\Cloud\GkeRecommender\V1\FetchModelServersResponse;
use Google\Cloud\GkeRecommender\V1\FetchModelsRequest;
use Google\Cloud\GkeRecommender\V1\FetchModelsResponse;
use Google\Cloud\GkeRecommender\V1\FetchProfilesRequest;
use Google\Cloud\GkeRecommender\V1\FetchProfilesResponse;
use Google\Cloud\GkeRecommender\V1\GenerateOptimizedManifestRequest;
use Google\Cloud\GkeRecommender\V1\GenerateOptimizedManifestResponse;
use Google\Cloud\GkeRecommender\V1\ModelServerInfo;
use Google\Cloud\GkeRecommender\V1\Profile;
use Google\Rpc\Code;
use stdClass;

/**
 * @group gkerecommender
 *
 * @group gapic
 */
class GkeInferenceQuickstartClientTest extends GeneratedTest
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

    /** @return GkeInferenceQuickstartClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new GkeInferenceQuickstartClient($options);
    }

    /** @test */
    public function fetchBenchmarkingDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new FetchBenchmarkingDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $modelServerInfo = new ModelServerInfo();
        $modelServerInfoModel = 'modelServerInfoModel-637750097';
        $modelServerInfo->setModel($modelServerInfoModel);
        $modelServerInfoModelServer = 'modelServerInfoModelServer191844562';
        $modelServerInfo->setModelServer($modelServerInfoModelServer);
        $request = (new FetchBenchmarkingDataRequest())->setModelServerInfo($modelServerInfo);
        $response = $gapicClient->fetchBenchmarkingData($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/FetchBenchmarkingData',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getModelServerInfo();
        $this->assertProtobufEquals($modelServerInfo, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchBenchmarkingDataExceptionTest()
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
        $modelServerInfo = new ModelServerInfo();
        $modelServerInfoModel = 'modelServerInfoModel-637750097';
        $modelServerInfo->setModel($modelServerInfoModel);
        $modelServerInfoModelServer = 'modelServerInfoModelServer191844562';
        $modelServerInfo->setModelServer($modelServerInfoModelServer);
        $request = (new FetchBenchmarkingDataRequest())->setModelServerInfo($modelServerInfo);
        try {
            $gapicClient->fetchBenchmarkingData($request);
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
    public function fetchModelServerVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $modelServerVersionsElement = 'modelServerVersionsElement1714360254';
        $modelServerVersions = [$modelServerVersionsElement];
        $expectedResponse = new FetchModelServerVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setModelServerVersions($modelServerVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $model = 'model104069929';
        $modelServer = 'modelServer-1179367';
        $request = (new FetchModelServerVersionsRequest())->setModel($model)->setModelServer($modelServer);
        $response = $gapicClient->fetchModelServerVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getModelServerVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/FetchModelServerVersions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getModel();
        $this->assertProtobufEquals($model, $actualValue);
        $actualValue = $actualRequestObject->getModelServer();
        $this->assertProtobufEquals($modelServer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchModelServerVersionsExceptionTest()
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
        $model = 'model104069929';
        $modelServer = 'modelServer-1179367';
        $request = (new FetchModelServerVersionsRequest())->setModel($model)->setModelServer($modelServer);
        try {
            $gapicClient->fetchModelServerVersions($request);
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
    public function fetchModelServersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $modelServersElement = 'modelServersElement-190853577';
        $modelServers = [$modelServersElement];
        $expectedResponse = new FetchModelServersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setModelServers($modelServers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $model = 'model104069929';
        $request = (new FetchModelServersRequest())->setModel($model);
        $response = $gapicClient->fetchModelServers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getModelServers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/FetchModelServers', $actualFuncCall);
        $actualValue = $actualRequestObject->getModel();
        $this->assertProtobufEquals($model, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchModelServersExceptionTest()
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
        $model = 'model104069929';
        $request = (new FetchModelServersRequest())->setModel($model);
        try {
            $gapicClient->fetchModelServers($request);
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
    public function fetchModelsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $modelsElement = 'modelsElement688530983';
        $models = [$modelsElement];
        $expectedResponse = new FetchModelsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setModels($models);
        $transport->addResponse($expectedResponse);
        $request = new FetchModelsRequest();
        $response = $gapicClient->fetchModels($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getModels()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/FetchModels', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchModelsExceptionTest()
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
        $request = new FetchModelsRequest();
        try {
            $gapicClient->fetchModels($request);
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
    public function fetchProfilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $comments = 'comments-602415628';
        $nextPageToken = '';
        $profileElement = new Profile();
        $profile = [$profileElement];
        $expectedResponse = new FetchProfilesResponse();
        $expectedResponse->setComments($comments);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setProfile($profile);
        $transport->addResponse($expectedResponse);
        $request = new FetchProfilesRequest();
        $response = $gapicClient->fetchProfiles($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getProfile()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/FetchProfiles', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchProfilesExceptionTest()
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
        $request = new FetchProfilesRequest();
        try {
            $gapicClient->fetchProfiles($request);
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
    public function generateOptimizedManifestTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $manifestVersion = 'manifestVersion1422938824';
        $expectedResponse = new GenerateOptimizedManifestResponse();
        $expectedResponse->setManifestVersion($manifestVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $modelServerInfo = new ModelServerInfo();
        $modelServerInfoModel = 'modelServerInfoModel-637750097';
        $modelServerInfo->setModel($modelServerInfoModel);
        $modelServerInfoModelServer = 'modelServerInfoModelServer191844562';
        $modelServerInfo->setModelServer($modelServerInfoModelServer);
        $acceleratorType = 'acceleratorType1748643982';
        $request = (new GenerateOptimizedManifestRequest())
            ->setModelServerInfo($modelServerInfo)
            ->setAcceleratorType($acceleratorType);
        $response = $gapicClient->generateOptimizedManifest($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/GenerateOptimizedManifest',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getModelServerInfo();
        $this->assertProtobufEquals($modelServerInfo, $actualValue);
        $actualValue = $actualRequestObject->getAcceleratorType();
        $this->assertProtobufEquals($acceleratorType, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateOptimizedManifestExceptionTest()
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
        $modelServerInfo = new ModelServerInfo();
        $modelServerInfoModel = 'modelServerInfoModel-637750097';
        $modelServerInfo->setModel($modelServerInfoModel);
        $modelServerInfoModelServer = 'modelServerInfoModelServer191844562';
        $modelServerInfo->setModelServer($modelServerInfoModelServer);
        $acceleratorType = 'acceleratorType1748643982';
        $request = (new GenerateOptimizedManifestRequest())
            ->setModelServerInfo($modelServerInfo)
            ->setAcceleratorType($acceleratorType);
        try {
            $gapicClient->generateOptimizedManifest($request);
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
    public function fetchBenchmarkingDataAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new FetchBenchmarkingDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $modelServerInfo = new ModelServerInfo();
        $modelServerInfoModel = 'modelServerInfoModel-637750097';
        $modelServerInfo->setModel($modelServerInfoModel);
        $modelServerInfoModelServer = 'modelServerInfoModelServer191844562';
        $modelServerInfo->setModelServer($modelServerInfoModelServer);
        $request = (new FetchBenchmarkingDataRequest())->setModelServerInfo($modelServerInfo);
        $response = $gapicClient->fetchBenchmarkingDataAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.gkerecommender.v1.GkeInferenceQuickstart/FetchBenchmarkingData',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getModelServerInfo();
        $this->assertProtobufEquals($modelServerInfo, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
