<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Analytics\Admin\Tests\Unit\V1beta\Client;

use Google\Analytics\Admin\V1beta\Account;
use Google\Analytics\Admin\V1beta\AccountSummary;
use Google\Analytics\Admin\V1beta\AcknowledgeUserDataCollectionRequest;
use Google\Analytics\Admin\V1beta\AcknowledgeUserDataCollectionResponse;
use Google\Analytics\Admin\V1beta\ArchiveCustomDimensionRequest;
use Google\Analytics\Admin\V1beta\ArchiveCustomMetricRequest;
use Google\Analytics\Admin\V1beta\ChangeHistoryEvent;
use Google\Analytics\Admin\V1beta\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1beta\ConversionEvent;
use Google\Analytics\Admin\V1beta\CreateConversionEventRequest;
use Google\Analytics\Admin\V1beta\CreateCustomDimensionRequest;
use Google\Analytics\Admin\V1beta\CreateCustomMetricRequest;
use Google\Analytics\Admin\V1beta\CreateDataStreamRequest;
use Google\Analytics\Admin\V1beta\CreateFirebaseLinkRequest;
use Google\Analytics\Admin\V1beta\CreateGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1beta\CreateMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1beta\CreatePropertyRequest;
use Google\Analytics\Admin\V1beta\CustomDimension;
use Google\Analytics\Admin\V1beta\CustomDimension\DimensionScope;
use Google\Analytics\Admin\V1beta\CustomMetric;
use Google\Analytics\Admin\V1beta\CustomMetric\MeasurementUnit;
use Google\Analytics\Admin\V1beta\CustomMetric\MetricScope;
use Google\Analytics\Admin\V1beta\DataRetentionSettings;
use Google\Analytics\Admin\V1beta\DataSharingSettings;
use Google\Analytics\Admin\V1beta\DataStream;
use Google\Analytics\Admin\V1beta\DataStream\DataStreamType;
use Google\Analytics\Admin\V1beta\DeleteAccountRequest;
use Google\Analytics\Admin\V1beta\DeleteConversionEventRequest;
use Google\Analytics\Admin\V1beta\DeleteDataStreamRequest;
use Google\Analytics\Admin\V1beta\DeleteFirebaseLinkRequest;
use Google\Analytics\Admin\V1beta\DeleteGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1beta\DeleteMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1beta\DeletePropertyRequest;
use Google\Analytics\Admin\V1beta\FirebaseLink;
use Google\Analytics\Admin\V1beta\GetAccountRequest;
use Google\Analytics\Admin\V1beta\GetConversionEventRequest;
use Google\Analytics\Admin\V1beta\GetCustomDimensionRequest;
use Google\Analytics\Admin\V1beta\GetCustomMetricRequest;
use Google\Analytics\Admin\V1beta\GetDataRetentionSettingsRequest;
use Google\Analytics\Admin\V1beta\GetDataSharingSettingsRequest;
use Google\Analytics\Admin\V1beta\GetDataStreamRequest;
use Google\Analytics\Admin\V1beta\GetMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1beta\GetPropertyRequest;
use Google\Analytics\Admin\V1beta\GoogleAdsLink;
use Google\Analytics\Admin\V1beta\ListAccountSummariesRequest;
use Google\Analytics\Admin\V1beta\ListAccountSummariesResponse;
use Google\Analytics\Admin\V1beta\ListAccountsRequest;
use Google\Analytics\Admin\V1beta\ListAccountsResponse;
use Google\Analytics\Admin\V1beta\ListConversionEventsRequest;
use Google\Analytics\Admin\V1beta\ListConversionEventsResponse;
use Google\Analytics\Admin\V1beta\ListCustomDimensionsRequest;
use Google\Analytics\Admin\V1beta\ListCustomDimensionsResponse;
use Google\Analytics\Admin\V1beta\ListCustomMetricsRequest;
use Google\Analytics\Admin\V1beta\ListCustomMetricsResponse;
use Google\Analytics\Admin\V1beta\ListDataStreamsRequest;
use Google\Analytics\Admin\V1beta\ListDataStreamsResponse;
use Google\Analytics\Admin\V1beta\ListFirebaseLinksRequest;
use Google\Analytics\Admin\V1beta\ListFirebaseLinksResponse;
use Google\Analytics\Admin\V1beta\ListGoogleAdsLinksRequest;
use Google\Analytics\Admin\V1beta\ListGoogleAdsLinksResponse;
use Google\Analytics\Admin\V1beta\ListMeasurementProtocolSecretsRequest;
use Google\Analytics\Admin\V1beta\ListMeasurementProtocolSecretsResponse;
use Google\Analytics\Admin\V1beta\ListPropertiesRequest;
use Google\Analytics\Admin\V1beta\ListPropertiesResponse;
use Google\Analytics\Admin\V1beta\MeasurementProtocolSecret;
use Google\Analytics\Admin\V1beta\Property;
use Google\Analytics\Admin\V1beta\ProvisionAccountTicketRequest;
use Google\Analytics\Admin\V1beta\ProvisionAccountTicketResponse;
use Google\Analytics\Admin\V1beta\RunAccessReportRequest;
use Google\Analytics\Admin\V1beta\RunAccessReportResponse;
use Google\Analytics\Admin\V1beta\SearchChangeHistoryEventsRequest;
use Google\Analytics\Admin\V1beta\SearchChangeHistoryEventsResponse;
use Google\Analytics\Admin\V1beta\UpdateAccountRequest;
use Google\Analytics\Admin\V1beta\UpdateConversionEventRequest;
use Google\Analytics\Admin\V1beta\UpdateCustomDimensionRequest;
use Google\Analytics\Admin\V1beta\UpdateCustomMetricRequest;
use Google\Analytics\Admin\V1beta\UpdateDataRetentionSettingsRequest;
use Google\Analytics\Admin\V1beta\UpdateDataStreamRequest;
use Google\Analytics\Admin\V1beta\UpdateGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1beta\UpdateMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1beta\UpdatePropertyRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admin
 *
 * @group gapic
 */
