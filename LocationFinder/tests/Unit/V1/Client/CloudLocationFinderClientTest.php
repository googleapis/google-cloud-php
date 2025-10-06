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

namespace Google\Cloud\LocationFinder\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\LocationFinder\V1\Client\CloudLocationFinderClient;
use Google\Cloud\LocationFinder\V1\CloudLocation;
use Google\Cloud\LocationFinder\V1\GetCloudLocationRequest;
use Google\Cloud\LocationFinder\V1\ListCloudLocationsRequest;
use Google\Cloud\LocationFinder\V1\ListCloudLocationsResponse;
use Google\Cloud\LocationFinder\V1\SearchCloudLocationsRequest;
use Google\Cloud\LocationFinder\V1\SearchCloudLocationsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group locationfinder
 *
 * @group gapic
 */
class CloudLocationFinderClientTest extends GeneratedTest
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

    /** @return CloudLocationFinderClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CloudLocationFinderClient($options);
    }

    /** @test */
    public function getCloudLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $containingCloudLocation = 'containingCloudLocation12323920';
        $displayName = 'displayName1615086568';
        $territoryCode = 'territoryCode-78479630';
        $carbonFreeEnergyPercentage = -15692475;
        $expectedResponse = new CloudLocation();
        $expectedResponse->setName($name2);
        $expectedResponse->setContainingCloudLocation($containingCloudLocation);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setTerritoryCode($territoryCode);
        $expectedResponse->setCarbonFreeEnergyPercentage($carbonFreeEnergyPercentage);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cloudLocationName('[PROJECT]', '[LOCATION]', '[CLOUD_LOCATION]');
        $request = (new GetCloudLocationRequest())->setName($formattedName);
        $response = $gapicClient->getCloudLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.locationfinder.v1.CloudLocationFinder/GetCloudLocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCloudLocationExceptionTest()
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
        $formattedName = $gapicClient->cloudLocationName('[PROJECT]', '[LOCATION]', '[CLOUD_LOCATION]');
        $request = (new GetCloudLocationRequest())->setName($formattedName);
        try {
            $gapicClient->getCloudLocation($request);
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
    public function listCloudLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $cloudLocationsElement = new CloudLocation();
        $cloudLocations = [$cloudLocationsElement];
        $expectedResponse = new ListCloudLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCloudLocations($cloudLocations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListCloudLocationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCloudLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCloudLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.locationfinder.v1.CloudLocationFinder/ListCloudLocations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCloudLocationsExceptionTest()
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
        $request = (new ListCloudLocationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCloudLocations($request);
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
    public function searchCloudLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $cloudLocationsElement = new CloudLocation();
        $cloudLocations = [$cloudLocationsElement];
        $expectedResponse = new SearchCloudLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCloudLocations($cloudLocations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedSourceCloudLocation = $gapicClient->cloudLocationName('[PROJECT]', '[LOCATION]', '[CLOUD_LOCATION]');
        $request = (new SearchCloudLocationsRequest())
            ->setParent($formattedParent)
            ->setSourceCloudLocation($formattedSourceCloudLocation);
        $response = $gapicClient->searchCloudLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCloudLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.locationfinder.v1.CloudLocationFinder/SearchCloudLocations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSourceCloudLocation();
        $this->assertProtobufEquals($formattedSourceCloudLocation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchCloudLocationsExceptionTest()
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
        $formattedSourceCloudLocation = $gapicClient->cloudLocationName('[PROJECT]', '[LOCATION]', '[CLOUD_LOCATION]');
        $request = (new SearchCloudLocationsRequest())
            ->setParent($formattedParent)
            ->setSourceCloudLocation($formattedSourceCloudLocation);
        try {
            $gapicClient->searchCloudLocations($request);
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
    public function getCloudLocationAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $containingCloudLocation = 'containingCloudLocation12323920';
        $displayName = 'displayName1615086568';
        $territoryCode = 'territoryCode-78479630';
        $carbonFreeEnergyPercentage = -15692475;
        $expectedResponse = new CloudLocation();
        $expectedResponse->setName($name2);
        $expectedResponse->setContainingCloudLocation($containingCloudLocation);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setTerritoryCode($territoryCode);
        $expectedResponse->setCarbonFreeEnergyPercentage($carbonFreeEnergyPercentage);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cloudLocationName('[PROJECT]', '[LOCATION]', '[CLOUD_LOCATION]');
        $request = (new GetCloudLocationRequest())->setName($formattedName);
        $response = $gapicClient->getCloudLocationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.locationfinder.v1.CloudLocationFinder/GetCloudLocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
