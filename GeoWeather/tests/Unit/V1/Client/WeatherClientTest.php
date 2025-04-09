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

namespace Google\Geo\Weather\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Geo\Weather\V1\Client\WeatherClient;
use Google\Geo\Weather\V1\ForecastDay;
use Google\Geo\Weather\V1\ForecastHour;
use Google\Geo\Weather\V1\HistoryHour;
use Google\Geo\Weather\V1\LookupCurrentConditionsRequest;
use Google\Geo\Weather\V1\LookupCurrentConditionsResponse;
use Google\Geo\Weather\V1\LookupForecastDaysRequest;
use Google\Geo\Weather\V1\LookupForecastDaysResponse;
use Google\Geo\Weather\V1\LookupForecastHoursRequest;
use Google\Geo\Weather\V1\LookupForecastHoursResponse;
use Google\Geo\Weather\V1\LookupHistoryHoursRequest;
use Google\Geo\Weather\V1\LookupHistoryHoursResponse;
use Google\Rpc\Code;
use Google\Type\LatLng;
use stdClass;

/**
 * @group weather
 *
 * @group gapic
 */
class WeatherClientTest extends GeneratedTest
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

    /** @return WeatherClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new WeatherClient($options);
    }

    /** @test */
    public function lookupCurrentConditionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $isDaytime = true;
        $relativeHumidity = 881141562;
        $uvIndex = 2078253644;
        $thunderstormProbability = 2066850171;
        $cloudCover = 1196074707;
        $expectedResponse = new LookupCurrentConditionsResponse();
        $expectedResponse->setIsDaytime($isDaytime);
        $expectedResponse->setRelativeHumidity($relativeHumidity);
        $expectedResponse->setUvIndex($uvIndex);
        $expectedResponse->setThunderstormProbability($thunderstormProbability);
        $expectedResponse->setCloudCover($cloudCover);
        $transport->addResponse($expectedResponse);
        // Mock request
        $location = new LatLng();
        $request = (new LookupCurrentConditionsRequest())->setLocation($location);
        $response = $gapicClient->lookupCurrentConditions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.maps.weather.v1.Weather/LookupCurrentConditions', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($location, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function lookupCurrentConditionsExceptionTest()
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
        $location = new LatLng();
        $request = (new LookupCurrentConditionsRequest())->setLocation($location);
        try {
            $gapicClient->lookupCurrentConditions($request);
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
    public function lookupForecastDaysTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $forecastDaysElement = new ForecastDay();
        $forecastDays = [$forecastDaysElement];
        $expectedResponse = new LookupForecastDaysResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setForecastDays($forecastDays);
        $transport->addResponse($expectedResponse);
        // Mock request
        $location = new LatLng();
        $request = (new LookupForecastDaysRequest())->setLocation($location);
        $response = $gapicClient->lookupForecastDays($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getForecastDays()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.maps.weather.v1.Weather/LookupForecastDays', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($location, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function lookupForecastDaysExceptionTest()
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
        $location = new LatLng();
        $request = (new LookupForecastDaysRequest())->setLocation($location);
        try {
            $gapicClient->lookupForecastDays($request);
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
    public function lookupForecastHoursTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $forecastHoursElement = new ForecastHour();
        $forecastHours = [$forecastHoursElement];
        $expectedResponse = new LookupForecastHoursResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setForecastHours($forecastHours);
        $transport->addResponse($expectedResponse);
        // Mock request
        $location = new LatLng();
        $request = (new LookupForecastHoursRequest())->setLocation($location);
        $response = $gapicClient->lookupForecastHours($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getForecastHours()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.maps.weather.v1.Weather/LookupForecastHours', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($location, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function lookupForecastHoursExceptionTest()
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
        $location = new LatLng();
        $request = (new LookupForecastHoursRequest())->setLocation($location);
        try {
            $gapicClient->lookupForecastHours($request);
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
    public function lookupHistoryHoursTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $historyHoursElement = new HistoryHour();
        $historyHours = [$historyHoursElement];
        $expectedResponse = new LookupHistoryHoursResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setHistoryHours($historyHours);
        $transport->addResponse($expectedResponse);
        // Mock request
        $location = new LatLng();
        $request = (new LookupHistoryHoursRequest())->setLocation($location);
        $response = $gapicClient->lookupHistoryHours($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getHistoryHours()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.maps.weather.v1.Weather/LookupHistoryHours', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($location, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function lookupHistoryHoursExceptionTest()
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
        $location = new LatLng();
        $request = (new LookupHistoryHoursRequest())->setLocation($location);
        try {
            $gapicClient->lookupHistoryHours($request);
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
    public function lookupCurrentConditionsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $isDaytime = true;
        $relativeHumidity = 881141562;
        $uvIndex = 2078253644;
        $thunderstormProbability = 2066850171;
        $cloudCover = 1196074707;
        $expectedResponse = new LookupCurrentConditionsResponse();
        $expectedResponse->setIsDaytime($isDaytime);
        $expectedResponse->setRelativeHumidity($relativeHumidity);
        $expectedResponse->setUvIndex($uvIndex);
        $expectedResponse->setThunderstormProbability($thunderstormProbability);
        $expectedResponse->setCloudCover($cloudCover);
        $transport->addResponse($expectedResponse);
        // Mock request
        $location = new LatLng();
        $request = (new LookupCurrentConditionsRequest())->setLocation($location);
        $response = $gapicClient->lookupCurrentConditionsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.maps.weather.v1.Weather/LookupCurrentConditions', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($location, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