class AnalyticsAdminServiceClientTest extends GeneratedTest
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

    /** @return AnalyticsAdminServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AnalyticsAdminServiceClient($options);
    }

    /** @test */
    public function acknowledgeUserDataCollectionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AcknowledgeUserDataCollectionResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedProperty = $gapicClient->propertyName('[PROPERTY]');
        $acknowledgement = 'acknowledgement1769490938';
        $request = (new AcknowledgeUserDataCollectionRequest())
            ->setProperty($formattedProperty)
            ->setAcknowledgement($acknowledgement);
        $response = $gapicClient->acknowledgeUserDataCollection($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/AcknowledgeUserDataCollection', $actualFuncCall);
        $actualValue = $actualRequestObject->getProperty();
        $this->assertProtobufEquals($formattedProperty, $actualValue);
        $actualValue = $actualRequestObject->getAcknowledgement();
        $this->assertProtobufEquals($acknowledgement, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function acknowledgeUserDataCollectionExceptionTest()
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
        // Mock request
        $formattedProperty = $gapicClient->propertyName('[PROPERTY]');
        $acknowledgement = 'acknowledgement1769490938';
        $request = (new AcknowledgeUserDataCollectionRequest())
            ->setProperty($formattedProperty)
            ->setAcknowledgement($acknowledgement);
        try {
            $gapicClient->acknowledgeUserDataCollection($request);
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
    public function archiveCustomDimensionTest()
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
        $formattedName = $gapicClient->customDimensionName('[PROPERTY]', '[CUSTOM_DIMENSION]');
        $request = (new ArchiveCustomDimensionRequest())
            ->setName($formattedName);
        $gapicClient->archiveCustomDimension($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ArchiveCustomDimension', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function archiveCustomDimensionExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->customDimensionName('[PROPERTY]', '[CUSTOM_DIMENSION]');
        $request = (new ArchiveCustomDimensionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->archiveCustomDimension($request);
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
    public function archiveCustomMetricTest()
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
        $formattedName = $gapicClient->customMetricName('[PROPERTY]', '[CUSTOM_METRIC]');
        $request = (new ArchiveCustomMetricRequest())
            ->setName($formattedName);
        $gapicClient->archiveCustomMetric($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ArchiveCustomMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function archiveCustomMetricExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->customMetricName('[PROPERTY]', '[CUSTOM_METRIC]');
        $request = (new ArchiveCustomMetricRequest())
            ->setName($formattedName);
        try {
            $gapicClient->archiveCustomMetric($request);
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
    public function createConversionEventTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $eventName = 'eventName984174864';
        $deletable = true;
        $custom = false;
        $expectedResponse = new ConversionEvent();
        $expectedResponse->setName($name);
        $expectedResponse->setEventName($eventName);
        $expectedResponse->setDeletable($deletable);
        $expectedResponse->setCustom($custom);
        $transport->addResponse($expectedResponse);
        // Mock request
        $conversionEvent = new ConversionEvent();
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new CreateConversionEventRequest())
            ->setConversionEvent($conversionEvent)
            ->setParent($formattedParent);
        $response = $gapicClient->createConversionEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateConversionEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getConversionEvent();
        $this->assertProtobufEquals($conversionEvent, $actualValue);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createConversionEventExceptionTest()
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
        // Mock request
        $conversionEvent = new ConversionEvent();
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new CreateConversionEventRequest())
            ->setConversionEvent($conversionEvent)
            ->setParent($formattedParent);
        try {
            $gapicClient->createConversionEvent($request);
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
    public function createCustomDimensionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parameterName = 'parameterName1133142369';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $disallowAdsPersonalization = false;
        $expectedResponse = new CustomDimension();
        $expectedResponse->setName($name);
        $expectedResponse->setParameterName($parameterName);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisallowAdsPersonalization($disallowAdsPersonalization);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $customDimension = new CustomDimension();
        $customDimensionParameterName = 'customDimensionParameterName-405505313';
        $customDimension->setParameterName($customDimensionParameterName);
        $customDimensionDisplayName = 'customDimensionDisplayName2102948408';
        $customDimension->setDisplayName($customDimensionDisplayName);
        $customDimensionScope = DimensionScope::DIMENSION_SCOPE_UNSPECIFIED;
        $customDimension->setScope($customDimensionScope);
        $request = (new CreateCustomDimensionRequest())
            ->setParent($formattedParent)
            ->setCustomDimension($customDimension);
        $response = $gapicClient->createCustomDimension($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateCustomDimension', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCustomDimension();
        $this->assertProtobufEquals($customDimension, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomDimensionExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $customDimension = new CustomDimension();
        $customDimensionParameterName = 'customDimensionParameterName-405505313';
        $customDimension->setParameterName($customDimensionParameterName);
        $customDimensionDisplayName = 'customDimensionDisplayName2102948408';
        $customDimension->setDisplayName($customDimensionDisplayName);
        $customDimensionScope = DimensionScope::DIMENSION_SCOPE_UNSPECIFIED;
        $customDimension->setScope($customDimensionScope);
        $request = (new CreateCustomDimensionRequest())
            ->setParent($formattedParent)
            ->setCustomDimension($customDimension);
        try {
            $gapicClient->createCustomDimension($request);
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
    public function createCustomMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parameterName = 'parameterName1133142369';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new CustomMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setParameterName($parameterName);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $customMetric = new CustomMetric();
        $customMetricParameterName = 'customMetricParameterName1627167443';
        $customMetric->setParameterName($customMetricParameterName);
        $customMetricDisplayName = 'customMetricDisplayName-835715284';
        $customMetric->setDisplayName($customMetricDisplayName);
        $customMetricMeasurementUnit = MeasurementUnit::MEASUREMENT_UNIT_UNSPECIFIED;
        $customMetric->setMeasurementUnit($customMetricMeasurementUnit);
        $customMetricScope = MetricScope::METRIC_SCOPE_UNSPECIFIED;
        $customMetric->setScope($customMetricScope);
        $request = (new CreateCustomMetricRequest())
            ->setParent($formattedParent)
            ->setCustomMetric($customMetric);
        $response = $gapicClient->createCustomMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateCustomMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCustomMetric();
        $this->assertProtobufEquals($customMetric, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomMetricExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $customMetric = new CustomMetric();
        $customMetricParameterName = 'customMetricParameterName1627167443';
        $customMetric->setParameterName($customMetricParameterName);
        $customMetricDisplayName = 'customMetricDisplayName-835715284';
        $customMetric->setDisplayName($customMetricDisplayName);
        $customMetricMeasurementUnit = MeasurementUnit::MEASUREMENT_UNIT_UNSPECIFIED;
        $customMetric->setMeasurementUnit($customMetricMeasurementUnit);
        $customMetricScope = MetricScope::METRIC_SCOPE_UNSPECIFIED;
        $customMetric->setScope($customMetricScope);
        $request = (new CreateCustomMetricRequest())
            ->setParent($formattedParent)
            ->setCustomMetric($customMetric);
        try {
            $gapicClient->createCustomMetric($request);
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
    public function createDataStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataStream();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $dataStream = new DataStream();
        $dataStreamType = DataStreamType::DATA_STREAM_TYPE_UNSPECIFIED;
        $dataStream->setType($dataStreamType);
        $request = (new CreateDataStreamRequest())
            ->setParent($formattedParent)
            ->setDataStream($dataStream);
        $response = $gapicClient->createDataStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateDataStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataStream();
        $this->assertProtobufEquals($dataStream, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataStreamExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $dataStream = new DataStream();
        $dataStreamType = DataStreamType::DATA_STREAM_TYPE_UNSPECIFIED;
        $dataStream->setType($dataStreamType);
        $request = (new CreateDataStreamRequest())
            ->setParent($formattedParent)
            ->setDataStream($dataStream);
        try {
            $gapicClient->createDataStream($request);
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
    public function createFirebaseLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $project = 'project-309310695';
        $expectedResponse = new FirebaseLink();
        $expectedResponse->setName($name);
        $expectedResponse->setProject($project);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $firebaseLink = new FirebaseLink();
        $request = (new CreateFirebaseLinkRequest())
            ->setParent($formattedParent)
            ->setFirebaseLink($firebaseLink);
        $response = $gapicClient->createFirebaseLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateFirebaseLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getFirebaseLink();
        $this->assertProtobufEquals($firebaseLink, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createFirebaseLinkExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $firebaseLink = new FirebaseLink();
        $request = (new CreateFirebaseLinkRequest())
            ->setParent($formattedParent)
            ->setFirebaseLink($firebaseLink);
        try {
            $gapicClient->createFirebaseLink($request);
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
    public function createGoogleAdsLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $customerId = 'customerId-1772061412';
        $canManageClients = false;
        $creatorEmailAddress = 'creatorEmailAddress-1491810434';
        $expectedResponse = new GoogleAdsLink();
        $expectedResponse->setName($name);
        $expectedResponse->setCustomerId($customerId);
        $expectedResponse->setCanManageClients($canManageClients);
        $expectedResponse->setCreatorEmailAddress($creatorEmailAddress);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $googleAdsLink = new GoogleAdsLink();
        $request = (new CreateGoogleAdsLinkRequest())
            ->setParent($formattedParent)
            ->setGoogleAdsLink($googleAdsLink);
        $response = $gapicClient->createGoogleAdsLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateGoogleAdsLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getGoogleAdsLink();
        $this->assertProtobufEquals($googleAdsLink, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createGoogleAdsLinkExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $googleAdsLink = new GoogleAdsLink();
        $request = (new CreateGoogleAdsLinkRequest())
            ->setParent($formattedParent)
            ->setGoogleAdsLink($googleAdsLink);
        try {
            $gapicClient->createGoogleAdsLink($request);
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
    public function createMeasurementProtocolSecretTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $secretValue = 'secretValue1322942242';
        $expectedResponse = new MeasurementProtocolSecret();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setSecretValue($secretValue);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $measurementProtocolSecret = new MeasurementProtocolSecret();
        $measurementProtocolSecretDisplayName = 'measurementProtocolSecretDisplayName1279116681';
        $measurementProtocolSecret->setDisplayName($measurementProtocolSecretDisplayName);
        $request = (new CreateMeasurementProtocolSecretRequest())
            ->setParent($formattedParent)
            ->setMeasurementProtocolSecret($measurementProtocolSecret);
        $response = $gapicClient->createMeasurementProtocolSecret($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateMeasurementProtocolSecret', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getMeasurementProtocolSecret();
        $this->assertProtobufEquals($measurementProtocolSecret, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createMeasurementProtocolSecretExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $measurementProtocolSecret = new MeasurementProtocolSecret();
        $measurementProtocolSecretDisplayName = 'measurementProtocolSecretDisplayName1279116681';
        $measurementProtocolSecret->setDisplayName($measurementProtocolSecretDisplayName);
        $request = (new CreateMeasurementProtocolSecretRequest())
            ->setParent($formattedParent)
            ->setMeasurementProtocolSecret($measurementProtocolSecret);
        try {
            $gapicClient->createMeasurementProtocolSecret($request);
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
    public function createPropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parent = 'parent-995424086';
        $displayName = 'displayName1615086568';
        $timeZone = 'timeZone36848094';
        $currencyCode = 'currencyCode1108728155';
        $account = 'account-1177318867';
        $expectedResponse = new Property();
        $expectedResponse->setName($name);
        $expectedResponse->setParent($parent);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setCurrencyCode($currencyCode);
        $expectedResponse->setAccount($account);
        $transport->addResponse($expectedResponse);
        // Mock request
        $property = new Property();
        $propertyDisplayName = 'propertyDisplayName-1254483624';
        $property->setDisplayName($propertyDisplayName);
        $propertyTimeZone = 'propertyTimeZone-1600366322';
        $property->setTimeZone($propertyTimeZone);
        $request = (new CreatePropertyRequest())
            ->setProperty($property);
        $response = $gapicClient->createProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateProperty', $actualFuncCall);
        $actualValue = $actualRequestObject->getProperty();
        $this->assertProtobufEquals($property, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPropertyExceptionTest()
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
        // Mock request
        $property = new Property();
        $propertyDisplayName = 'propertyDisplayName-1254483624';
        $property->setDisplayName($propertyDisplayName);
        $propertyTimeZone = 'propertyTimeZone-1600366322';
        $property->setTimeZone($propertyTimeZone);
        $request = (new CreatePropertyRequest())
            ->setProperty($property);
        try {
            $gapicClient->createProperty($request);
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
    public function deleteAccountTest()
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
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new DeleteAccountRequest())
            ->setName($formattedName);
        $gapicClient->deleteAccount($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAccountExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new DeleteAccountRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAccount($request);
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
    public function deleteConversionEventTest()
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
        $formattedName = $gapicClient->conversionEventName('[PROPERTY]', '[CONVERSION_EVENT]');
        $request = (new DeleteConversionEventRequest())
            ->setName($formattedName);
        $gapicClient->deleteConversionEvent($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteConversionEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteConversionEventExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->conversionEventName('[PROPERTY]', '[CONVERSION_EVENT]');
        $request = (new DeleteConversionEventRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteConversionEvent($request);
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
    public function deleteDataStreamTest()
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
        $formattedName = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $request = (new DeleteDataStreamRequest())
            ->setName($formattedName);
        $gapicClient->deleteDataStream($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteDataStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDataStreamExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $request = (new DeleteDataStreamRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteDataStream($request);
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
    public function deleteFirebaseLinkTest()
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
        $formattedName = $gapicClient->firebaseLinkName('[PROPERTY]', '[FIREBASE_LINK]');
        $request = (new DeleteFirebaseLinkRequest())
            ->setName($formattedName);
        $gapicClient->deleteFirebaseLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteFirebaseLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteFirebaseLinkExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->firebaseLinkName('[PROPERTY]', '[FIREBASE_LINK]');
        $request = (new DeleteFirebaseLinkRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteFirebaseLink($request);
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
    public function deleteGoogleAdsLinkTest()
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
        $formattedName = $gapicClient->googleAdsLinkName('[PROPERTY]', '[GOOGLE_ADS_LINK]');
        $request = (new DeleteGoogleAdsLinkRequest())
            ->setName($formattedName);
        $gapicClient->deleteGoogleAdsLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteGoogleAdsLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteGoogleAdsLinkExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->googleAdsLinkName('[PROPERTY]', '[GOOGLE_ADS_LINK]');
        $request = (new DeleteGoogleAdsLinkRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteGoogleAdsLink($request);
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
    public function deleteMeasurementProtocolSecretTest()
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
        $formattedName = $gapicClient->measurementProtocolSecretName('[PROPERTY]', '[DATA_STREAM]', '[MEASUREMENT_PROTOCOL_SECRET]');
        $request = (new DeleteMeasurementProtocolSecretRequest())
            ->setName($formattedName);
        $gapicClient->deleteMeasurementProtocolSecret($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteMeasurementProtocolSecret', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteMeasurementProtocolSecretExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->measurementProtocolSecretName('[PROPERTY]', '[DATA_STREAM]', '[MEASUREMENT_PROTOCOL_SECRET]');
        $request = (new DeleteMeasurementProtocolSecretRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteMeasurementProtocolSecret($request);
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
    public function deletePropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parent = 'parent-995424086';
        $displayName = 'displayName1615086568';
        $timeZone = 'timeZone36848094';
        $currencyCode = 'currencyCode1108728155';
        $account = 'account-1177318867';
        $expectedResponse = new Property();
        $expectedResponse->setName($name2);
        $expectedResponse->setParent($parent);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setCurrencyCode($currencyCode);
        $expectedResponse->setAccount($account);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->propertyName('[PROPERTY]');
        $request = (new DeletePropertyRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteProperty', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deletePropertyExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->propertyName('[PROPERTY]');
        $request = (new DeletePropertyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteProperty($request);
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
    public function getAccountTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $regionCode = 'regionCode-1566082984';
        $deleted = false;
        $expectedResponse = new Account();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setDeleted($deleted);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new GetAccountRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccountExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new GetAccountRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAccount($request);
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
    public function getConversionEventTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $eventName = 'eventName984174864';
        $deletable = true;
        $custom = false;
        $expectedResponse = new ConversionEvent();
        $expectedResponse->setName($name2);
        $expectedResponse->setEventName($eventName);
        $expectedResponse->setDeletable($deletable);
        $expectedResponse->setCustom($custom);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->conversionEventName('[PROPERTY]', '[CONVERSION_EVENT]');
        $request = (new GetConversionEventRequest())
            ->setName($formattedName);
        $response = $gapicClient->getConversionEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetConversionEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getConversionEventExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->conversionEventName('[PROPERTY]', '[CONVERSION_EVENT]');
        $request = (new GetConversionEventRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getConversionEvent($request);
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
    public function getCustomDimensionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parameterName = 'parameterName1133142369';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $disallowAdsPersonalization = false;
        $expectedResponse = new CustomDimension();
        $expectedResponse->setName($name2);
        $expectedResponse->setParameterName($parameterName);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisallowAdsPersonalization($disallowAdsPersonalization);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customDimensionName('[PROPERTY]', '[CUSTOM_DIMENSION]');
        $request = (new GetCustomDimensionRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCustomDimension($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetCustomDimension', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomDimensionExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->customDimensionName('[PROPERTY]', '[CUSTOM_DIMENSION]');
        $request = (new GetCustomDimensionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCustomDimension($request);
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
    public function getCustomMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parameterName = 'parameterName1133142369';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new CustomMetric();
        $expectedResponse->setName($name2);
        $expectedResponse->setParameterName($parameterName);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customMetricName('[PROPERTY]', '[CUSTOM_METRIC]');
        $request = (new GetCustomMetricRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCustomMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetCustomMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomMetricExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->customMetricName('[PROPERTY]', '[CUSTOM_METRIC]');
        $request = (new GetCustomMetricRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCustomMetric($request);
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
    public function getDataRetentionSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $resetUserDataOnNewActivity = false;
        $expectedResponse = new DataRetentionSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setResetUserDataOnNewActivity($resetUserDataOnNewActivity);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataRetentionSettingsName('[PROPERTY]');
        $request = (new GetDataRetentionSettingsRequest())
            ->setName($formattedName);
        $response = $gapicClient->getDataRetentionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetDataRetentionSettings', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataRetentionSettingsExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->dataRetentionSettingsName('[PROPERTY]');
        $request = (new GetDataRetentionSettingsRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getDataRetentionSettings($request);
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
    public function getDataSharingSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $sharingWithGoogleSupportEnabled = false;
        $sharingWithGoogleAssignedSalesEnabled = false;
        $sharingWithGoogleAnySalesEnabled = false;
        $sharingWithGoogleProductsEnabled = true;
        $sharingWithOthersEnabled = false;
        $expectedResponse = new DataSharingSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setSharingWithGoogleSupportEnabled($sharingWithGoogleSupportEnabled);
        $expectedResponse->setSharingWithGoogleAssignedSalesEnabled($sharingWithGoogleAssignedSalesEnabled);
        $expectedResponse->setSharingWithGoogleAnySalesEnabled($sharingWithGoogleAnySalesEnabled);
        $expectedResponse->setSharingWithGoogleProductsEnabled($sharingWithGoogleProductsEnabled);
        $expectedResponse->setSharingWithOthersEnabled($sharingWithOthersEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataSharingSettingsName('[ACCOUNT]');
        $request = (new GetDataSharingSettingsRequest())
            ->setName($formattedName);
        $response = $gapicClient->getDataSharingSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetDataSharingSettings', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataSharingSettingsExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->dataSharingSettingsName('[ACCOUNT]');
        $request = (new GetDataSharingSettingsRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getDataSharingSettings($request);
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
    public function getDataStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataStream();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $request = (new GetDataStreamRequest())
            ->setName($formattedName);
        $response = $gapicClient->getDataStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetDataStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataStreamExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $request = (new GetDataStreamRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getDataStream($request);
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
    public function getMeasurementProtocolSecretTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $secretValue = 'secretValue1322942242';
        $expectedResponse = new MeasurementProtocolSecret();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setSecretValue($secretValue);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->measurementProtocolSecretName('[PROPERTY]', '[DATA_STREAM]', '[MEASUREMENT_PROTOCOL_SECRET]');
        $request = (new GetMeasurementProtocolSecretRequest())
            ->setName($formattedName);
        $response = $gapicClient->getMeasurementProtocolSecret($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetMeasurementProtocolSecret', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMeasurementProtocolSecretExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->measurementProtocolSecretName('[PROPERTY]', '[DATA_STREAM]', '[MEASUREMENT_PROTOCOL_SECRET]');
        $request = (new GetMeasurementProtocolSecretRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getMeasurementProtocolSecret($request);
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
    public function getPropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parent = 'parent-995424086';
        $displayName = 'displayName1615086568';
        $timeZone = 'timeZone36848094';
        $currencyCode = 'currencyCode1108728155';
        $account = 'account-1177318867';
        $expectedResponse = new Property();
        $expectedResponse->setName($name2);
        $expectedResponse->setParent($parent);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setCurrencyCode($currencyCode);
        $expectedResponse->setAccount($account);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->propertyName('[PROPERTY]');
        $request = (new GetPropertyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/GetProperty', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPropertyExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->propertyName('[PROPERTY]');
        $request = (new GetPropertyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getProperty($request);
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
    public function listAccountSummariesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountSummariesElement = new AccountSummary();
        $accountSummaries = [
            $accountSummariesElement,
        ];
        $expectedResponse = new ListAccountSummariesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccountSummaries($accountSummaries);
        $transport->addResponse($expectedResponse);
        $request = new ListAccountSummariesRequest();
        $response = $gapicClient->listAccountSummaries($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccountSummaries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListAccountSummaries', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccountSummariesExceptionTest()
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
        $request = new ListAccountSummariesRequest();
        try {
            $gapicClient->listAccountSummaries($request);
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
    public function listAccountsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountsElement = new Account();
        $accounts = [
            $accountsElement,
        ];
        $expectedResponse = new ListAccountsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccounts($accounts);
        $transport->addResponse($expectedResponse);
        $request = new ListAccountsRequest();
        $response = $gapicClient->listAccounts($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccounts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListAccounts', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccountsExceptionTest()
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
        $request = new ListAccountsRequest();
        try {
            $gapicClient->listAccounts($request);
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
    public function listConversionEventsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $conversionEventsElement = new ConversionEvent();
        $conversionEvents = [
            $conversionEventsElement,
        ];
        $expectedResponse = new ListConversionEventsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setConversionEvents($conversionEvents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListConversionEventsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listConversionEvents($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getConversionEvents()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListConversionEvents', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listConversionEventsExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListConversionEventsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listConversionEvents($request);
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
    public function listCustomDimensionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customDimensionsElement = new CustomDimension();
        $customDimensions = [
            $customDimensionsElement,
        ];
        $expectedResponse = new ListCustomDimensionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomDimensions($customDimensions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListCustomDimensionsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCustomDimensions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomDimensions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListCustomDimensions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomDimensionsExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListCustomDimensionsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCustomDimensions($request);
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
    public function listCustomMetricsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customMetricsElement = new CustomMetric();
        $customMetrics = [
            $customMetricsElement,
        ];
        $expectedResponse = new ListCustomMetricsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomMetrics($customMetrics);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListCustomMetricsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCustomMetrics($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomMetrics()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListCustomMetrics', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomMetricsExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListCustomMetricsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCustomMetrics($request);
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
    public function listDataStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataStreamsElement = new DataStream();
        $dataStreams = [
            $dataStreamsElement,
        ];
        $expectedResponse = new ListDataStreamsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataStreams($dataStreams);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListDataStreamsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listDataStreams($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataStreams()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListDataStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataStreamsExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListDataStreamsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listDataStreams($request);
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
    public function listFirebaseLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $firebaseLinksElement = new FirebaseLink();
        $firebaseLinks = [
            $firebaseLinksElement,
        ];
        $expectedResponse = new ListFirebaseLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFirebaseLinks($firebaseLinks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListFirebaseLinksRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listFirebaseLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFirebaseLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListFirebaseLinks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFirebaseLinksExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListFirebaseLinksRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listFirebaseLinks($request);
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
    public function listGoogleAdsLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $googleAdsLinksElement = new GoogleAdsLink();
        $googleAdsLinks = [
            $googleAdsLinksElement,
        ];
        $expectedResponse = new ListGoogleAdsLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setGoogleAdsLinks($googleAdsLinks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListGoogleAdsLinksRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listGoogleAdsLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGoogleAdsLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListGoogleAdsLinks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listGoogleAdsLinksExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListGoogleAdsLinksRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listGoogleAdsLinks($request);
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
    public function listMeasurementProtocolSecretsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $measurementProtocolSecretsElement = new MeasurementProtocolSecret();
        $measurementProtocolSecrets = [
            $measurementProtocolSecretsElement,
        ];
        $expectedResponse = new ListMeasurementProtocolSecretsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMeasurementProtocolSecrets($measurementProtocolSecrets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $request = (new ListMeasurementProtocolSecretsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listMeasurementProtocolSecrets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMeasurementProtocolSecrets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListMeasurementProtocolSecrets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMeasurementProtocolSecretsExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->dataStreamName('[PROPERTY]', '[DATA_STREAM]');
        $request = (new ListMeasurementProtocolSecretsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listMeasurementProtocolSecrets($request);
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
    public function listPropertiesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $propertiesElement = new Property();
        $properties = [
            $propertiesElement,
        ];
        $expectedResponse = new ListPropertiesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setProperties($properties);
        $transport->addResponse($expectedResponse);
        // Mock request
        $filter = 'filter-1274492040';
        $request = (new ListPropertiesRequest())
            ->setFilter($filter);
        $response = $gapicClient->listProperties($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getProperties()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ListProperties', $actualFuncCall);
        $actualValue = $actualRequestObject->getFilter();
        $this->assertProtobufEquals($filter, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPropertiesExceptionTest()
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
        // Mock request
        $filter = 'filter-1274492040';
        $request = (new ListPropertiesRequest())
            ->setFilter($filter);
        try {
            $gapicClient->listProperties($request);
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
    public function provisionAccountTicketTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $accountTicketId = 'accountTicketId-442102884';
        $expectedResponse = new ProvisionAccountTicketResponse();
        $expectedResponse->setAccountTicketId($accountTicketId);
        $transport->addResponse($expectedResponse);
        $request = new ProvisionAccountTicketRequest();
        $response = $gapicClient->provisionAccountTicket($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/ProvisionAccountTicket', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function provisionAccountTicketExceptionTest()
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
        $request = new ProvisionAccountTicketRequest();
        try {
            $gapicClient->provisionAccountTicket($request);
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
    public function runAccessReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $rowCount = 1340416618;
        $expectedResponse = new RunAccessReportResponse();
        $expectedResponse->setRowCount($rowCount);
        $transport->addResponse($expectedResponse);
        $request = new RunAccessReportRequest();
        $response = $gapicClient->runAccessReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/RunAccessReport', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function runAccessReportExceptionTest()
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
        $request = new RunAccessReportRequest();
        try {
            $gapicClient->runAccessReport($request);
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
    public function searchChangeHistoryEventsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $changeHistoryEventsElement = new ChangeHistoryEvent();
        $changeHistoryEvents = [
            $changeHistoryEventsElement,
        ];
        $expectedResponse = new SearchChangeHistoryEventsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setChangeHistoryEvents($changeHistoryEvents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAccount = $gapicClient->accountName('[ACCOUNT]');
        $request = (new SearchChangeHistoryEventsRequest())
            ->setAccount($formattedAccount);
        $response = $gapicClient->searchChangeHistoryEvents($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getChangeHistoryEvents()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/SearchChangeHistoryEvents', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($formattedAccount, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchChangeHistoryEventsExceptionTest()
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
        // Mock request
        $formattedAccount = $gapicClient->accountName('[ACCOUNT]');
        $request = (new SearchChangeHistoryEventsRequest())
            ->setAccount($formattedAccount);
        try {
            $gapicClient->searchChangeHistoryEvents($request);
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
    public function updateAccountTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $regionCode = 'regionCode-1566082984';
        $deleted = false;
        $expectedResponse = new Account();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setDeleted($deleted);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = new Account();
        $accountDisplayName = 'accountDisplayName-616446464';
        $account->setDisplayName($accountDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateAccountRequest())
            ->setAccount($account)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAccountExceptionTest()
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
        // Mock request
        $account = new Account();
        $accountDisplayName = 'accountDisplayName-616446464';
        $account->setDisplayName($accountDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateAccountRequest())
            ->setAccount($account)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateAccount($request);
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
    public function updateConversionEventTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $eventName = 'eventName984174864';
        $deletable = true;
        $custom = false;
        $expectedResponse = new ConversionEvent();
        $expectedResponse->setName($name);
        $expectedResponse->setEventName($eventName);
        $expectedResponse->setDeletable($deletable);
        $expectedResponse->setCustom($custom);
        $transport->addResponse($expectedResponse);
        // Mock request
        $conversionEvent = new ConversionEvent();
        $updateMask = new FieldMask();
        $request = (new UpdateConversionEventRequest())
            ->setConversionEvent($conversionEvent)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateConversionEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateConversionEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getConversionEvent();
        $this->assertProtobufEquals($conversionEvent, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateConversionEventExceptionTest()
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
        // Mock request
        $conversionEvent = new ConversionEvent();
        $updateMask = new FieldMask();
        $request = (new UpdateConversionEventRequest())
            ->setConversionEvent($conversionEvent)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateConversionEvent($request);
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
    public function updateCustomDimensionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parameterName = 'parameterName1133142369';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $disallowAdsPersonalization = false;
        $expectedResponse = new CustomDimension();
        $expectedResponse->setName($name);
        $expectedResponse->setParameterName($parameterName);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisallowAdsPersonalization($disallowAdsPersonalization);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateCustomDimensionRequest())
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateCustomDimension($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateCustomDimension', $actualFuncCall);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCustomDimensionExceptionTest()
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
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateCustomDimensionRequest())
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateCustomDimension($request);
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
    public function updateCustomMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parameterName = 'parameterName1133142369';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new CustomMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setParameterName($parameterName);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateCustomMetricRequest())
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateCustomMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateCustomMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCustomMetricExceptionTest()
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
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateCustomMetricRequest())
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateCustomMetric($request);
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
    public function updateDataRetentionSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $resetUserDataOnNewActivity = false;
        $expectedResponse = new DataRetentionSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setResetUserDataOnNewActivity($resetUserDataOnNewActivity);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataRetentionSettings = new DataRetentionSettings();
        $updateMask = new FieldMask();
        $request = (new UpdateDataRetentionSettingsRequest())
            ->setDataRetentionSettings($dataRetentionSettings)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateDataRetentionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateDataRetentionSettings', $actualFuncCall);
        $actualValue = $actualRequestObject->getDataRetentionSettings();
        $this->assertProtobufEquals($dataRetentionSettings, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataRetentionSettingsExceptionTest()
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
        // Mock request
        $dataRetentionSettings = new DataRetentionSettings();
        $updateMask = new FieldMask();
        $request = (new UpdateDataRetentionSettingsRequest())
            ->setDataRetentionSettings($dataRetentionSettings)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateDataRetentionSettings($request);
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
    public function updateDataStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataStream();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateDataStreamRequest())
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateDataStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateDataStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataStreamExceptionTest()
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
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateDataStreamRequest())
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateDataStream($request);
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
    public function updateGoogleAdsLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $customerId = 'customerId-1772061412';
        $canManageClients = false;
        $creatorEmailAddress = 'creatorEmailAddress-1491810434';
        $expectedResponse = new GoogleAdsLink();
        $expectedResponse->setName($name);
        $expectedResponse->setCustomerId($customerId);
        $expectedResponse->setCanManageClients($canManageClients);
        $expectedResponse->setCreatorEmailAddress($creatorEmailAddress);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateGoogleAdsLinkRequest())
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateGoogleAdsLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateGoogleAdsLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateGoogleAdsLinkExceptionTest()
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
        // Mock request
        $updateMask = new FieldMask();
        $request = (new UpdateGoogleAdsLinkRequest())
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateGoogleAdsLink($request);
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
    public function updateMeasurementProtocolSecretTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $secretValue = 'secretValue1322942242';
        $expectedResponse = new MeasurementProtocolSecret();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setSecretValue($secretValue);
        $transport->addResponse($expectedResponse);
        // Mock request
        $measurementProtocolSecret = new MeasurementProtocolSecret();
        $measurementProtocolSecretDisplayName = 'measurementProtocolSecretDisplayName1279116681';
        $measurementProtocolSecret->setDisplayName($measurementProtocolSecretDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateMeasurementProtocolSecretRequest())
            ->setMeasurementProtocolSecret($measurementProtocolSecret)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateMeasurementProtocolSecret($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateMeasurementProtocolSecret', $actualFuncCall);
        $actualValue = $actualRequestObject->getMeasurementProtocolSecret();
        $this->assertProtobufEquals($measurementProtocolSecret, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateMeasurementProtocolSecretExceptionTest()
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
        // Mock request
        $measurementProtocolSecret = new MeasurementProtocolSecret();
        $measurementProtocolSecretDisplayName = 'measurementProtocolSecretDisplayName1279116681';
        $measurementProtocolSecret->setDisplayName($measurementProtocolSecretDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateMeasurementProtocolSecretRequest())
            ->setMeasurementProtocolSecret($measurementProtocolSecret)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateMeasurementProtocolSecret($request);
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
    public function updatePropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parent = 'parent-995424086';
        $displayName = 'displayName1615086568';
        $timeZone = 'timeZone36848094';
        $currencyCode = 'currencyCode1108728155';
        $account = 'account-1177318867';
        $expectedResponse = new Property();
        $expectedResponse->setName($name);
        $expectedResponse->setParent($parent);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setCurrencyCode($currencyCode);
        $expectedResponse->setAccount($account);
        $transport->addResponse($expectedResponse);
        // Mock request
        $property = new Property();
        $propertyDisplayName = 'propertyDisplayName-1254483624';
        $property->setDisplayName($propertyDisplayName);
        $propertyTimeZone = 'propertyTimeZone-1600366322';
        $property->setTimeZone($propertyTimeZone);
        $updateMask = new FieldMask();
        $request = (new UpdatePropertyRequest())
            ->setProperty($property)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateProperty', $actualFuncCall);
        $actualValue = $actualRequestObject->getProperty();
        $this->assertProtobufEquals($property, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updatePropertyExceptionTest()
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
        // Mock request
        $property = new Property();
        $propertyDisplayName = 'propertyDisplayName-1254483624';
        $property->setDisplayName($propertyDisplayName);
        $propertyTimeZone = 'propertyTimeZone-1600366322';
        $property->setTimeZone($propertyTimeZone);
        $updateMask = new FieldMask();
        $request = (new UpdatePropertyRequest())
            ->setProperty($property)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateProperty($request);
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
    public function acknowledgeUserDataCollectionAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AcknowledgeUserDataCollectionResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedProperty = $gapicClient->propertyName('[PROPERTY]');
        $acknowledgement = 'acknowledgement1769490938';
        $request = (new AcknowledgeUserDataCollectionRequest())
            ->setProperty($formattedProperty)
            ->setAcknowledgement($acknowledgement);
        $response = $gapicClient->acknowledgeUserDataCollectionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1beta.AnalyticsAdminService/AcknowledgeUserDataCollection', $actualFuncCall);
        $actualValue = $actualRequestObject->getProperty();
        $this->assertProtobufEquals($formattedProperty, $actualValue);
        $actualValue = $actualRequestObject->getAcknowledgement();
        $this->assertProtobufEquals($acknowledgement, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
