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

namespace Google\Cloud\CloudSecurityCompliance\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\CloudSecurityCompliance\V1\Client\ConfigClient;
use Google\Cloud\CloudSecurityCompliance\V1\CloudControl;
use Google\Cloud\CloudSecurityCompliance\V1\CreateCloudControlRequest;
use Google\Cloud\CloudSecurityCompliance\V1\CreateFrameworkRequest;
use Google\Cloud\CloudSecurityCompliance\V1\DeleteCloudControlRequest;
use Google\Cloud\CloudSecurityCompliance\V1\DeleteFrameworkRequest;
use Google\Cloud\CloudSecurityCompliance\V1\Framework;
use Google\Cloud\CloudSecurityCompliance\V1\GetCloudControlRequest;
use Google\Cloud\CloudSecurityCompliance\V1\GetFrameworkRequest;
use Google\Cloud\CloudSecurityCompliance\V1\ListCloudControlsRequest;
use Google\Cloud\CloudSecurityCompliance\V1\ListCloudControlsResponse;
use Google\Cloud\CloudSecurityCompliance\V1\ListFrameworksRequest;
use Google\Cloud\CloudSecurityCompliance\V1\ListFrameworksResponse;
use Google\Cloud\CloudSecurityCompliance\V1\UpdateCloudControlRequest;
use Google\Cloud\CloudSecurityCompliance\V1\UpdateFrameworkRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group cloudsecuritycompliance
 *
 * @group gapic
 */
