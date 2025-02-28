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

namespace Google\Maps\FleetEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Maps\FleetEngine\V1\Client\TripServiceClient;
use Google\Maps\FleetEngine\V1\CreateTripRequest;
use Google\Maps\FleetEngine\V1\DeleteTripRequest;
use Google\Maps\FleetEngine\V1\GetTripRequest;
use Google\Maps\FleetEngine\V1\ReportBillableTripRequest;
use Google\Maps\FleetEngine\V1\SearchTripsRequest;
use Google\Maps\FleetEngine\V1\SearchTripsResponse;
use Google\Maps\FleetEngine\V1\Trip;
use Google\Maps\FleetEngine\V1\UpdateTripRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group fleetengine
 *
 * @group gapic
 */
class TripServiceClientTest extends GeneratedTest
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

    /** @return TripServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TripServiceClient($options);
    }

    /** @test */
    public function createTripTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $vehicleId = 'vehicleId-1378647282';
        $intermediateDestinationIndex = 144716901;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $numberOfPassengers = 674364405;
        $lastLocationSnappable = false;
        $expectedResponse = new Trip();
        $expectedResponse->setName($name);
        $expectedResponse->setVehicleId($vehicleId);
        $expectedResponse->setIntermediateDestinationIndex($intermediateDestinationIndex);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setNumberOfPassengers($numberOfPassengers);
        $expectedResponse->setLastLocationSnappable($lastLocationSnappable);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $tripId = 'tripId-1059631243';
        $trip = new Trip();
        $request = (new CreateTripRequest())
            ->setParent($formattedParent)
            ->setTripId($tripId)
            ->setTrip($trip);
        $response = $gapicClient->createTrip($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/CreateTrip', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTripId();
        $this->assertProtobufEquals($tripId, $actualValue);
        $actualValue = $actualRequestObject->getTrip();
        $this->assertProtobufEquals($trip, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTripExceptionTest()
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
        $formattedParent = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $tripId = 'tripId-1059631243';
        $trip = new Trip();
        $request = (new CreateTripRequest())
            ->setParent($formattedParent)
            ->setTripId($tripId)
            ->setTrip($trip);
        try {
            $gapicClient->createTrip($request);
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
    public function deleteTripTest()
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
        $formattedName = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $request = (new DeleteTripRequest())->setName($formattedName);
        $gapicClient->deleteTrip($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/DeleteTrip', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTripExceptionTest()
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
        $formattedName = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $request = (new DeleteTripRequest())->setName($formattedName);
        try {
            $gapicClient->deleteTrip($request);
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
    public function getTripTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $vehicleId = 'vehicleId-1378647282';
        $intermediateDestinationIndex = 144716901;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $numberOfPassengers = 674364405;
        $lastLocationSnappable = false;
        $expectedResponse = new Trip();
        $expectedResponse->setName($name2);
        $expectedResponse->setVehicleId($vehicleId);
        $expectedResponse->setIntermediateDestinationIndex($intermediateDestinationIndex);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setNumberOfPassengers($numberOfPassengers);
        $expectedResponse->setLastLocationSnappable($lastLocationSnappable);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $request = (new GetTripRequest())->setName($formattedName);
        $response = $gapicClient->getTrip($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/GetTrip', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTripExceptionTest()
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
        $formattedName = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $request = (new GetTripRequest())->setName($formattedName);
        try {
            $gapicClient->getTrip($request);
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
    public function reportBillableTripTest()
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
        $name = 'name3373707';
        $countryCode = 'countryCode1481071862';
        $request = (new ReportBillableTripRequest())->setName($name)->setCountryCode($countryCode);
        $gapicClient->reportBillableTrip($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/ReportBillableTrip', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getCountryCode();
        $this->assertProtobufEquals($countryCode, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function reportBillableTripExceptionTest()
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
        $name = 'name3373707';
        $countryCode = 'countryCode1481071862';
        $request = (new ReportBillableTripRequest())->setName($name)->setCountryCode($countryCode);
        try {
            $gapicClient->reportBillableTrip($request);
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
    public function searchTripsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tripsElement = new Trip();
        $trips = [$tripsElement];
        $expectedResponse = new SearchTripsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTrips($trips);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new SearchTripsRequest())->setParent($parent);
        $response = $gapicClient->searchTrips($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTrips()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/SearchTrips', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchTripsExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new SearchTripsRequest())->setParent($parent);
        try {
            $gapicClient->searchTrips($request);
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
    public function updateTripTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $vehicleId = 'vehicleId-1378647282';
        $intermediateDestinationIndex = 144716901;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $numberOfPassengers = 674364405;
        $lastLocationSnappable = false;
        $expectedResponse = new Trip();
        $expectedResponse->setName($name2);
        $expectedResponse->setVehicleId($vehicleId);
        $expectedResponse->setIntermediateDestinationIndex($intermediateDestinationIndex);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setNumberOfPassengers($numberOfPassengers);
        $expectedResponse->setLastLocationSnappable($lastLocationSnappable);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $trip = new Trip();
        $updateMask = new FieldMask();
        $request = (new UpdateTripRequest())
            ->setName($name)
            ->setTrip($trip)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateTrip($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/UpdateTrip', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getTrip();
        $this->assertProtobufEquals($trip, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTripExceptionTest()
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
        $name = 'name3373707';
        $trip = new Trip();
        $updateMask = new FieldMask();
        $request = (new UpdateTripRequest())
            ->setName($name)
            ->setTrip($trip)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateTrip($request);
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
    public function createTripAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $vehicleId = 'vehicleId-1378647282';
        $intermediateDestinationIndex = 144716901;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $numberOfPassengers = 674364405;
        $lastLocationSnappable = false;
        $expectedResponse = new Trip();
        $expectedResponse->setName($name);
        $expectedResponse->setVehicleId($vehicleId);
        $expectedResponse->setIntermediateDestinationIndex($intermediateDestinationIndex);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setNumberOfPassengers($numberOfPassengers);
        $expectedResponse->setLastLocationSnappable($lastLocationSnappable);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tripName('[PROVIDER]', '[TRIP]');
        $tripId = 'tripId-1059631243';
        $trip = new Trip();
        $request = (new CreateTripRequest())
            ->setParent($formattedParent)
            ->setTripId($tripId)
            ->setTrip($trip);
        $response = $gapicClient->createTripAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.TripService/CreateTrip', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTripId();
        $this->assertProtobufEquals($tripId, $actualValue);
        $actualValue = $actualRequestObject->getTrip();
        $this->assertProtobufEquals($trip, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
