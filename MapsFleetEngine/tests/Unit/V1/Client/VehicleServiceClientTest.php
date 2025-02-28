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
use Google\Maps\FleetEngine\V1\Client\VehicleServiceClient;
use Google\Maps\FleetEngine\V1\CreateVehicleRequest;
use Google\Maps\FleetEngine\V1\DeleteVehicleRequest;
use Google\Maps\FleetEngine\V1\GetVehicleRequest;
use Google\Maps\FleetEngine\V1\ListVehiclesRequest;
use Google\Maps\FleetEngine\V1\ListVehiclesResponse;
use Google\Maps\FleetEngine\V1\SearchVehiclesRequest;
use Google\Maps\FleetEngine\V1\SearchVehiclesRequest\VehicleMatchOrder;
use Google\Maps\FleetEngine\V1\SearchVehiclesResponse;
use Google\Maps\FleetEngine\V1\TerminalLocation;
use Google\Maps\FleetEngine\V1\UpdateVehicleAttributesRequest;
use Google\Maps\FleetEngine\V1\UpdateVehicleAttributesResponse;
use Google\Maps\FleetEngine\V1\UpdateVehicleRequest;
use Google\Maps\FleetEngine\V1\Vehicle;
use Google\Maps\FleetEngine\V1\Vehicle\VehicleType;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Type\LatLng;
use stdClass;

/**
 * @group fleetengine
 *
 * @group gapic
 */