class ConfigClientTest extends GeneratedTest
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

    /** @return ConfigClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ConfigClient($options);
    }

    /** @test */
    public function createCloudControlTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $majorRevisionId = 612576889;
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $findingCategory = 'findingCategory1739472116';
        $remediationSteps = 'remediationSteps-161402227';
        $expectedResponse = new CloudControl();
        $expectedResponse->setName($name);
        $expectedResponse->setMajorRevisionId($majorRevisionId);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setFindingCategory($findingCategory);
        $expectedResponse->setRemediationSteps($remediationSteps);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $cloudControlId = 'cloudControlId2101815175';
        $cloudControl = new CloudControl();
        $cloudControlName = 'cloudControlName328508435';
        $cloudControl->setName($cloudControlName);
        $request = (new CreateCloudControlRequest())
            ->setParent($formattedParent)
            ->setCloudControlId($cloudControlId)
            ->setCloudControl($cloudControl);
        $response = $gapicClient->createCloudControl($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/CreateCloudControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCloudControlId();
        $this->assertProtobufEquals($cloudControlId, $actualValue);
        $actualValue = $actualRequestObject->getCloudControl();
        $this->assertProtobufEquals($cloudControl, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCloudControlExceptionTest()
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
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $cloudControlId = 'cloudControlId2101815175';
        $cloudControl = new CloudControl();
        $cloudControlName = 'cloudControlName328508435';
        $cloudControl->setName($cloudControlName);
        $request = (new CreateCloudControlRequest())
            ->setParent($formattedParent)
            ->setCloudControlId($cloudControlId)
            ->setCloudControl($cloudControl);
        try {
            $gapicClient->createCloudControl($request);
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
    public function createFrameworkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $majorRevisionId = 612576889;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new Framework();
        $expectedResponse->setName($name);
        $expectedResponse->setMajorRevisionId($majorRevisionId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $frameworkId = 'frameworkId1716868860';
        $framework = new Framework();
        $frameworkName = 'frameworkName1682813353';
        $framework->setName($frameworkName);
        $request = (new CreateFrameworkRequest())
            ->setParent($formattedParent)
            ->setFrameworkId($frameworkId)
            ->setFramework($framework);
        $response = $gapicClient->createFramework($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/CreateFramework', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getFrameworkId();
        $this->assertProtobufEquals($frameworkId, $actualValue);
        $actualValue = $actualRequestObject->getFramework();
        $this->assertProtobufEquals($framework, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createFrameworkExceptionTest()
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
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $frameworkId = 'frameworkId1716868860';
        $framework = new Framework();
        $frameworkName = 'frameworkName1682813353';
        $framework->setName($frameworkName);
        $request = (new CreateFrameworkRequest())
            ->setParent($formattedParent)
            ->setFrameworkId($frameworkId)
            ->setFramework($framework);
        try {
            $gapicClient->createFramework($request);
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
    public function deleteCloudControlTest()
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
        $formattedName = $gapicClient->cloudControlName('[ORGANIZATION]', '[LOCATION]', '[CLOUD_CONTROL]');
        $request = (new DeleteCloudControlRequest())->setName($formattedName);
        $gapicClient->deleteCloudControl($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/DeleteCloudControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCloudControlExceptionTest()
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
        $formattedName = $gapicClient->cloudControlName('[ORGANIZATION]', '[LOCATION]', '[CLOUD_CONTROL]');
        $request = (new DeleteCloudControlRequest())->setName($formattedName);
        try {
            $gapicClient->deleteCloudControl($request);
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
    public function deleteFrameworkTest()
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
        $formattedName = $gapicClient->frameworkName('[ORGANIZATION]', '[LOCATION]', '[FRAMEWORK]');
        $request = (new DeleteFrameworkRequest())->setName($formattedName);
        $gapicClient->deleteFramework($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/DeleteFramework', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteFrameworkExceptionTest()
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
        $formattedName = $gapicClient->frameworkName('[ORGANIZATION]', '[LOCATION]', '[FRAMEWORK]');
        $request = (new DeleteFrameworkRequest())->setName($formattedName);
        try {
            $gapicClient->deleteFramework($request);
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
    public function getCloudControlTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $majorRevisionId2 = 275873772;
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $findingCategory = 'findingCategory1739472116';
        $remediationSteps = 'remediationSteps-161402227';
        $expectedResponse = new CloudControl();
        $expectedResponse->setName($name2);
        $expectedResponse->setMajorRevisionId($majorRevisionId2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setFindingCategory($findingCategory);
        $expectedResponse->setRemediationSteps($remediationSteps);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cloudControlName('[ORGANIZATION]', '[LOCATION]', '[CLOUD_CONTROL]');
        $request = (new GetCloudControlRequest())->setName($formattedName);
        $response = $gapicClient->getCloudControl($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/GetCloudControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCloudControlExceptionTest()
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
        $formattedName = $gapicClient->cloudControlName('[ORGANIZATION]', '[LOCATION]', '[CLOUD_CONTROL]');
        $request = (new GetCloudControlRequest())->setName($formattedName);
        try {
            $gapicClient->getCloudControl($request);
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
    public function getFrameworkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $majorRevisionId2 = 275873772;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new Framework();
        $expectedResponse->setName($name2);
        $expectedResponse->setMajorRevisionId($majorRevisionId2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->frameworkName('[ORGANIZATION]', '[LOCATION]', '[FRAMEWORK]');
        $request = (new GetFrameworkRequest())->setName($formattedName);
        $response = $gapicClient->getFramework($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/GetFramework', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFrameworkExceptionTest()
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
        $formattedName = $gapicClient->frameworkName('[ORGANIZATION]', '[LOCATION]', '[FRAMEWORK]');
        $request = (new GetFrameworkRequest())->setName($formattedName);
        try {
            $gapicClient->getFramework($request);
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
    public function listCloudControlsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $cloudControlsElement = new CloudControl();
        $cloudControls = [$cloudControlsElement];
        $expectedResponse = new ListCloudControlsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCloudControls($cloudControls);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListCloudControlsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCloudControls($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCloudControls()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/ListCloudControls', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCloudControlsExceptionTest()
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
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListCloudControlsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCloudControls($request);
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
    public function listFrameworksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $frameworksElement = new Framework();
        $frameworks = [$frameworksElement];
        $expectedResponse = new ListFrameworksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFrameworks($frameworks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListFrameworksRequest())->setParent($formattedParent);
        $response = $gapicClient->listFrameworks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFrameworks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/ListFrameworks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFrameworksExceptionTest()
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
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListFrameworksRequest())->setParent($formattedParent);
        try {
            $gapicClient->listFrameworks($request);
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
    public function updateCloudControlTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $majorRevisionId = 612576889;
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $findingCategory = 'findingCategory1739472116';
        $remediationSteps = 'remediationSteps-161402227';
        $expectedResponse = new CloudControl();
        $expectedResponse->setName($name);
        $expectedResponse->setMajorRevisionId($majorRevisionId);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setFindingCategory($findingCategory);
        $expectedResponse->setRemediationSteps($remediationSteps);
        $transport->addResponse($expectedResponse);
        // Mock request
        $cloudControl = new CloudControl();
        $cloudControlName = 'cloudControlName328508435';
        $cloudControl->setName($cloudControlName);
        $request = (new UpdateCloudControlRequest())->setCloudControl($cloudControl);
        $response = $gapicClient->updateCloudControl($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/UpdateCloudControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getCloudControl();
        $this->assertProtobufEquals($cloudControl, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCloudControlExceptionTest()
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
        $cloudControl = new CloudControl();
        $cloudControlName = 'cloudControlName328508435';
        $cloudControl->setName($cloudControlName);
        $request = (new UpdateCloudControlRequest())->setCloudControl($cloudControl);
        try {
            $gapicClient->updateCloudControl($request);
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
    public function updateFrameworkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $majorRevisionId2 = 275873772;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new Framework();
        $expectedResponse->setName($name);
        $expectedResponse->setMajorRevisionId($majorRevisionId2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $framework = new Framework();
        $frameworkName = 'frameworkName1682813353';
        $framework->setName($frameworkName);
        $request = (new UpdateFrameworkRequest())->setFramework($framework);
        $response = $gapicClient->updateFramework($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/UpdateFramework', $actualFuncCall);
        $actualValue = $actualRequestObject->getFramework();
        $this->assertProtobufEquals($framework, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateFrameworkExceptionTest()
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
        $framework = new Framework();
        $frameworkName = 'frameworkName1682813353';
        $framework->setName($frameworkName);
        $request = (new UpdateFrameworkRequest())->setFramework($framework);
        try {
            $gapicClient->updateFramework($request);
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
    public function createCloudControlAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $majorRevisionId = 612576889;
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $findingCategory = 'findingCategory1739472116';
        $remediationSteps = 'remediationSteps-161402227';
        $expectedResponse = new CloudControl();
        $expectedResponse->setName($name);
        $expectedResponse->setMajorRevisionId($majorRevisionId);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setFindingCategory($findingCategory);
        $expectedResponse->setRemediationSteps($remediationSteps);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $cloudControlId = 'cloudControlId2101815175';
        $cloudControl = new CloudControl();
        $cloudControlName = 'cloudControlName328508435';
        $cloudControl->setName($cloudControlName);
        $request = (new CreateCloudControlRequest())
            ->setParent($formattedParent)
            ->setCloudControlId($cloudControlId)
            ->setCloudControl($cloudControl);
        $response = $gapicClient->createCloudControlAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudsecuritycompliance.v1.Config/CreateCloudControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCloudControlId();
        $this->assertProtobufEquals($cloudControlId, $actualValue);
        $actualValue = $actualRequestObject->getCloudControl();
        $this->assertProtobufEquals($cloudControl, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
