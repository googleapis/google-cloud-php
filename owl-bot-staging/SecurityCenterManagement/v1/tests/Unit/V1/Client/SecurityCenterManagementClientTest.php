<?php
/*
 * Copyright 2024 Google LLC
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

namespace Google\Cloud\SecurityCenterManagement\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\SecurityCenterManagement\V1\Client\SecurityCenterManagementClient;
use Google\Cloud\SecurityCenterManagement\V1\CreateEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\CreateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\DeleteEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\DeleteSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\EffectiveEventThreatDetectionCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\EffectiveSecurityHealthAnalyticsCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\EventThreatDetectionCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\GetEffectiveEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\GetEffectiveSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\GetEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\GetSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListDescendantEventThreatDetectionCustomModulesRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListDescendantEventThreatDetectionCustomModulesResponse;
use Google\Cloud\SecurityCenterManagement\V1\ListDescendantSecurityHealthAnalyticsCustomModulesRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListDescendantSecurityHealthAnalyticsCustomModulesResponse;
use Google\Cloud\SecurityCenterManagement\V1\ListEffectiveEventThreatDetectionCustomModulesRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListEffectiveEventThreatDetectionCustomModulesResponse;
use Google\Cloud\SecurityCenterManagement\V1\ListEffectiveSecurityHealthAnalyticsCustomModulesRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListEffectiveSecurityHealthAnalyticsCustomModulesResponse;
use Google\Cloud\SecurityCenterManagement\V1\ListEventThreatDetectionCustomModulesRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListEventThreatDetectionCustomModulesResponse;
use Google\Cloud\SecurityCenterManagement\V1\ListSecurityHealthAnalyticsCustomModulesRequest;
use Google\Cloud\SecurityCenterManagement\V1\ListSecurityHealthAnalyticsCustomModulesResponse;
use Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\SimulateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\SimulateSecurityHealthAnalyticsCustomModuleResponse;
use Google\Cloud\SecurityCenterManagement\V1\UpdateEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\UpdateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\ValidateEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\ValidateEventThreatDetectionCustomModuleResponse;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group securitycentermanagement
 *
 * @group gapic
 */