class VehicleServiceClientTest extends GeneratedTest
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

    /** @return VehicleServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new VehicleServiceClient($options);
    }

    /** @test */
    public function createVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $maximumCapacity = 582710265;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $backToBackEnabled = false;
        $expectedResponse = new Vehicle();
        $expectedResponse->setName($name);
        $expectedResponse->setMaximumCapacity($maximumCapacity);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setBackToBackEnabled($backToBackEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $vehicleId = 'vehicleId-1378647282';
        $vehicle = new Vehicle();
        $vehicleVehicleType = new VehicleType();
        $vehicle->setVehicleType($vehicleVehicleType);
        $request = (new CreateVehicleRequest())
            ->setParent($parent)
            ->setVehicleId($vehicleId)
            ->setVehicle($vehicle);
        $response = $gapicClient->createVehicle($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/CreateVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getVehicleId();
        $this->assertProtobufEquals($vehicleId, $actualValue);
        $actualValue = $actualRequestObject->getVehicle();
        $this->assertProtobufEquals($vehicle, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createVehicleExceptionTest()
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
        $vehicleId = 'vehicleId-1378647282';
        $vehicle = new Vehicle();
        $vehicleVehicleType = new VehicleType();
        $vehicle->setVehicleType($vehicleVehicleType);
        $request = (new CreateVehicleRequest())
            ->setParent($parent)
            ->setVehicleId($vehicleId)
            ->setVehicle($vehicle);
        try {
            $gapicClient->createVehicle($request);
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
    public function deleteVehicleTest()
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
        $formattedName = $gapicClient->vehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new DeleteVehicleRequest())->setName($formattedName);
        $gapicClient->deleteVehicle($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/DeleteVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteVehicleExceptionTest()
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
        $formattedName = $gapicClient->vehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new DeleteVehicleRequest())->setName($formattedName);
        try {
            $gapicClient->deleteVehicle($request);
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
    public function getVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $maximumCapacity = 582710265;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $backToBackEnabled = false;
        $expectedResponse = new Vehicle();
        $expectedResponse->setName($name2);
        $expectedResponse->setMaximumCapacity($maximumCapacity);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setBackToBackEnabled($backToBackEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->vehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new GetVehicleRequest())->setName($formattedName);
        $response = $gapicClient->getVehicle($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/GetVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getVehicleExceptionTest()
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
        $formattedName = $gapicClient->vehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new GetVehicleRequest())->setName($formattedName);
        try {
            $gapicClient->getVehicle($request);
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
    public function listVehiclesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $vehiclesElement = new Vehicle();
        $vehicles = [$vehiclesElement];
        $expectedResponse = new ListVehiclesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setVehicles($vehicles);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $vehicleTypeCategories = [];
        $request = (new ListVehiclesRequest())->setParent($parent)->setVehicleTypeCategories($vehicleTypeCategories);
        $response = $gapicClient->listVehicles($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getVehicles()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/ListVehicles', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getVehicleTypeCategories();
        $this->assertProtobufEquals($vehicleTypeCategories, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listVehiclesExceptionTest()
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
        $vehicleTypeCategories = [];
        $request = (new ListVehiclesRequest())->setParent($parent)->setVehicleTypeCategories($vehicleTypeCategories);
        try {
            $gapicClient->listVehicles($request);
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
    public function searchVehiclesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SearchVehiclesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $pickupPoint = new TerminalLocation();
        $pickupPointPoint = new LatLng();
        $pickupPoint->setPoint($pickupPointPoint);
        $pickupRadiusMeters = 254656044;
        $count = 94851343;
        $minimumCapacity = 518841803;
        $tripTypes = [];
        $vehicleTypes = [];
        $orderBy = VehicleMatchOrder::UNKNOWN_VEHICLE_MATCH_ORDER;
        $request = (new SearchVehiclesRequest())
            ->setParent($parent)
            ->setPickupPoint($pickupPoint)
            ->setPickupRadiusMeters($pickupRadiusMeters)
            ->setCount($count)
            ->setMinimumCapacity($minimumCapacity)
            ->setTripTypes($tripTypes)
            ->setVehicleTypes($vehicleTypes)
            ->setOrderBy($orderBy);
        $response = $gapicClient->searchVehicles($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/SearchVehicles', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getPickupPoint();
        $this->assertProtobufEquals($pickupPoint, $actualValue);
        $actualValue = $actualRequestObject->getPickupRadiusMeters();
        $this->assertProtobufEquals($pickupRadiusMeters, $actualValue);
        $actualValue = $actualRequestObject->getCount();
        $this->assertProtobufEquals($count, $actualValue);
        $actualValue = $actualRequestObject->getMinimumCapacity();
        $this->assertProtobufEquals($minimumCapacity, $actualValue);
        $actualValue = $actualRequestObject->getTripTypes();
        $this->assertProtobufEquals($tripTypes, $actualValue);
        $actualValue = $actualRequestObject->getVehicleTypes();
        $this->assertProtobufEquals($vehicleTypes, $actualValue);
        $actualValue = $actualRequestObject->getOrderBy();
        $this->assertProtobufEquals($orderBy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchVehiclesExceptionTest()
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
        $pickupPoint = new TerminalLocation();
        $pickupPointPoint = new LatLng();
        $pickupPoint->setPoint($pickupPointPoint);
        $pickupRadiusMeters = 254656044;
        $count = 94851343;
        $minimumCapacity = 518841803;
        $tripTypes = [];
        $vehicleTypes = [];
        $orderBy = VehicleMatchOrder::UNKNOWN_VEHICLE_MATCH_ORDER;
        $request = (new SearchVehiclesRequest())
            ->setParent($parent)
            ->setPickupPoint($pickupPoint)
            ->setPickupRadiusMeters($pickupRadiusMeters)
            ->setCount($count)
            ->setMinimumCapacity($minimumCapacity)
            ->setTripTypes($tripTypes)
            ->setVehicleTypes($vehicleTypes)
            ->setOrderBy($orderBy);
        try {
            $gapicClient->searchVehicles($request);
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
    public function updateVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $maximumCapacity = 582710265;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $backToBackEnabled = false;
        $expectedResponse = new Vehicle();
        $expectedResponse->setName($name2);
        $expectedResponse->setMaximumCapacity($maximumCapacity);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setBackToBackEnabled($backToBackEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $vehicle = new Vehicle();
        $vehicleVehicleType = new VehicleType();
        $vehicle->setVehicleType($vehicleVehicleType);
        $updateMask = new FieldMask();
        $request = (new UpdateVehicleRequest())
            ->setName($name)
            ->setVehicle($vehicle)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateVehicle($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/UpdateVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getVehicle();
        $this->assertProtobufEquals($vehicle, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateVehicleExceptionTest()
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
        $vehicle = new Vehicle();
        $vehicleVehicleType = new VehicleType();
        $vehicle->setVehicleType($vehicleVehicleType);
        $updateMask = new FieldMask();
        $request = (new UpdateVehicleRequest())
            ->setName($name)
            ->setVehicle($vehicle)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateVehicle($request);
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
    public function updateVehicleAttributesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new UpdateVehicleAttributesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $attributes = [];
        $request = (new UpdateVehicleAttributesRequest())->setName($name)->setAttributes($attributes);
        $response = $gapicClient->updateVehicleAttributes($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/UpdateVehicleAttributes', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getAttributes();
        $this->assertProtobufEquals($attributes, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateVehicleAttributesExceptionTest()
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
        $attributes = [];
        $request = (new UpdateVehicleAttributesRequest())->setName($name)->setAttributes($attributes);
        try {
            $gapicClient->updateVehicleAttributes($request);
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
    public function createVehicleAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $maximumCapacity = 582710265;
        $currentRouteSegment = 'currentRouteSegment-289364233';
        $backToBackEnabled = false;
        $expectedResponse = new Vehicle();
        $expectedResponse->setName($name);
        $expectedResponse->setMaximumCapacity($maximumCapacity);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $expectedResponse->setBackToBackEnabled($backToBackEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $vehicleId = 'vehicleId-1378647282';
        $vehicle = new Vehicle();
        $vehicleVehicleType = new VehicleType();
        $vehicle->setVehicleType($vehicleVehicleType);
        $request = (new CreateVehicleRequest())
            ->setParent($parent)
            ->setVehicleId($vehicleId)
            ->setVehicle($vehicle);
        $response = $gapicClient->createVehicleAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.v1.VehicleService/CreateVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getVehicleId();
        $this->assertProtobufEquals($vehicleId, $actualValue);
        $actualValue = $actualRequestObject->getVehicle();
        $this->assertProtobufEquals($vehicle, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
