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

namespace Google\Cloud\ApiHub\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\ApiHub\V1\ApplicationIntegrationEndpointDetails;
use Google\Cloud\ApiHub\V1\Client\ApiHubCurateClient;
use Google\Cloud\ApiHub\V1\CreateCurationRequest;
use Google\Cloud\ApiHub\V1\Curation;
use Google\Cloud\ApiHub\V1\DeleteCurationRequest;
use Google\Cloud\ApiHub\V1\Endpoint;
use Google\Cloud\ApiHub\V1\GetCurationRequest;
use Google\Cloud\ApiHub\V1\ListCurationsRequest;
use Google\Cloud\ApiHub\V1\ListCurationsResponse;
use Google\Cloud\ApiHub\V1\UpdateCurationRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group apihub
 *
 * @group gapic
 */
class ApiHubCurateClientTest extends GeneratedTest
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

    /** @return ApiHubCurateClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ApiHubCurateClient($options);
    }

    /** @test */
    public function createCurationTest()
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
        $lastExecutionErrorMessage = 'lastExecutionErrorMessage1578645824';
        $expectedResponse = new Curation();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastExecutionErrorMessage($lastExecutionErrorMessage);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $curation = new Curation();
        $curationDisplayName = 'curationDisplayName-1583854984';
        $curation->setDisplayName($curationDisplayName);
        $curationEndpoint = new Endpoint();
        $endpointApplicationIntegrationEndpointDetails = new ApplicationIntegrationEndpointDetails();
        $applicationIntegrationEndpointDetailsUri = 'applicationIntegrationEndpointDetailsUri-433917757';
        $endpointApplicationIntegrationEndpointDetails->setUri($applicationIntegrationEndpointDetailsUri);
        $applicationIntegrationEndpointDetailsTriggerId = 'applicationIntegrationEndpointDetailsTriggerId-1998070006';
        $endpointApplicationIntegrationEndpointDetails->setTriggerId($applicationIntegrationEndpointDetailsTriggerId);
        $curationEndpoint->setApplicationIntegrationEndpointDetails($endpointApplicationIntegrationEndpointDetails);
        $curation->setEndpoint($curationEndpoint);
        $request = (new CreateCurationRequest())->setParent($formattedParent)->setCuration($curation);
        $response = $gapicClient->createCuration($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apihub.v1.ApiHubCurate/CreateCuration', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCuration();
        $this->assertProtobufEquals($curation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCurationExceptionTest()
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
        $curation = new Curation();
        $curationDisplayName = 'curationDisplayName-1583854984';
        $curation->setDisplayName($curationDisplayName);
        $curationEndpoint = new Endpoint();
        $endpointApplicationIntegrationEndpointDetails = new ApplicationIntegrationEndpointDetails();
        $applicationIntegrationEndpointDetailsUri = 'applicationIntegrationEndpointDetailsUri-433917757';
        $endpointApplicationIntegrationEndpointDetails->setUri($applicationIntegrationEndpointDetailsUri);
        $applicationIntegrationEndpointDetailsTriggerId = 'applicationIntegrationEndpointDetailsTriggerId-1998070006';
        $endpointApplicationIntegrationEndpointDetails->setTriggerId($applicationIntegrationEndpointDetailsTriggerId);
        $curationEndpoint->setApplicationIntegrationEndpointDetails($endpointApplicationIntegrationEndpointDetails);
        $curation->setEndpoint($curationEndpoint);
        $request = (new CreateCurationRequest())->setParent($formattedParent)->setCuration($curation);
        try {
            $gapicClient->createCuration($request);
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
    public function deleteCurationTest()
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
        $formattedName = $gapicClient->curationName('[PROJECT]', '[LOCATION]', '[CURATION]');
        $request = (new DeleteCurationRequest())->setName($formattedName);
        $gapicClient->deleteCuration($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apihub.v1.ApiHubCurate/DeleteCuration', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCurationExceptionTest()
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
        $formattedName = $gapicClient->curationName('[PROJECT]', '[LOCATION]', '[CURATION]');
        $request = (new DeleteCurationRequest())->setName($formattedName);
        try {
            $gapicClient->deleteCuration($request);
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
    public function getCurationTest()
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
        $lastExecutionErrorMessage = 'lastExecutionErrorMessage1578645824';
        $expectedResponse = new Curation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastExecutionErrorMessage($lastExecutionErrorMessage);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->curationName('[PROJECT]', '[LOCATION]', '[CURATION]');
        $request = (new GetCurationRequest())->setName($formattedName);
        $response = $gapicClient->getCuration($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apihub.v1.ApiHubCurate/GetCuration', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCurationExceptionTest()
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
        $formattedName = $gapicClient->curationName('[PROJECT]', '[LOCATION]', '[CURATION]');
        $request = (new GetCurationRequest())->setName($formattedName);
        try {
            $gapicClient->getCuration($request);
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
    public function listCurationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $curationsElement = new Curation();
        $curations = [$curationsElement];
        $expectedResponse = new ListCurationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCurations($curations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListCurationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCurations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCurations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apihub.v1.ApiHubCurate/ListCurations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCurationsExceptionTest()
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
        $request = (new ListCurationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCurations($request);
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
    public function updateCurationTest()
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
        $lastExecutionErrorMessage = 'lastExecutionErrorMessage1578645824';
        $expectedResponse = new Curation();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastExecutionErrorMessage($lastExecutionErrorMessage);
        $transport->addResponse($expectedResponse);
        // Mock request
        $curation = new Curation();
        $curationDisplayName = 'curationDisplayName-1583854984';
        $curation->setDisplayName($curationDisplayName);
        $curationEndpoint = new Endpoint();
        $endpointApplicationIntegrationEndpointDetails = new ApplicationIntegrationEndpointDetails();
        $applicationIntegrationEndpointDetailsUri = 'applicationIntegrationEndpointDetailsUri-433917757';
        $endpointApplicationIntegrationEndpointDetails->setUri($applicationIntegrationEndpointDetailsUri);
        $applicationIntegrationEndpointDetailsTriggerId = 'applicationIntegrationEndpointDetailsTriggerId-1998070006';
        $endpointApplicationIntegrationEndpointDetails->setTriggerId($applicationIntegrationEndpointDetailsTriggerId);
        $curationEndpoint->setApplicationIntegrationEndpointDetails($endpointApplicationIntegrationEndpointDetails);
        $curation->setEndpoint($curationEndpoint);
        $request = (new UpdateCurationRequest())->setCuration($curation);
        $response = $gapicClient->updateCuration($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apihub.v1.ApiHubCurate/UpdateCuration', $actualFuncCall);
        $actualValue = $actualRequestObject->getCuration();
        $this->assertProtobufEquals($curation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCurationExceptionTest()
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
        $curation = new Curation();
        $curationDisplayName = 'curationDisplayName-1583854984';
        $curation->setDisplayName($curationDisplayName);
        $curationEndpoint = new Endpoint();
        $endpointApplicationIntegrationEndpointDetails = new ApplicationIntegrationEndpointDetails();
        $applicationIntegrationEndpointDetailsUri = 'applicationIntegrationEndpointDetailsUri-433917757';
        $endpointApplicationIntegrationEndpointDetails->setUri($applicationIntegrationEndpointDetailsUri);
        $applicationIntegrationEndpointDetailsTriggerId = 'applicationIntegrationEndpointDetailsTriggerId-1998070006';
        $endpointApplicationIntegrationEndpointDetails->setTriggerId($applicationIntegrationEndpointDetailsTriggerId);
        $curationEndpoint->setApplicationIntegrationEndpointDetails($endpointApplicationIntegrationEndpointDetails);
        $curation->setEndpoint($curationEndpoint);
        $request = (new UpdateCurationRequest())->setCuration($curation);
        try {
            $gapicClient->updateCuration($request);
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
    public function createCurationAsyncTest()
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
        $lastExecutionErrorMessage = 'lastExecutionErrorMessage1578645824';
        $expectedResponse = new Curation();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLastExecutionErrorMessage($lastExecutionErrorMessage);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $curation = new Curation();
        $curationDisplayName = 'curationDisplayName-1583854984';
        $curation->setDisplayName($curationDisplayName);
        $curationEndpoint = new Endpoint();
        $endpointApplicationIntegrationEndpointDetails = new ApplicationIntegrationEndpointDetails();
        $applicationIntegrationEndpointDetailsUri = 'applicationIntegrationEndpointDetailsUri-433917757';
        $endpointApplicationIntegrationEndpointDetails->setUri($applicationIntegrationEndpointDetailsUri);
        $applicationIntegrationEndpointDetailsTriggerId = 'applicationIntegrationEndpointDetailsTriggerId-1998070006';
        $endpointApplicationIntegrationEndpointDetails->setTriggerId($applicationIntegrationEndpointDetailsTriggerId);
        $curationEndpoint->setApplicationIntegrationEndpointDetails($endpointApplicationIntegrationEndpointDetails);
        $curation->setEndpoint($curationEndpoint);
        $request = (new CreateCurationRequest())->setParent($formattedParent)->setCuration($curation);
        $response = $gapicClient->createCurationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apihub.v1.ApiHubCurate/CreateCuration', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCuration();
        $this->assertProtobufEquals($curation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