class SecurityCenterManagementClientTest extends GeneratedTest
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

    /** @return SecurityCenterManagementClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SecurityCenterManagementClient($options);
    }

    /** @test */
    public function createEventThreatDetectionCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $ancestorModule = 'ancestorModule-521996712';
        $type = 'type3575610';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $lastEditor = 'lastEditor1620154166';
        $expectedResponse = new EventThreatDetectionCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setAncestorModule($ancestorModule);
        $expectedResponse->setType($type);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastEditor($lastEditor);
        $transport->addResponse($expectedResponse);
        $request = new CreateEventThreatDetectionCustomModuleRequest();
        $response = $gapicClient->createEventThreatDetectionCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/CreateEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createEventThreatDetectionCustomModuleExceptionTest()
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
        $request = new CreateEventThreatDetectionCustomModuleRequest();
        try {
            $gapicClient->createEventThreatDetectionCustomModule($request);
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
    public function createSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $lastEditor = 'lastEditor1620154166';
        $ancestorModule = 'ancestorModule-521996712';
        $expectedResponse = new SecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setAncestorModule($ancestorModule);
        $transport->addResponse($expectedResponse);
        $request = new CreateSecurityHealthAnalyticsCustomModuleRequest();
        $response = $gapicClient->createSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/CreateSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $request = new CreateSecurityHealthAnalyticsCustomModuleRequest();
        try {
            $gapicClient->createSecurityHealthAnalyticsCustomModule($request);
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
    public function deleteEventThreatDetectionCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteEventThreatDetectionCustomModuleRequest();
        $gapicClient->deleteEventThreatDetectionCustomModule($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/DeleteEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteEventThreatDetectionCustomModuleExceptionTest()
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
        $request = new DeleteEventThreatDetectionCustomModuleRequest();
        try {
            $gapicClient->deleteEventThreatDetectionCustomModule($request);
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
    public function deleteSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteSecurityHealthAnalyticsCustomModuleRequest();
        $gapicClient->deleteSecurityHealthAnalyticsCustomModule($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/DeleteSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $request = new DeleteSecurityHealthAnalyticsCustomModuleRequest();
        try {
            $gapicClient->deleteSecurityHealthAnalyticsCustomModule($request);
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
    public function getEffectiveEventThreatDetectionCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $type = 'type3575610';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new EffectiveEventThreatDetectionCustomModule();
        $expectedResponse->setName($name2);
        $expectedResponse->setType($type);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        $request = new GetEffectiveEventThreatDetectionCustomModuleRequest();
        $response = $gapicClient->getEffectiveEventThreatDetectionCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/GetEffectiveEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEffectiveEventThreatDetectionCustomModuleExceptionTest()
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
        $request = new GetEffectiveEventThreatDetectionCustomModuleRequest();
        try {
            $gapicClient->getEffectiveEventThreatDetectionCustomModule($request);
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
    public function getEffectiveSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new EffectiveSecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetEffectiveSecurityHealthAnalyticsCustomModuleRequest();
        $response = $gapicClient->getEffectiveSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/GetEffectiveSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEffectiveSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $request = new GetEffectiveSecurityHealthAnalyticsCustomModuleRequest();
        try {
            $gapicClient->getEffectiveSecurityHealthAnalyticsCustomModule($request);
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
    public function getEventThreatDetectionCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $ancestorModule = 'ancestorModule-521996712';
        $type = 'type3575610';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $lastEditor = 'lastEditor1620154166';
        $expectedResponse = new EventThreatDetectionCustomModule();
        $expectedResponse->setName($name2);
        $expectedResponse->setAncestorModule($ancestorModule);
        $expectedResponse->setType($type);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastEditor($lastEditor);
        $transport->addResponse($expectedResponse);
        $request = new GetEventThreatDetectionCustomModuleRequest();
        $response = $gapicClient->getEventThreatDetectionCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/GetEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEventThreatDetectionCustomModuleExceptionTest()
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
        $request = new GetEventThreatDetectionCustomModuleRequest();
        try {
            $gapicClient->getEventThreatDetectionCustomModule($request);
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
    public function getSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $lastEditor = 'lastEditor1620154166';
        $ancestorModule = 'ancestorModule-521996712';
        $expectedResponse = new SecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setAncestorModule($ancestorModule);
        $transport->addResponse($expectedResponse);
        $request = new GetSecurityHealthAnalyticsCustomModuleRequest();
        $response = $gapicClient->getSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/GetSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $request = new GetSecurityHealthAnalyticsCustomModuleRequest();
        try {
            $gapicClient->getSecurityHealthAnalyticsCustomModule($request);
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
    public function listDescendantEventThreatDetectionCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $eventThreatDetectionCustomModulesElement = new EventThreatDetectionCustomModule();
        $eventThreatDetectionCustomModules = [
            $eventThreatDetectionCustomModulesElement,
        ];
        $expectedResponse = new ListDescendantEventThreatDetectionCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEventThreatDetectionCustomModules($eventThreatDetectionCustomModules);
        $transport->addResponse($expectedResponse);
        $request = new ListDescendantEventThreatDetectionCustomModulesRequest();
        $response = $gapicClient->listDescendantEventThreatDetectionCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEventThreatDetectionCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ListDescendantEventThreatDetectionCustomModules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDescendantEventThreatDetectionCustomModulesExceptionTest()
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
        $request = new ListDescendantEventThreatDetectionCustomModulesRequest();
        try {
            $gapicClient->listDescendantEventThreatDetectionCustomModules($request);
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
    public function listDescendantSecurityHealthAnalyticsCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $securityHealthAnalyticsCustomModulesElement = new SecurityHealthAnalyticsCustomModule();
        $securityHealthAnalyticsCustomModules = [
            $securityHealthAnalyticsCustomModulesElement,
        ];
        $expectedResponse = new ListDescendantSecurityHealthAnalyticsCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSecurityHealthAnalyticsCustomModules($securityHealthAnalyticsCustomModules);
        $transport->addResponse($expectedResponse);
        $request = new ListDescendantSecurityHealthAnalyticsCustomModulesRequest();
        $response = $gapicClient->listDescendantSecurityHealthAnalyticsCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSecurityHealthAnalyticsCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ListDescendantSecurityHealthAnalyticsCustomModules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDescendantSecurityHealthAnalyticsCustomModulesExceptionTest()
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
        $request = new ListDescendantSecurityHealthAnalyticsCustomModulesRequest();
        try {
            $gapicClient->listDescendantSecurityHealthAnalyticsCustomModules($request);
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
    public function listEffectiveEventThreatDetectionCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $effectiveEventThreatDetectionCustomModulesElement = new EffectiveEventThreatDetectionCustomModule();
        $effectiveEventThreatDetectionCustomModules = [
            $effectiveEventThreatDetectionCustomModulesElement,
        ];
        $expectedResponse = new ListEffectiveEventThreatDetectionCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEffectiveEventThreatDetectionCustomModules($effectiveEventThreatDetectionCustomModules);
        $transport->addResponse($expectedResponse);
        $request = new ListEffectiveEventThreatDetectionCustomModulesRequest();
        $response = $gapicClient->listEffectiveEventThreatDetectionCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEffectiveEventThreatDetectionCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ListEffectiveEventThreatDetectionCustomModules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEffectiveEventThreatDetectionCustomModulesExceptionTest()
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
        $request = new ListEffectiveEventThreatDetectionCustomModulesRequest();
        try {
            $gapicClient->listEffectiveEventThreatDetectionCustomModules($request);
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
    public function listEffectiveSecurityHealthAnalyticsCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $effectiveSecurityHealthAnalyticsCustomModulesElement = new EffectiveSecurityHealthAnalyticsCustomModule();
        $effectiveSecurityHealthAnalyticsCustomModules = [
            $effectiveSecurityHealthAnalyticsCustomModulesElement,
        ];
        $expectedResponse = new ListEffectiveSecurityHealthAnalyticsCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEffectiveSecurityHealthAnalyticsCustomModules($effectiveSecurityHealthAnalyticsCustomModules);
        $transport->addResponse($expectedResponse);
        $request = new ListEffectiveSecurityHealthAnalyticsCustomModulesRequest();
        $response = $gapicClient->listEffectiveSecurityHealthAnalyticsCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEffectiveSecurityHealthAnalyticsCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ListEffectiveSecurityHealthAnalyticsCustomModules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEffectiveSecurityHealthAnalyticsCustomModulesExceptionTest()
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
        $request = new ListEffectiveSecurityHealthAnalyticsCustomModulesRequest();
        try {
            $gapicClient->listEffectiveSecurityHealthAnalyticsCustomModules($request);
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
    public function listEventThreatDetectionCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $eventThreatDetectionCustomModulesElement = new EventThreatDetectionCustomModule();
        $eventThreatDetectionCustomModules = [
            $eventThreatDetectionCustomModulesElement,
        ];
        $expectedResponse = new ListEventThreatDetectionCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEventThreatDetectionCustomModules($eventThreatDetectionCustomModules);
        $transport->addResponse($expectedResponse);
        $request = new ListEventThreatDetectionCustomModulesRequest();
        $response = $gapicClient->listEventThreatDetectionCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEventThreatDetectionCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ListEventThreatDetectionCustomModules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEventThreatDetectionCustomModulesExceptionTest()
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
        $request = new ListEventThreatDetectionCustomModulesRequest();
        try {
            $gapicClient->listEventThreatDetectionCustomModules($request);
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
    public function listSecurityHealthAnalyticsCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $securityHealthAnalyticsCustomModulesElement = new SecurityHealthAnalyticsCustomModule();
        $securityHealthAnalyticsCustomModules = [
            $securityHealthAnalyticsCustomModulesElement,
        ];
        $expectedResponse = new ListSecurityHealthAnalyticsCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSecurityHealthAnalyticsCustomModules($securityHealthAnalyticsCustomModules);
        $transport->addResponse($expectedResponse);
        $request = new ListSecurityHealthAnalyticsCustomModulesRequest();
        $response = $gapicClient->listSecurityHealthAnalyticsCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSecurityHealthAnalyticsCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ListSecurityHealthAnalyticsCustomModules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSecurityHealthAnalyticsCustomModulesExceptionTest()
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
        $request = new ListSecurityHealthAnalyticsCustomModulesRequest();
        try {
            $gapicClient->listSecurityHealthAnalyticsCustomModules($request);
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
    public function simulateSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SimulateSecurityHealthAnalyticsCustomModuleResponse();
        $transport->addResponse($expectedResponse);
        $request = new SimulateSecurityHealthAnalyticsCustomModuleRequest();
        $response = $gapicClient->simulateSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/SimulateSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function simulateSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $request = new SimulateSecurityHealthAnalyticsCustomModuleRequest();
        try {
            $gapicClient->simulateSecurityHealthAnalyticsCustomModule($request);
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
    public function updateEventThreatDetectionCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $ancestorModule = 'ancestorModule-521996712';
        $type = 'type3575610';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $lastEditor = 'lastEditor1620154166';
        $expectedResponse = new EventThreatDetectionCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setAncestorModule($ancestorModule);
        $expectedResponse->setType($type);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastEditor($lastEditor);
        $transport->addResponse($expectedResponse);
        $request = new UpdateEventThreatDetectionCustomModuleRequest();
        $response = $gapicClient->updateEventThreatDetectionCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/UpdateEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateEventThreatDetectionCustomModuleExceptionTest()
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
        $request = new UpdateEventThreatDetectionCustomModuleRequest();
        try {
            $gapicClient->updateEventThreatDetectionCustomModule($request);
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
    public function updateSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $lastEditor = 'lastEditor1620154166';
        $ancestorModule = 'ancestorModule-521996712';
        $expectedResponse = new SecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setAncestorModule($ancestorModule);
        $transport->addResponse($expectedResponse);
        $request = new UpdateSecurityHealthAnalyticsCustomModuleRequest();
        $response = $gapicClient->updateSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/UpdateSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $request = new UpdateSecurityHealthAnalyticsCustomModuleRequest();
        try {
            $gapicClient->updateSecurityHealthAnalyticsCustomModule($request);
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
    public function validateEventThreatDetectionCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ValidateEventThreatDetectionCustomModuleResponse();
        $transport->addResponse($expectedResponse);
        $request = new ValidateEventThreatDetectionCustomModuleRequest();
        $response = $gapicClient->validateEventThreatDetectionCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/ValidateEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function validateEventThreatDetectionCustomModuleExceptionTest()
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
        $request = new ValidateEventThreatDetectionCustomModuleRequest();
        try {
            $gapicClient->validateEventThreatDetectionCustomModule($request);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
        $locations = [
            $locationsElement,
        ];
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
    public function createEventThreatDetectionCustomModuleAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $ancestorModule = 'ancestorModule-521996712';
        $type = 'type3575610';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $lastEditor = 'lastEditor1620154166';
        $expectedResponse = new EventThreatDetectionCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setAncestorModule($ancestorModule);
        $expectedResponse->setType($type);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastEditor($lastEditor);
        $transport->addResponse($expectedResponse);
        $request = new CreateEventThreatDetectionCustomModuleRequest();
        $response = $gapicClient->createEventThreatDetectionCustomModuleAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycentermanagement.v1.SecurityCenterManagement/CreateEventThreatDetectionCustomModule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }
}
