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

namespace Google\Cloud\SaasPlatform\SaasServiceMgmt\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Client\SaasRolloutsClient;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateRolloutKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateRolloutRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteRolloutKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteRolloutRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetRolloutKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetRolloutRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListRolloutKindsRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListRolloutKindsResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListRolloutsRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListRolloutsResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Rollout;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\RolloutKind;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateRolloutKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateRolloutRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group saasservicemgmt
 *
 * @group gapic
 */
class SaasRolloutsClientTest extends GeneratedTest
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

    /** @return SaasRolloutsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SaasRolloutsClient($options);
    }

    /** @test */
    public function createRolloutTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $release = 'release1090594823';
        $stateMessage = 'stateMessage29641305';
        $rootRollout = 'rootRollout-171694252';
        $parentRollout = 'parentRollout1631151900';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $rolloutKind = 'rolloutKind-1688577694';
        $effectiveUnitFilter = 'effectiveUnitFilter1368209403';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Rollout();
        $expectedResponse->setName($name);
        $expectedResponse->setRelease($release);
        $expectedResponse->setStateMessage($stateMessage);
        $expectedResponse->setRootRollout($rootRollout);
        $expectedResponse->setParentRollout($parentRollout);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setRolloutKind($rolloutKind);
        $expectedResponse->setEffectiveUnitFilter($effectiveUnitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $rolloutId = 'rolloutId-91142551';
        $rollout = new Rollout();
        $rolloutRolloutKind = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $rollout->setRolloutKind($rolloutRolloutKind);
        $request = (new CreateRolloutRequest())
            ->setParent($formattedParent)
            ->setRolloutId($rolloutId)
            ->setRollout($rollout);
        $response = $gapicClient->createRollout($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/CreateRollout', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRolloutId();
        $this->assertProtobufEquals($rolloutId, $actualValue);
        $actualValue = $actualRequestObject->getRollout();
        $this->assertProtobufEquals($rollout, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createRolloutExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $rolloutId = 'rolloutId-91142551';
        $rollout = new Rollout();
        $rolloutRolloutKind = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $rollout->setRolloutKind($rolloutRolloutKind);
        $request = (new CreateRolloutRequest())
            ->setParent($formattedParent)
            ->setRolloutId($rolloutId)
            ->setRollout($rollout);
        try {
            $gapicClient->createRollout($request);
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
    public function createRolloutKindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new RolloutKind();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $rolloutKindId = 'rolloutKindId-1761016552';
        $rolloutKind = new RolloutKind();
        $request = (new CreateRolloutKindRequest())
            ->setParent($formattedParent)
            ->setRolloutKindId($rolloutKindId)
            ->setRolloutKind($rolloutKind);
        $response = $gapicClient->createRolloutKind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/CreateRolloutKind',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRolloutKindId();
        $this->assertProtobufEquals($rolloutKindId, $actualValue);
        $actualValue = $actualRequestObject->getRolloutKind();
        $this->assertProtobufEquals($rolloutKind, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createRolloutKindExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $rolloutKindId = 'rolloutKindId-1761016552';
        $rolloutKind = new RolloutKind();
        $request = (new CreateRolloutKindRequest())
            ->setParent($formattedParent)
            ->setRolloutKindId($rolloutKindId)
            ->setRolloutKind($rolloutKind);
        try {
            $gapicClient->createRolloutKind($request);
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
    public function deleteRolloutTest()
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
        $formattedName = $gapicClient->rolloutName('[PROJECT]', '[LOCATION]', '[ROLLOUT_ID]');
        $request = (new DeleteRolloutRequest())->setName($formattedName);
        $gapicClient->deleteRollout($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/DeleteRollout', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteRolloutExceptionTest()
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
        $formattedName = $gapicClient->rolloutName('[PROJECT]', '[LOCATION]', '[ROLLOUT_ID]');
        $request = (new DeleteRolloutRequest())->setName($formattedName);
        try {
            $gapicClient->deleteRollout($request);
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
    public function deleteRolloutKindTest()
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
        $formattedName = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $request = (new DeleteRolloutKindRequest())->setName($formattedName);
        $gapicClient->deleteRolloutKind($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/DeleteRolloutKind',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteRolloutKindExceptionTest()
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
        $formattedName = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $request = (new DeleteRolloutKindRequest())->setName($formattedName);
        try {
            $gapicClient->deleteRolloutKind($request);
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
    public function getRolloutTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $release = 'release1090594823';
        $stateMessage = 'stateMessage29641305';
        $rootRollout = 'rootRollout-171694252';
        $parentRollout = 'parentRollout1631151900';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $rolloutKind = 'rolloutKind-1688577694';
        $effectiveUnitFilter = 'effectiveUnitFilter1368209403';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Rollout();
        $expectedResponse->setName($name2);
        $expectedResponse->setRelease($release);
        $expectedResponse->setStateMessage($stateMessage);
        $expectedResponse->setRootRollout($rootRollout);
        $expectedResponse->setParentRollout($parentRollout);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setRolloutKind($rolloutKind);
        $expectedResponse->setEffectiveUnitFilter($effectiveUnitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->rolloutName('[PROJECT]', '[LOCATION]', '[ROLLOUT_ID]');
        $request = (new GetRolloutRequest())->setName($formattedName);
        $response = $gapicClient->getRollout($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/GetRollout', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRolloutExceptionTest()
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
        $formattedName = $gapicClient->rolloutName('[PROJECT]', '[LOCATION]', '[ROLLOUT_ID]');
        $request = (new GetRolloutRequest())->setName($formattedName);
        try {
            $gapicClient->getRollout($request);
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
    public function getRolloutKindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $unitKind = 'unitKind-472552081';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new RolloutKind();
        $expectedResponse->setName($name2);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $request = (new GetRolloutKindRequest())->setName($formattedName);
        $response = $gapicClient->getRolloutKind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/GetRolloutKind', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRolloutKindExceptionTest()
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
        $formattedName = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $request = (new GetRolloutKindRequest())->setName($formattedName);
        try {
            $gapicClient->getRolloutKind($request);
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
    public function listRolloutKindsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $rolloutKindsElement = new RolloutKind();
        $rolloutKinds = [$rolloutKindsElement];
        $expectedResponse = new ListRolloutKindsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRolloutKinds($rolloutKinds);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRolloutKindsRequest())->setParent($formattedParent);
        $response = $gapicClient->listRolloutKinds($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRolloutKinds()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/ListRolloutKinds',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRolloutKindsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRolloutKindsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listRolloutKinds($request);
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
    public function listRolloutsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $rolloutsElement = new Rollout();
        $rollouts = [$rolloutsElement];
        $expectedResponse = new ListRolloutsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRollouts($rollouts);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRolloutsRequest())->setParent($formattedParent);
        $response = $gapicClient->listRollouts($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRollouts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/ListRollouts', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRolloutsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRolloutsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listRollouts($request);
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
    public function updateRolloutTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $release = 'release1090594823';
        $stateMessage = 'stateMessage29641305';
        $rootRollout = 'rootRollout-171694252';
        $parentRollout = 'parentRollout1631151900';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $rolloutKind = 'rolloutKind-1688577694';
        $effectiveUnitFilter = 'effectiveUnitFilter1368209403';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Rollout();
        $expectedResponse->setName($name);
        $expectedResponse->setRelease($release);
        $expectedResponse->setStateMessage($stateMessage);
        $expectedResponse->setRootRollout($rootRollout);
        $expectedResponse->setParentRollout($parentRollout);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setRolloutKind($rolloutKind);
        $expectedResponse->setEffectiveUnitFilter($effectiveUnitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $rollout = new Rollout();
        $rolloutRolloutKind = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $rollout->setRolloutKind($rolloutRolloutKind);
        $request = (new UpdateRolloutRequest())->setRollout($rollout);
        $response = $gapicClient->updateRollout($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/UpdateRollout', $actualFuncCall);
        $actualValue = $actualRequestObject->getRollout();
        $this->assertProtobufEquals($rollout, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateRolloutExceptionTest()
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
        $rollout = new Rollout();
        $rolloutRolloutKind = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $rollout->setRolloutKind($rolloutRolloutKind);
        $request = (new UpdateRolloutRequest())->setRollout($rollout);
        try {
            $gapicClient->updateRollout($request);
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
    public function updateRolloutKindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new RolloutKind();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $rolloutKind = new RolloutKind();
        $request = (new UpdateRolloutKindRequest())->setRolloutKind($rolloutKind);
        $response = $gapicClient->updateRolloutKind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/UpdateRolloutKind',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getRolloutKind();
        $this->assertProtobufEquals($rolloutKind, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateRolloutKindExceptionTest()
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
        $rolloutKind = new RolloutKind();
        $request = (new UpdateRolloutKindRequest())->setRolloutKind($rolloutKind);
        try {
            $gapicClient->updateRolloutKind($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function createRolloutAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $release = 'release1090594823';
        $stateMessage = 'stateMessage29641305';
        $rootRollout = 'rootRollout-171694252';
        $parentRollout = 'parentRollout1631151900';
        $rolloutOrchestrationStrategy = 'rolloutOrchestrationStrategy-925283841';
        $unitFilter = 'unitFilter1000796819';
        $rolloutKind = 'rolloutKind-1688577694';
        $effectiveUnitFilter = 'effectiveUnitFilter1368209403';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Rollout();
        $expectedResponse->setName($name);
        $expectedResponse->setRelease($release);
        $expectedResponse->setStateMessage($stateMessage);
        $expectedResponse->setRootRollout($rootRollout);
        $expectedResponse->setParentRollout($parentRollout);
        $expectedResponse->setRolloutOrchestrationStrategy($rolloutOrchestrationStrategy);
        $expectedResponse->setUnitFilter($unitFilter);
        $expectedResponse->setRolloutKind($rolloutKind);
        $expectedResponse->setEffectiveUnitFilter($effectiveUnitFilter);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $rolloutId = 'rolloutId-91142551';
        $rollout = new Rollout();
        $rolloutRolloutKind = $gapicClient->rolloutKindName('[PROJECT]', '[LOCATION]', '[ROLLOUT_KIND_ID]');
        $rollout->setRolloutKind($rolloutRolloutKind);
        $request = (new CreateRolloutRequest())
            ->setParent($formattedParent)
            ->setRolloutId($rolloutId)
            ->setRollout($rollout);
        $response = $gapicClient->createRolloutAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts/CreateRollout', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRolloutId();
        $this->assertProtobufEquals($rolloutId, $actualValue);
        $actualValue = $actualRequestObject->getRollout();
        $this->assertProtobufEquals($rollout, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
