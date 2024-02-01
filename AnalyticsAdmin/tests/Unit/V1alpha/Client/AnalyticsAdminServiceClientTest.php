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

namespace Google\Analytics\Admin\Tests\Unit\V1alpha\Client;

use Google\Analytics\Admin\V1alpha\AccessBinding;
use Google\Analytics\Admin\V1alpha\Account;
use Google\Analytics\Admin\V1alpha\AccountSummary;
use Google\Analytics\Admin\V1alpha\AcknowledgeUserDataCollectionRequest;
use Google\Analytics\Admin\V1alpha\AcknowledgeUserDataCollectionResponse;
use Google\Analytics\Admin\V1alpha\AdSenseLink;
use Google\Analytics\Admin\V1alpha\ApproveDisplayVideo360AdvertiserLinkProposalRequest;
use Google\Analytics\Admin\V1alpha\ApproveDisplayVideo360AdvertiserLinkProposalResponse;
use Google\Analytics\Admin\V1alpha\ArchiveAudienceRequest;
use Google\Analytics\Admin\V1alpha\ArchiveCustomDimensionRequest;
use Google\Analytics\Admin\V1alpha\ArchiveCustomMetricRequest;
use Google\Analytics\Admin\V1alpha\AttributionSettings;
use Google\Analytics\Admin\V1alpha\Audience;
use Google\Analytics\Admin\V1alpha\BatchCreateAccessBindingsRequest;
use Google\Analytics\Admin\V1alpha\BatchCreateAccessBindingsResponse;
use Google\Analytics\Admin\V1alpha\BatchDeleteAccessBindingsRequest;
use Google\Analytics\Admin\V1alpha\BatchGetAccessBindingsRequest;
use Google\Analytics\Admin\V1alpha\BatchGetAccessBindingsResponse;
use Google\Analytics\Admin\V1alpha\BatchUpdateAccessBindingsRequest;
use Google\Analytics\Admin\V1alpha\BatchUpdateAccessBindingsResponse;
use Google\Analytics\Admin\V1alpha\BigQueryLink;
use Google\Analytics\Admin\V1alpha\CalculatedMetric;
use Google\Analytics\Admin\V1alpha\CancelDisplayVideo360AdvertiserLinkProposalRequest;
use Google\Analytics\Admin\V1alpha\ChangeHistoryEvent;
use Google\Analytics\Admin\V1alpha\ChannelGroup;
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\ConversionEvent;
use Google\Analytics\Admin\V1alpha\CreateAccessBindingRequest;
use Google\Analytics\Admin\V1alpha\CreateAdSenseLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateAudienceRequest;
use Google\Analytics\Admin\V1alpha\CreateCalculatedMetricRequest;
use Google\Analytics\Admin\V1alpha\CreateChannelGroupRequest;
use Google\Analytics\Admin\V1alpha\CreateConnectedSiteTagRequest;
use Google\Analytics\Admin\V1alpha\CreateConnectedSiteTagResponse;
use Google\Analytics\Admin\V1alpha\CreateConversionEventRequest;
use Google\Analytics\Admin\V1alpha\CreateCustomDimensionRequest;
use Google\Analytics\Admin\V1alpha\CreateCustomMetricRequest;
use Google\Analytics\Admin\V1alpha\CreateDataStreamRequest;
use Google\Analytics\Admin\V1alpha\CreateDisplayVideo360AdvertiserLinkProposalRequest;
use Google\Analytics\Admin\V1alpha\CreateDisplayVideo360AdvertiserLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateEventCreateRuleRequest;
use Google\Analytics\Admin\V1alpha\CreateExpandedDataSetRequest;
use Google\Analytics\Admin\V1alpha\CreateFirebaseLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1alpha\CreatePropertyRequest;
use Google\Analytics\Admin\V1alpha\CreateRollupPropertyRequest;
use Google\Analytics\Admin\V1alpha\CreateRollupPropertyResponse;
use Google\Analytics\Admin\V1alpha\CreateRollupPropertySourceLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateSKAdNetworkConversionValueSchemaRequest;
use Google\Analytics\Admin\V1alpha\CreateSearchAds360LinkRequest;
use Google\Analytics\Admin\V1alpha\CreateSubpropertyEventFilterRequest;
use Google\Analytics\Admin\V1alpha\CreateSubpropertyRequest;
use Google\Analytics\Admin\V1alpha\CreateSubpropertyResponse;
use Google\Analytics\Admin\V1alpha\CustomDimension;
use Google\Analytics\Admin\V1alpha\CustomMetric;
use Google\Analytics\Admin\V1alpha\DataRedactionSettings;
use Google\Analytics\Admin\V1alpha\DataRetentionSettings;
use Google\Analytics\Admin\V1alpha\DataSharingSettings;
use Google\Analytics\Admin\V1alpha\DataStream;
use Google\Analytics\Admin\V1alpha\DeleteAccessBindingRequest;
use Google\Analytics\Admin\V1alpha\DeleteAccountRequest;
use Google\Analytics\Admin\V1alpha\DeleteAdSenseLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteCalculatedMetricRequest;
use Google\Analytics\Admin\V1alpha\DeleteChannelGroupRequest;
use Google\Analytics\Admin\V1alpha\DeleteConnectedSiteTagRequest;
use Google\Analytics\Admin\V1alpha\DeleteConversionEventRequest;
use Google\Analytics\Admin\V1alpha\DeleteDataStreamRequest;
use Google\Analytics\Admin\V1alpha\DeleteDisplayVideo360AdvertiserLinkProposalRequest;
use Google\Analytics\Admin\V1alpha\DeleteDisplayVideo360AdvertiserLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteEventCreateRuleRequest;
use Google\Analytics\Admin\V1alpha\DeleteExpandedDataSetRequest;
use Google\Analytics\Admin\V1alpha\DeleteFirebaseLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1alpha\DeletePropertyRequest;
use Google\Analytics\Admin\V1alpha\DeleteRollupPropertySourceLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteSKAdNetworkConversionValueSchemaRequest;
use Google\Analytics\Admin\V1alpha\DeleteSearchAds360LinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteSubpropertyEventFilterRequest;
use Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLink;
use Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLinkProposal;
use Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings;
use Google\Analytics\Admin\V1alpha\EventCreateRule;
use Google\Analytics\Admin\V1alpha\ExpandedDataSet;
use Google\Analytics\Admin\V1alpha\FetchAutomatedGa4ConfigurationOptOutRequest;
use Google\Analytics\Admin\V1alpha\FetchAutomatedGa4ConfigurationOptOutResponse;
use Google\Analytics\Admin\V1alpha\FetchConnectedGa4PropertyRequest;
use Google\Analytics\Admin\V1alpha\FetchConnectedGa4PropertyResponse;
use Google\Analytics\Admin\V1alpha\FirebaseLink;
use Google\Analytics\Admin\V1alpha\GetAccessBindingRequest;
use Google\Analytics\Admin\V1alpha\GetAccountRequest;
use Google\Analytics\Admin\V1alpha\GetAdSenseLinkRequest;
use Google\Analytics\Admin\V1alpha\GetAttributionSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetAudienceRequest;
use Google\Analytics\Admin\V1alpha\GetBigQueryLinkRequest;
use Google\Analytics\Admin\V1alpha\GetCalculatedMetricRequest;
use Google\Analytics\Admin\V1alpha\GetChannelGroupRequest;
use Google\Analytics\Admin\V1alpha\GetConversionEventRequest;
use Google\Analytics\Admin\V1alpha\GetCustomDimensionRequest;
use Google\Analytics\Admin\V1alpha\GetCustomMetricRequest;
use Google\Analytics\Admin\V1alpha\GetDataRedactionSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetDataRetentionSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetDataSharingSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetDataStreamRequest;
use Google\Analytics\Admin\V1alpha\GetDisplayVideo360AdvertiserLinkProposalRequest;
use Google\Analytics\Admin\V1alpha\GetDisplayVideo360AdvertiserLinkRequest;
use Google\Analytics\Admin\V1alpha\GetEnhancedMeasurementSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetEventCreateRuleRequest;
use Google\Analytics\Admin\V1alpha\GetExpandedDataSetRequest;
use Google\Analytics\Admin\V1alpha\GetGlobalSiteTagRequest;
use Google\Analytics\Admin\V1alpha\GetGoogleSignalsSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1alpha\GetPropertyRequest;
use Google\Analytics\Admin\V1alpha\GetRollupPropertySourceLinkRequest;
use Google\Analytics\Admin\V1alpha\GetSKAdNetworkConversionValueSchemaRequest;
use Google\Analytics\Admin\V1alpha\GetSearchAds360LinkRequest;
use Google\Analytics\Admin\V1alpha\GetSubpropertyEventFilterRequest;
use Google\Analytics\Admin\V1alpha\GlobalSiteTag;
use Google\Analytics\Admin\V1alpha\GoogleAdsLink;
use Google\Analytics\Admin\V1alpha\GoogleSignalsSettings;
use Google\Analytics\Admin\V1alpha\ListAccessBindingsRequest;
use Google\Analytics\Admin\V1alpha\ListAccessBindingsResponse;
use Google\Analytics\Admin\V1alpha\ListAccountSummariesRequest;
use Google\Analytics\Admin\V1alpha\ListAccountSummariesResponse;
use Google\Analytics\Admin\V1alpha\ListAccountsRequest;
use Google\Analytics\Admin\V1alpha\ListAccountsResponse;
use Google\Analytics\Admin\V1alpha\ListAdSenseLinksRequest;
use Google\Analytics\Admin\V1alpha\ListAdSenseLinksResponse;
use Google\Analytics\Admin\V1alpha\ListAudiencesRequest;
use Google\Analytics\Admin\V1alpha\ListAudiencesResponse;
use Google\Analytics\Admin\V1alpha\ListBigQueryLinksRequest;
use Google\Analytics\Admin\V1alpha\ListBigQueryLinksResponse;
use Google\Analytics\Admin\V1alpha\ListCalculatedMetricsRequest;
use Google\Analytics\Admin\V1alpha\ListCalculatedMetricsResponse;
use Google\Analytics\Admin\V1alpha\ListChannelGroupsRequest;
use Google\Analytics\Admin\V1alpha\ListChannelGroupsResponse;
use Google\Analytics\Admin\V1alpha\ListConnectedSiteTagsRequest;
use Google\Analytics\Admin\V1alpha\ListConnectedSiteTagsResponse;
use Google\Analytics\Admin\V1alpha\ListConversionEventsRequest;
use Google\Analytics\Admin\V1alpha\ListConversionEventsResponse;
use Google\Analytics\Admin\V1alpha\ListCustomDimensionsRequest;
use Google\Analytics\Admin\V1alpha\ListCustomDimensionsResponse;
use Google\Analytics\Admin\V1alpha\ListCustomMetricsRequest;
use Google\Analytics\Admin\V1alpha\ListCustomMetricsResponse;
use Google\Analytics\Admin\V1alpha\ListDataStreamsRequest;
use Google\Analytics\Admin\V1alpha\ListDataStreamsResponse;
use Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinkProposalsRequest;
use Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinkProposalsResponse;
use Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinksRequest;
use Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinksResponse;
use Google\Analytics\Admin\V1alpha\ListEventCreateRulesRequest;
use Google\Analytics\Admin\V1alpha\ListEventCreateRulesResponse;
use Google\Analytics\Admin\V1alpha\ListExpandedDataSetsRequest;
use Google\Analytics\Admin\V1alpha\ListExpandedDataSetsResponse;
use Google\Analytics\Admin\V1alpha\ListFirebaseLinksRequest;
use Google\Analytics\Admin\V1alpha\ListFirebaseLinksResponse;
use Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksRequest;
use Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksResponse;
use Google\Analytics\Admin\V1alpha\ListMeasurementProtocolSecretsRequest;
use Google\Analytics\Admin\V1alpha\ListMeasurementProtocolSecretsResponse;
use Google\Analytics\Admin\V1alpha\ListPropertiesRequest;
use Google\Analytics\Admin\V1alpha\ListPropertiesResponse;
use Google\Analytics\Admin\V1alpha\ListRollupPropertySourceLinksRequest;
use Google\Analytics\Admin\V1alpha\ListRollupPropertySourceLinksResponse;
use Google\Analytics\Admin\V1alpha\ListSKAdNetworkConversionValueSchemasRequest;
use Google\Analytics\Admin\V1alpha\ListSKAdNetworkConversionValueSchemasResponse;
use Google\Analytics\Admin\V1alpha\ListSearchAds360LinksRequest;
use Google\Analytics\Admin\V1alpha\ListSearchAds360LinksResponse;
use Google\Analytics\Admin\V1alpha\ListSubpropertyEventFiltersRequest;
use Google\Analytics\Admin\V1alpha\ListSubpropertyEventFiltersResponse;
use Google\Analytics\Admin\V1alpha\MeasurementProtocolSecret;
use Google\Analytics\Admin\V1alpha\Property;
use Google\Analytics\Admin\V1alpha\ProvisionAccountTicketRequest;
use Google\Analytics\Admin\V1alpha\ProvisionAccountTicketResponse;
use Google\Analytics\Admin\V1alpha\RollupPropertySourceLink;
use Google\Analytics\Admin\V1alpha\RunAccessReportRequest;
use Google\Analytics\Admin\V1alpha\RunAccessReportResponse;
use Google\Analytics\Admin\V1alpha\SKAdNetworkConversionValueSchema;
use Google\Analytics\Admin\V1alpha\SearchAds360Link;
use Google\Analytics\Admin\V1alpha\SearchChangeHistoryEventsRequest;
use Google\Analytics\Admin\V1alpha\SearchChangeHistoryEventsResponse;
use Google\Analytics\Admin\V1alpha\SetAutomatedGa4ConfigurationOptOutRequest;
use Google\Analytics\Admin\V1alpha\SetAutomatedGa4ConfigurationOptOutResponse;
use Google\Analytics\Admin\V1alpha\SubpropertyEventFilter;
use Google\Analytics\Admin\V1alpha\UpdateAccessBindingRequest;
use Google\Analytics\Admin\V1alpha\UpdateAccountRequest;
use Google\Analytics\Admin\V1alpha\UpdateAttributionSettingsRequest;
use Google\Analytics\Admin\V1alpha\UpdateAudienceRequest;
use Google\Analytics\Admin\V1alpha\UpdateCalculatedMetricRequest;
use Google\Analytics\Admin\V1alpha\UpdateChannelGroupRequest;
use Google\Analytics\Admin\V1alpha\UpdateConversionEventRequest;
use Google\Analytics\Admin\V1alpha\UpdateCustomDimensionRequest;
use Google\Analytics\Admin\V1alpha\UpdateCustomMetricRequest;
use Google\Analytics\Admin\V1alpha\UpdateDataRedactionSettingsRequest;
use Google\Analytics\Admin\V1alpha\UpdateDataRetentionSettingsRequest;
use Google\Analytics\Admin\V1alpha\UpdateDataStreamRequest;
use Google\Analytics\Admin\V1alpha\UpdateDisplayVideo360AdvertiserLinkRequest;
use Google\Analytics\Admin\V1alpha\UpdateEnhancedMeasurementSettingsRequest;
use Google\Analytics\Admin\V1alpha\UpdateEventCreateRuleRequest;
use Google\Analytics\Admin\V1alpha\UpdateExpandedDataSetRequest;
use Google\Analytics\Admin\V1alpha\UpdateGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1alpha\UpdateGoogleSignalsSettingsRequest;
use Google\Analytics\Admin\V1alpha\UpdateMeasurementProtocolSecretRequest;
use Google\Analytics\Admin\V1alpha\UpdatePropertyRequest;
use Google\Analytics\Admin\V1alpha\UpdateSKAdNetworkConversionValueSchemaRequest;
use Google\Analytics\Admin\V1alpha\UpdateSearchAds360LinkRequest;
use Google\Analytics\Admin\V1alpha\UpdateSubpropertyEventFilterRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
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
        $request = new AcknowledgeUserDataCollectionRequest();
        $response = $gapicClient->acknowledgeUserDataCollection($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/AcknowledgeUserDataCollection', $actualFuncCall);
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
        $request = new AcknowledgeUserDataCollectionRequest();
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
    public function approveDisplayVideo360AdvertiserLinkProposalTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ApproveDisplayVideo360AdvertiserLinkProposalResponse();
        $transport->addResponse($expectedResponse);
        $request = new ApproveDisplayVideo360AdvertiserLinkProposalRequest();
        $response = $gapicClient->approveDisplayVideo360AdvertiserLinkProposal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ApproveDisplayVideo360AdvertiserLinkProposal', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function approveDisplayVideo360AdvertiserLinkProposalExceptionTest()
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
        $request = new ApproveDisplayVideo360AdvertiserLinkProposalRequest();
        try {
            $gapicClient->approveDisplayVideo360AdvertiserLinkProposal($request);
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
    public function archiveAudienceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new ArchiveAudienceRequest();
        $gapicClient->archiveAudience($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ArchiveAudience', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function archiveAudienceExceptionTest()
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
        $request = new ArchiveAudienceRequest();
        try {
            $gapicClient->archiveAudience($request);
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
        $request = new ArchiveCustomDimensionRequest();
        $gapicClient->archiveCustomDimension($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ArchiveCustomDimension', $actualFuncCall);
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
        $request = new ArchiveCustomDimensionRequest();
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
        $request = new ArchiveCustomMetricRequest();
        $gapicClient->archiveCustomMetric($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ArchiveCustomMetric', $actualFuncCall);
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
        $request = new ArchiveCustomMetricRequest();
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
    public function batchCreateAccessBindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateAccessBindingsResponse();
        $transport->addResponse($expectedResponse);
        $request = new BatchCreateAccessBindingsRequest();
        $response = $gapicClient->batchCreateAccessBindings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchCreateAccessBindings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateAccessBindingsExceptionTest()
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
        $request = new BatchCreateAccessBindingsRequest();
        try {
            $gapicClient->batchCreateAccessBindings($request);
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
    public function batchDeleteAccessBindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new BatchDeleteAccessBindingsRequest();
        $gapicClient->batchDeleteAccessBindings($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchDeleteAccessBindings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeleteAccessBindingsExceptionTest()
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
        $request = new BatchDeleteAccessBindingsRequest();
        try {
            $gapicClient->batchDeleteAccessBindings($request);
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
    public function batchGetAccessBindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchGetAccessBindingsResponse();
        $transport->addResponse($expectedResponse);
        $request = new BatchGetAccessBindingsRequest();
        $response = $gapicClient->batchGetAccessBindings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchGetAccessBindings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchGetAccessBindingsExceptionTest()
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
        $request = new BatchGetAccessBindingsRequest();
        try {
            $gapicClient->batchGetAccessBindings($request);
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
    public function batchUpdateAccessBindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateAccessBindingsResponse();
        $transport->addResponse($expectedResponse);
        $request = new BatchUpdateAccessBindingsRequest();
        $response = $gapicClient->batchUpdateAccessBindings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchUpdateAccessBindings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateAccessBindingsExceptionTest()
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
        $request = new BatchUpdateAccessBindingsRequest();
        try {
            $gapicClient->batchUpdateAccessBindings($request);
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
    public function cancelDisplayVideo360AdvertiserLinkProposalTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $validationEmail = 'validationEmail2105669718';
        $expectedResponse = new DisplayVideo360AdvertiserLinkProposal();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $expectedResponse->setValidationEmail($validationEmail);
        $transport->addResponse($expectedResponse);
        $request = new CancelDisplayVideo360AdvertiserLinkProposalRequest();
        $response = $gapicClient->cancelDisplayVideo360AdvertiserLinkProposal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CancelDisplayVideo360AdvertiserLinkProposal', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelDisplayVideo360AdvertiserLinkProposalExceptionTest()
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
        $request = new CancelDisplayVideo360AdvertiserLinkProposalRequest();
        try {
            $gapicClient->cancelDisplayVideo360AdvertiserLinkProposal($request);
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
    public function createAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $user = 'user3599307';
        $name = 'name3373707';
        $expectedResponse = new AccessBinding();
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        $request = new CreateAccessBindingRequest();
        $response = $gapicClient->createAccessBinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateAccessBinding', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAccessBindingExceptionTest()
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
        $request = new CreateAccessBindingRequest();
        try {
            $gapicClient->createAccessBinding($request);
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
    public function createAdSenseLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $adClientCode = 'adClientCode-1866307643';
        $expectedResponse = new AdSenseLink();
        $expectedResponse->setName($name);
        $expectedResponse->setAdClientCode($adClientCode);
        $transport->addResponse($expectedResponse);
        $request = new CreateAdSenseLinkRequest();
        $response = $gapicClient->createAdSenseLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateAdSenseLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAdSenseLinkExceptionTest()
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
        $request = new CreateAdSenseLinkRequest();
        try {
            $gapicClient->createAdSenseLink($request);
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
    public function createAudienceTest()
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
        $membershipDurationDays = 1702404985;
        $adsPersonalizationEnabled = false;
        $expectedResponse = new Audience();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setMembershipDurationDays($membershipDurationDays);
        $expectedResponse->setAdsPersonalizationEnabled($adsPersonalizationEnabled);
        $transport->addResponse($expectedResponse);
        $request = new CreateAudienceRequest();
        $response = $gapicClient->createAudience($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateAudience', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAudienceExceptionTest()
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
        $request = new CreateAudienceRequest();
        try {
            $gapicClient->createAudience($request);
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
    public function createCalculatedMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $calculatedMetricId2 = 'calculatedMetricId2-706401732';
        $formula = 'formula-677424794';
        $invalidMetricReference = true;
        $expectedResponse = new CalculatedMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setCalculatedMetricId($calculatedMetricId2);
        $expectedResponse->setFormula($formula);
        $expectedResponse->setInvalidMetricReference($invalidMetricReference);
        $transport->addResponse($expectedResponse);
        $request = new CreateCalculatedMetricRequest();
        $response = $gapicClient->createCalculatedMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateCalculatedMetric', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCalculatedMetricExceptionTest()
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
        $request = new CreateCalculatedMetricRequest();
        try {
            $gapicClient->createCalculatedMetric($request);
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
    public function createChannelGroupTest()
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
        $systemDefined = false;
        $expectedResponse = new ChannelGroup();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setSystemDefined($systemDefined);
        $transport->addResponse($expectedResponse);
        $request = new CreateChannelGroupRequest();
        $response = $gapicClient->createChannelGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateChannelGroup', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createChannelGroupExceptionTest()
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
        $request = new CreateChannelGroupRequest();
        try {
            $gapicClient->createChannelGroup($request);
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
    public function createConnectedSiteTagTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CreateConnectedSiteTagResponse();
        $transport->addResponse($expectedResponse);
        $request = new CreateConnectedSiteTagRequest();
        $response = $gapicClient->createConnectedSiteTag($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateConnectedSiteTag', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createConnectedSiteTagExceptionTest()
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
        $request = new CreateConnectedSiteTagRequest();
        try {
            $gapicClient->createConnectedSiteTag($request);
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
        $request = new CreateConversionEventRequest();
        $response = $gapicClient->createConversionEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateConversionEvent', $actualFuncCall);
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
        $request = new CreateConversionEventRequest();
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
        $request = new CreateCustomDimensionRequest();
        $response = $gapicClient->createCustomDimension($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateCustomDimension', $actualFuncCall);
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
        $request = new CreateCustomDimensionRequest();
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
        $request = new CreateCustomMetricRequest();
        $response = $gapicClient->createCustomMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateCustomMetric', $actualFuncCall);
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
        $request = new CreateCustomMetricRequest();
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
        $request = new CreateDataStreamRequest();
        $response = $gapicClient->createDataStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateDataStream', $actualFuncCall);
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
        $request = new CreateDataStreamRequest();
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
    public function createDisplayVideo360AdvertiserLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $expectedResponse = new DisplayVideo360AdvertiserLink();
        $expectedResponse->setName($name);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $transport->addResponse($expectedResponse);
        $request = new CreateDisplayVideo360AdvertiserLinkRequest();
        $response = $gapicClient->createDisplayVideo360AdvertiserLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateDisplayVideo360AdvertiserLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDisplayVideo360AdvertiserLinkExceptionTest()
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
        $request = new CreateDisplayVideo360AdvertiserLinkRequest();
        try {
            $gapicClient->createDisplayVideo360AdvertiserLink($request);
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
    public function createDisplayVideo360AdvertiserLinkProposalTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $validationEmail = 'validationEmail2105669718';
        $expectedResponse = new DisplayVideo360AdvertiserLinkProposal();
        $expectedResponse->setName($name);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $expectedResponse->setValidationEmail($validationEmail);
        $transport->addResponse($expectedResponse);
        $request = new CreateDisplayVideo360AdvertiserLinkProposalRequest();
        $response = $gapicClient->createDisplayVideo360AdvertiserLinkProposal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateDisplayVideo360AdvertiserLinkProposal', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDisplayVideo360AdvertiserLinkProposalExceptionTest()
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
        $request = new CreateDisplayVideo360AdvertiserLinkProposalRequest();
        try {
            $gapicClient->createDisplayVideo360AdvertiserLinkProposal($request);
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
    public function createEventCreateRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $destinationEvent = 'destinationEvent-1300408535';
        $sourceCopyParameters = true;
        $expectedResponse = new EventCreateRule();
        $expectedResponse->setName($name);
        $expectedResponse->setDestinationEvent($destinationEvent);
        $expectedResponse->setSourceCopyParameters($sourceCopyParameters);
        $transport->addResponse($expectedResponse);
        $request = new CreateEventCreateRuleRequest();
        $response = $gapicClient->createEventCreateRule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateEventCreateRule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createEventCreateRuleExceptionTest()
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
        $request = new CreateEventCreateRuleRequest();
        try {
            $gapicClient->createEventCreateRule($request);
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
    public function createExpandedDataSetTest()
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
        $expectedResponse = new ExpandedDataSet();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        $request = new CreateExpandedDataSetRequest();
        $response = $gapicClient->createExpandedDataSet($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateExpandedDataSet', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createExpandedDataSetExceptionTest()
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
        $request = new CreateExpandedDataSetRequest();
        try {
            $gapicClient->createExpandedDataSet($request);
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
        $request = new CreateFirebaseLinkRequest();
        $response = $gapicClient->createFirebaseLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateFirebaseLink', $actualFuncCall);
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
        $request = new CreateFirebaseLinkRequest();
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
        $request = new CreateGoogleAdsLinkRequest();
        $response = $gapicClient->createGoogleAdsLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateGoogleAdsLink', $actualFuncCall);
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
        $request = new CreateGoogleAdsLinkRequest();
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
        $request = new CreateMeasurementProtocolSecretRequest();
        $response = $gapicClient->createMeasurementProtocolSecret($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateMeasurementProtocolSecret', $actualFuncCall);
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
        $request = new CreateMeasurementProtocolSecretRequest();
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
        $request = new CreatePropertyRequest();
        $response = $gapicClient->createProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateProperty', $actualFuncCall);
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
        $request = new CreatePropertyRequest();
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
    public function createRollupPropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CreateRollupPropertyResponse();
        $transport->addResponse($expectedResponse);
        $request = new CreateRollupPropertyRequest();
        $response = $gapicClient->createRollupProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateRollupProperty', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createRollupPropertyExceptionTest()
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
        $request = new CreateRollupPropertyRequest();
        try {
            $gapicClient->createRollupProperty($request);
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
    public function createRollupPropertySourceLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $sourceProperty = 'sourceProperty2069271929';
        $expectedResponse = new RollupPropertySourceLink();
        $expectedResponse->setName($name);
        $expectedResponse->setSourceProperty($sourceProperty);
        $transport->addResponse($expectedResponse);
        $request = new CreateRollupPropertySourceLinkRequest();
        $response = $gapicClient->createRollupPropertySourceLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateRollupPropertySourceLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createRollupPropertySourceLinkExceptionTest()
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
        $request = new CreateRollupPropertySourceLinkRequest();
        try {
            $gapicClient->createRollupPropertySourceLink($request);
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
    public function createSKAdNetworkConversionValueSchemaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $applyConversionValues = true;
        $expectedResponse = new SKAdNetworkConversionValueSchema();
        $expectedResponse->setName($name);
        $expectedResponse->setApplyConversionValues($applyConversionValues);
        $transport->addResponse($expectedResponse);
        $request = new CreateSKAdNetworkConversionValueSchemaRequest();
        $response = $gapicClient->createSKAdNetworkConversionValueSchema($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateSKAdNetworkConversionValueSchema', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSKAdNetworkConversionValueSchemaExceptionTest()
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
        $request = new CreateSKAdNetworkConversionValueSchemaRequest();
        try {
            $gapicClient->createSKAdNetworkConversionValueSchema($request);
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
    public function createSearchAds360LinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $expectedResponse = new SearchAds360Link();
        $expectedResponse->setName($name);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $transport->addResponse($expectedResponse);
        $request = new CreateSearchAds360LinkRequest();
        $response = $gapicClient->createSearchAds360Link($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateSearchAds360Link', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSearchAds360LinkExceptionTest()
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
        $request = new CreateSearchAds360LinkRequest();
        try {
            $gapicClient->createSearchAds360Link($request);
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
    public function createSubpropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CreateSubpropertyResponse();
        $transport->addResponse($expectedResponse);
        $request = new CreateSubpropertyRequest();
        $response = $gapicClient->createSubproperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateSubproperty', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSubpropertyExceptionTest()
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
        $request = new CreateSubpropertyRequest();
        try {
            $gapicClient->createSubproperty($request);
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
    public function createSubpropertyEventFilterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $applyToProperty = 'applyToProperty-1639692344';
        $expectedResponse = new SubpropertyEventFilter();
        $expectedResponse->setName($name);
        $expectedResponse->setApplyToProperty($applyToProperty);
        $transport->addResponse($expectedResponse);
        $request = new CreateSubpropertyEventFilterRequest();
        $response = $gapicClient->createSubpropertyEventFilter($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateSubpropertyEventFilter', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSubpropertyEventFilterExceptionTest()
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
        $request = new CreateSubpropertyEventFilterRequest();
        try {
            $gapicClient->createSubpropertyEventFilter($request);
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
    public function deleteAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteAccessBindingRequest();
        $gapicClient->deleteAccessBinding($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteAccessBinding', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAccessBindingExceptionTest()
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
        $request = new DeleteAccessBindingRequest();
        try {
            $gapicClient->deleteAccessBinding($request);
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
        $request = new DeleteAccountRequest();
        $gapicClient->deleteAccount($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteAccount', $actualFuncCall);
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
        $request = new DeleteAccountRequest();
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
    public function deleteAdSenseLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteAdSenseLinkRequest();
        $gapicClient->deleteAdSenseLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteAdSenseLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAdSenseLinkExceptionTest()
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
        $request = new DeleteAdSenseLinkRequest();
        try {
            $gapicClient->deleteAdSenseLink($request);
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
    public function deleteCalculatedMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteCalculatedMetricRequest();
        $gapicClient->deleteCalculatedMetric($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteCalculatedMetric', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCalculatedMetricExceptionTest()
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
        $request = new DeleteCalculatedMetricRequest();
        try {
            $gapicClient->deleteCalculatedMetric($request);
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
    public function deleteChannelGroupTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteChannelGroupRequest();
        $gapicClient->deleteChannelGroup($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteChannelGroup', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteChannelGroupExceptionTest()
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
        $request = new DeleteChannelGroupRequest();
        try {
            $gapicClient->deleteChannelGroup($request);
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
    public function deleteConnectedSiteTagTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteConnectedSiteTagRequest();
        $gapicClient->deleteConnectedSiteTag($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteConnectedSiteTag', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteConnectedSiteTagExceptionTest()
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
        $request = new DeleteConnectedSiteTagRequest();
        try {
            $gapicClient->deleteConnectedSiteTag($request);
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
        $request = new DeleteConversionEventRequest();
        $gapicClient->deleteConversionEvent($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteConversionEvent', $actualFuncCall);
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
        $request = new DeleteConversionEventRequest();
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
        $request = new DeleteDataStreamRequest();
        $gapicClient->deleteDataStream($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteDataStream', $actualFuncCall);
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
        $request = new DeleteDataStreamRequest();
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
    public function deleteDisplayVideo360AdvertiserLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteDisplayVideo360AdvertiserLinkRequest();
        $gapicClient->deleteDisplayVideo360AdvertiserLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteDisplayVideo360AdvertiserLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDisplayVideo360AdvertiserLinkExceptionTest()
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
        $request = new DeleteDisplayVideo360AdvertiserLinkRequest();
        try {
            $gapicClient->deleteDisplayVideo360AdvertiserLink($request);
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
    public function deleteDisplayVideo360AdvertiserLinkProposalTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteDisplayVideo360AdvertiserLinkProposalRequest();
        $gapicClient->deleteDisplayVideo360AdvertiserLinkProposal($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteDisplayVideo360AdvertiserLinkProposal', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDisplayVideo360AdvertiserLinkProposalExceptionTest()
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
        $request = new DeleteDisplayVideo360AdvertiserLinkProposalRequest();
        try {
            $gapicClient->deleteDisplayVideo360AdvertiserLinkProposal($request);
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
    public function deleteEventCreateRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteEventCreateRuleRequest();
        $gapicClient->deleteEventCreateRule($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteEventCreateRule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteEventCreateRuleExceptionTest()
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
        $request = new DeleteEventCreateRuleRequest();
        try {
            $gapicClient->deleteEventCreateRule($request);
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
    public function deleteExpandedDataSetTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteExpandedDataSetRequest();
        $gapicClient->deleteExpandedDataSet($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteExpandedDataSet', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteExpandedDataSetExceptionTest()
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
        $request = new DeleteExpandedDataSetRequest();
        try {
            $gapicClient->deleteExpandedDataSet($request);
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
        $request = new DeleteFirebaseLinkRequest();
        $gapicClient->deleteFirebaseLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteFirebaseLink', $actualFuncCall);
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
        $request = new DeleteFirebaseLinkRequest();
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
        $request = new DeleteGoogleAdsLinkRequest();
        $gapicClient->deleteGoogleAdsLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteGoogleAdsLink', $actualFuncCall);
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
        $request = new DeleteGoogleAdsLinkRequest();
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
        $request = new DeleteMeasurementProtocolSecretRequest();
        $gapicClient->deleteMeasurementProtocolSecret($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteMeasurementProtocolSecret', $actualFuncCall);
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
        $request = new DeleteMeasurementProtocolSecretRequest();
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
        $request = new DeletePropertyRequest();
        $response = $gapicClient->deleteProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteProperty', $actualFuncCall);
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
        $request = new DeletePropertyRequest();
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
    public function deleteRollupPropertySourceLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteRollupPropertySourceLinkRequest();
        $gapicClient->deleteRollupPropertySourceLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteRollupPropertySourceLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteRollupPropertySourceLinkExceptionTest()
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
        $request = new DeleteRollupPropertySourceLinkRequest();
        try {
            $gapicClient->deleteRollupPropertySourceLink($request);
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
    public function deleteSKAdNetworkConversionValueSchemaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteSKAdNetworkConversionValueSchemaRequest();
        $gapicClient->deleteSKAdNetworkConversionValueSchema($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteSKAdNetworkConversionValueSchema', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSKAdNetworkConversionValueSchemaExceptionTest()
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
        $request = new DeleteSKAdNetworkConversionValueSchemaRequest();
        try {
            $gapicClient->deleteSKAdNetworkConversionValueSchema($request);
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
    public function deleteSearchAds360LinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteSearchAds360LinkRequest();
        $gapicClient->deleteSearchAds360Link($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteSearchAds360Link', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSearchAds360LinkExceptionTest()
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
        $request = new DeleteSearchAds360LinkRequest();
        try {
            $gapicClient->deleteSearchAds360Link($request);
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
    public function deleteSubpropertyEventFilterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteSubpropertyEventFilterRequest();
        $gapicClient->deleteSubpropertyEventFilter($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteSubpropertyEventFilter', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSubpropertyEventFilterExceptionTest()
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
        $request = new DeleteSubpropertyEventFilterRequest();
        try {
            $gapicClient->deleteSubpropertyEventFilter($request);
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
    public function fetchAutomatedGa4ConfigurationOptOutTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $optOut = true;
        $expectedResponse = new FetchAutomatedGa4ConfigurationOptOutResponse();
        $expectedResponse->setOptOut($optOut);
        $transport->addResponse($expectedResponse);
        $request = new FetchAutomatedGa4ConfigurationOptOutRequest();
        $response = $gapicClient->fetchAutomatedGa4ConfigurationOptOut($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/FetchAutomatedGa4ConfigurationOptOut', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchAutomatedGa4ConfigurationOptOutExceptionTest()
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
        $request = new FetchAutomatedGa4ConfigurationOptOutRequest();
        try {
            $gapicClient->fetchAutomatedGa4ConfigurationOptOut($request);
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
    public function fetchConnectedGa4PropertyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $property2 = 'property2-926037944';
        $expectedResponse = new FetchConnectedGa4PropertyResponse();
        $expectedResponse->setProperty($property2);
        $transport->addResponse($expectedResponse);
        $request = new FetchConnectedGa4PropertyRequest();
        $response = $gapicClient->fetchConnectedGa4Property($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/FetchConnectedGa4Property', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchConnectedGa4PropertyExceptionTest()
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
        $request = new FetchConnectedGa4PropertyRequest();
        try {
            $gapicClient->fetchConnectedGa4Property($request);
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
    public function getAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $user = 'user3599307';
        $name2 = 'name2-1052831874';
        $expectedResponse = new AccessBinding();
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        $request = new GetAccessBindingRequest();
        $response = $gapicClient->getAccessBinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAccessBinding', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccessBindingExceptionTest()
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
        $request = new GetAccessBindingRequest();
        try {
            $gapicClient->getAccessBinding($request);
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
        $request = new GetAccountRequest();
        $response = $gapicClient->getAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAccount', $actualFuncCall);
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
        $request = new GetAccountRequest();
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
    public function getAdSenseLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $adClientCode = 'adClientCode-1866307643';
        $expectedResponse = new AdSenseLink();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdClientCode($adClientCode);
        $transport->addResponse($expectedResponse);
        $request = new GetAdSenseLinkRequest();
        $response = $gapicClient->getAdSenseLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAdSenseLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdSenseLinkExceptionTest()
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
        $request = new GetAdSenseLinkRequest();
        try {
            $gapicClient->getAdSenseLink($request);
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
    public function getAttributionSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new AttributionSettings();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        $request = new GetAttributionSettingsRequest();
        $response = $gapicClient->getAttributionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAttributionSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAttributionSettingsExceptionTest()
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
        $request = new GetAttributionSettingsRequest();
        try {
            $gapicClient->getAttributionSettings($request);
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
    public function getAudienceTest()
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
        $membershipDurationDays = 1702404985;
        $adsPersonalizationEnabled = false;
        $expectedResponse = new Audience();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setMembershipDurationDays($membershipDurationDays);
        $expectedResponse->setAdsPersonalizationEnabled($adsPersonalizationEnabled);
        $transport->addResponse($expectedResponse);
        $request = new GetAudienceRequest();
        $response = $gapicClient->getAudience($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAudience', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAudienceExceptionTest()
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
        $request = new GetAudienceRequest();
        try {
            $gapicClient->getAudience($request);
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
    public function getBigQueryLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $project = 'project-309310695';
        $dailyExportEnabled = true;
        $streamingExportEnabled = false;
        $freshDailyExportEnabled = false;
        $includeAdvertisingId = false;
        $expectedResponse = new BigQueryLink();
        $expectedResponse->setName($name2);
        $expectedResponse->setProject($project);
        $expectedResponse->setDailyExportEnabled($dailyExportEnabled);
        $expectedResponse->setStreamingExportEnabled($streamingExportEnabled);
        $expectedResponse->setFreshDailyExportEnabled($freshDailyExportEnabled);
        $expectedResponse->setIncludeAdvertisingId($includeAdvertisingId);
        $transport->addResponse($expectedResponse);
        $request = new GetBigQueryLinkRequest();
        $response = $gapicClient->getBigQueryLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetBigQueryLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getBigQueryLinkExceptionTest()
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
        $request = new GetBigQueryLinkRequest();
        try {
            $gapicClient->getBigQueryLink($request);
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
    public function getCalculatedMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $calculatedMetricId = 'calculatedMetricId8203465';
        $formula = 'formula-677424794';
        $invalidMetricReference = true;
        $expectedResponse = new CalculatedMetric();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setCalculatedMetricId($calculatedMetricId);
        $expectedResponse->setFormula($formula);
        $expectedResponse->setInvalidMetricReference($invalidMetricReference);
        $transport->addResponse($expectedResponse);
        $request = new GetCalculatedMetricRequest();
        $response = $gapicClient->getCalculatedMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetCalculatedMetric', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCalculatedMetricExceptionTest()
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
        $request = new GetCalculatedMetricRequest();
        try {
            $gapicClient->getCalculatedMetric($request);
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
    public function getChannelGroupTest()
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
        $systemDefined = false;
        $expectedResponse = new ChannelGroup();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setSystemDefined($systemDefined);
        $transport->addResponse($expectedResponse);
        $request = new GetChannelGroupRequest();
        $response = $gapicClient->getChannelGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetChannelGroup', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getChannelGroupExceptionTest()
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
        $request = new GetChannelGroupRequest();
        try {
            $gapicClient->getChannelGroup($request);
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
        $request = new GetConversionEventRequest();
        $response = $gapicClient->getConversionEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetConversionEvent', $actualFuncCall);
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
        $request = new GetConversionEventRequest();
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
        $request = new GetCustomDimensionRequest();
        $response = $gapicClient->getCustomDimension($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetCustomDimension', $actualFuncCall);
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
        $request = new GetCustomDimensionRequest();
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
        $request = new GetCustomMetricRequest();
        $response = $gapicClient->getCustomMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetCustomMetric', $actualFuncCall);
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
        $request = new GetCustomMetricRequest();
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
    public function getDataRedactionSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $emailRedactionEnabled = true;
        $queryParameterRedactionEnabled = true;
        $expectedResponse = new DataRedactionSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEmailRedactionEnabled($emailRedactionEnabled);
        $expectedResponse->setQueryParameterRedactionEnabled($queryParameterRedactionEnabled);
        $transport->addResponse($expectedResponse);
        $request = new GetDataRedactionSettingsRequest();
        $response = $gapicClient->getDataRedactionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataRedactionSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataRedactionSettingsExceptionTest()
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
        $request = new GetDataRedactionSettingsRequest();
        try {
            $gapicClient->getDataRedactionSettings($request);
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
        $request = new GetDataRetentionSettingsRequest();
        $response = $gapicClient->getDataRetentionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataRetentionSettings', $actualFuncCall);
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
        $request = new GetDataRetentionSettingsRequest();
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
        $request = new GetDataSharingSettingsRequest();
        $response = $gapicClient->getDataSharingSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataSharingSettings', $actualFuncCall);
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
        $request = new GetDataSharingSettingsRequest();
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
        $request = new GetDataStreamRequest();
        $response = $gapicClient->getDataStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataStream', $actualFuncCall);
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
        $request = new GetDataStreamRequest();
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
    public function getDisplayVideo360AdvertiserLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $expectedResponse = new DisplayVideo360AdvertiserLink();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $transport->addResponse($expectedResponse);
        $request = new GetDisplayVideo360AdvertiserLinkRequest();
        $response = $gapicClient->getDisplayVideo360AdvertiserLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDisplayVideo360AdvertiserLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDisplayVideo360AdvertiserLinkExceptionTest()
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
        $request = new GetDisplayVideo360AdvertiserLinkRequest();
        try {
            $gapicClient->getDisplayVideo360AdvertiserLink($request);
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
    public function getDisplayVideo360AdvertiserLinkProposalTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $validationEmail = 'validationEmail2105669718';
        $expectedResponse = new DisplayVideo360AdvertiserLinkProposal();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $expectedResponse->setValidationEmail($validationEmail);
        $transport->addResponse($expectedResponse);
        $request = new GetDisplayVideo360AdvertiserLinkProposalRequest();
        $response = $gapicClient->getDisplayVideo360AdvertiserLinkProposal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDisplayVideo360AdvertiserLinkProposal', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDisplayVideo360AdvertiserLinkProposalExceptionTest()
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
        $request = new GetDisplayVideo360AdvertiserLinkProposalRequest();
        try {
            $gapicClient->getDisplayVideo360AdvertiserLinkProposal($request);
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
    public function getEnhancedMeasurementSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $streamEnabled = true;
        $scrollsEnabled = true;
        $outboundClicksEnabled = true;
        $siteSearchEnabled = true;
        $videoEngagementEnabled = false;
        $fileDownloadsEnabled = true;
        $pageChangesEnabled = false;
        $formInteractionsEnabled = true;
        $searchQueryParameter = 'searchQueryParameter638048347';
        $uriQueryParameter = 'uriQueryParameter964636703';
        $expectedResponse = new EnhancedMeasurementSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setStreamEnabled($streamEnabled);
        $expectedResponse->setScrollsEnabled($scrollsEnabled);
        $expectedResponse->setOutboundClicksEnabled($outboundClicksEnabled);
        $expectedResponse->setSiteSearchEnabled($siteSearchEnabled);
        $expectedResponse->setVideoEngagementEnabled($videoEngagementEnabled);
        $expectedResponse->setFileDownloadsEnabled($fileDownloadsEnabled);
        $expectedResponse->setPageChangesEnabled($pageChangesEnabled);
        $expectedResponse->setFormInteractionsEnabled($formInteractionsEnabled);
        $expectedResponse->setSearchQueryParameter($searchQueryParameter);
        $expectedResponse->setUriQueryParameter($uriQueryParameter);
        $transport->addResponse($expectedResponse);
        $request = new GetEnhancedMeasurementSettingsRequest();
        $response = $gapicClient->getEnhancedMeasurementSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetEnhancedMeasurementSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEnhancedMeasurementSettingsExceptionTest()
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
        $request = new GetEnhancedMeasurementSettingsRequest();
        try {
            $gapicClient->getEnhancedMeasurementSettings($request);
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
    public function getEventCreateRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $destinationEvent = 'destinationEvent-1300408535';
        $sourceCopyParameters = true;
        $expectedResponse = new EventCreateRule();
        $expectedResponse->setName($name2);
        $expectedResponse->setDestinationEvent($destinationEvent);
        $expectedResponse->setSourceCopyParameters($sourceCopyParameters);
        $transport->addResponse($expectedResponse);
        $request = new GetEventCreateRuleRequest();
        $response = $gapicClient->getEventCreateRule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetEventCreateRule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEventCreateRuleExceptionTest()
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
        $request = new GetEventCreateRuleRequest();
        try {
            $gapicClient->getEventCreateRule($request);
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
    public function getExpandedDataSetTest()
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
        $expectedResponse = new ExpandedDataSet();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        $request = new GetExpandedDataSetRequest();
        $response = $gapicClient->getExpandedDataSet($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetExpandedDataSet', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExpandedDataSetExceptionTest()
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
        $request = new GetExpandedDataSetRequest();
        try {
            $gapicClient->getExpandedDataSet($request);
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
    public function getGlobalSiteTagTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $snippet = 'snippet-2061635299';
        $expectedResponse = new GlobalSiteTag();
        $expectedResponse->setName($name2);
        $expectedResponse->setSnippet($snippet);
        $transport->addResponse($expectedResponse);
        $request = new GetGlobalSiteTagRequest();
        $response = $gapicClient->getGlobalSiteTag($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetGlobalSiteTag', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getGlobalSiteTagExceptionTest()
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
        $request = new GetGlobalSiteTagRequest();
        try {
            $gapicClient->getGlobalSiteTag($request);
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
    public function getGoogleSignalsSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new GoogleSignalsSettings();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        $request = new GetGoogleSignalsSettingsRequest();
        $response = $gapicClient->getGoogleSignalsSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetGoogleSignalsSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getGoogleSignalsSettingsExceptionTest()
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
        $request = new GetGoogleSignalsSettingsRequest();
        try {
            $gapicClient->getGoogleSignalsSettings($request);
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
        $request = new GetMeasurementProtocolSecretRequest();
        $response = $gapicClient->getMeasurementProtocolSecret($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetMeasurementProtocolSecret', $actualFuncCall);
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
        $request = new GetMeasurementProtocolSecretRequest();
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
        $request = new GetPropertyRequest();
        $response = $gapicClient->getProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetProperty', $actualFuncCall);
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
        $request = new GetPropertyRequest();
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
    public function getRollupPropertySourceLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $sourceProperty = 'sourceProperty2069271929';
        $expectedResponse = new RollupPropertySourceLink();
        $expectedResponse->setName($name2);
        $expectedResponse->setSourceProperty($sourceProperty);
        $transport->addResponse($expectedResponse);
        $request = new GetRollupPropertySourceLinkRequest();
        $response = $gapicClient->getRollupPropertySourceLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetRollupPropertySourceLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRollupPropertySourceLinkExceptionTest()
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
        $request = new GetRollupPropertySourceLinkRequest();
        try {
            $gapicClient->getRollupPropertySourceLink($request);
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
    public function getSKAdNetworkConversionValueSchemaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $applyConversionValues = true;
        $expectedResponse = new SKAdNetworkConversionValueSchema();
        $expectedResponse->setName($name2);
        $expectedResponse->setApplyConversionValues($applyConversionValues);
        $transport->addResponse($expectedResponse);
        $request = new GetSKAdNetworkConversionValueSchemaRequest();
        $response = $gapicClient->getSKAdNetworkConversionValueSchema($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetSKAdNetworkConversionValueSchema', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSKAdNetworkConversionValueSchemaExceptionTest()
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
        $request = new GetSKAdNetworkConversionValueSchemaRequest();
        try {
            $gapicClient->getSKAdNetworkConversionValueSchema($request);
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
    public function getSearchAds360LinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $expectedResponse = new SearchAds360Link();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $transport->addResponse($expectedResponse);
        $request = new GetSearchAds360LinkRequest();
        $response = $gapicClient->getSearchAds360Link($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetSearchAds360Link', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSearchAds360LinkExceptionTest()
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
        $request = new GetSearchAds360LinkRequest();
        try {
            $gapicClient->getSearchAds360Link($request);
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
    public function getSubpropertyEventFilterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $applyToProperty = 'applyToProperty-1639692344';
        $expectedResponse = new SubpropertyEventFilter();
        $expectedResponse->setName($name2);
        $expectedResponse->setApplyToProperty($applyToProperty);
        $transport->addResponse($expectedResponse);
        $request = new GetSubpropertyEventFilterRequest();
        $response = $gapicClient->getSubpropertyEventFilter($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetSubpropertyEventFilter', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSubpropertyEventFilterExceptionTest()
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
        $request = new GetSubpropertyEventFilterRequest();
        try {
            $gapicClient->getSubpropertyEventFilter($request);
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
    public function listAccessBindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accessBindingsElement = new AccessBinding();
        $accessBindings = [
            $accessBindingsElement,
        ];
        $expectedResponse = new ListAccessBindingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccessBindings($accessBindings);
        $transport->addResponse($expectedResponse);
        $request = new ListAccessBindingsRequest();
        $response = $gapicClient->listAccessBindings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccessBindings()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAccessBindings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccessBindingsExceptionTest()
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
        $request = new ListAccessBindingsRequest();
        try {
            $gapicClient->listAccessBindings($request);
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
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAccountSummaries', $actualFuncCall);
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
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAccounts', $actualFuncCall);
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
    public function listAdSenseLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $adsenseLinksElement = new AdSenseLink();
        $adsenseLinks = [
            $adsenseLinksElement,
        ];
        $expectedResponse = new ListAdSenseLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAdsenseLinks($adsenseLinks);
        $transport->addResponse($expectedResponse);
        $request = new ListAdSenseLinksRequest();
        $response = $gapicClient->listAdSenseLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdsenseLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAdSenseLinks', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdSenseLinksExceptionTest()
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
        $request = new ListAdSenseLinksRequest();
        try {
            $gapicClient->listAdSenseLinks($request);
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
    public function listAudiencesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $audiencesElement = new Audience();
        $audiences = [
            $audiencesElement,
        ];
        $expectedResponse = new ListAudiencesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAudiences($audiences);
        $transport->addResponse($expectedResponse);
        $request = new ListAudiencesRequest();
        $response = $gapicClient->listAudiences($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAudiences()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAudiences', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAudiencesExceptionTest()
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
        $request = new ListAudiencesRequest();
        try {
            $gapicClient->listAudiences($request);
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
    public function listBigQueryLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $bigqueryLinksElement = new BigQueryLink();
        $bigqueryLinks = [
            $bigqueryLinksElement,
        ];
        $expectedResponse = new ListBigQueryLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBigqueryLinks($bigqueryLinks);
        $transport->addResponse($expectedResponse);
        $request = new ListBigQueryLinksRequest();
        $response = $gapicClient->listBigQueryLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBigqueryLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListBigQueryLinks', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listBigQueryLinksExceptionTest()
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
        $request = new ListBigQueryLinksRequest();
        try {
            $gapicClient->listBigQueryLinks($request);
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
    public function listCalculatedMetricsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $calculatedMetricsElement = new CalculatedMetric();
        $calculatedMetrics = [
            $calculatedMetricsElement,
        ];
        $expectedResponse = new ListCalculatedMetricsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCalculatedMetrics($calculatedMetrics);
        $transport->addResponse($expectedResponse);
        $request = new ListCalculatedMetricsRequest();
        $response = $gapicClient->listCalculatedMetrics($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCalculatedMetrics()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListCalculatedMetrics', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCalculatedMetricsExceptionTest()
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
        $request = new ListCalculatedMetricsRequest();
        try {
            $gapicClient->listCalculatedMetrics($request);
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
    public function listChannelGroupsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $channelGroupsElement = new ChannelGroup();
        $channelGroups = [
            $channelGroupsElement,
        ];
        $expectedResponse = new ListChannelGroupsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setChannelGroups($channelGroups);
        $transport->addResponse($expectedResponse);
        $request = new ListChannelGroupsRequest();
        $response = $gapicClient->listChannelGroups($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getChannelGroups()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListChannelGroups', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listChannelGroupsExceptionTest()
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
        $request = new ListChannelGroupsRequest();
        try {
            $gapicClient->listChannelGroups($request);
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
    public function listConnectedSiteTagsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListConnectedSiteTagsResponse();
        $transport->addResponse($expectedResponse);
        $request = new ListConnectedSiteTagsRequest();
        $response = $gapicClient->listConnectedSiteTags($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListConnectedSiteTags', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listConnectedSiteTagsExceptionTest()
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
        $request = new ListConnectedSiteTagsRequest();
        try {
            $gapicClient->listConnectedSiteTags($request);
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
        $request = new ListConversionEventsRequest();
        $response = $gapicClient->listConversionEvents($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getConversionEvents()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListConversionEvents', $actualFuncCall);
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
        $request = new ListConversionEventsRequest();
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
        $request = new ListCustomDimensionsRequest();
        $response = $gapicClient->listCustomDimensions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomDimensions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListCustomDimensions', $actualFuncCall);
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
        $request = new ListCustomDimensionsRequest();
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
        $request = new ListCustomMetricsRequest();
        $response = $gapicClient->listCustomMetrics($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomMetrics()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListCustomMetrics', $actualFuncCall);
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
        $request = new ListCustomMetricsRequest();
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
        $request = new ListDataStreamsRequest();
        $response = $gapicClient->listDataStreams($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataStreams()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListDataStreams', $actualFuncCall);
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
        $request = new ListDataStreamsRequest();
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
    public function listDisplayVideo360AdvertiserLinkProposalsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $displayVideo360AdvertiserLinkProposalsElement = new DisplayVideo360AdvertiserLinkProposal();
        $displayVideo360AdvertiserLinkProposals = [
            $displayVideo360AdvertiserLinkProposalsElement,
        ];
        $expectedResponse = new ListDisplayVideo360AdvertiserLinkProposalsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDisplayVideo360AdvertiserLinkProposals($displayVideo360AdvertiserLinkProposals);
        $transport->addResponse($expectedResponse);
        $request = new ListDisplayVideo360AdvertiserLinkProposalsRequest();
        $response = $gapicClient->listDisplayVideo360AdvertiserLinkProposals($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDisplayVideo360AdvertiserLinkProposals()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListDisplayVideo360AdvertiserLinkProposals', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDisplayVideo360AdvertiserLinkProposalsExceptionTest()
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
        $request = new ListDisplayVideo360AdvertiserLinkProposalsRequest();
        try {
            $gapicClient->listDisplayVideo360AdvertiserLinkProposals($request);
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
    public function listDisplayVideo360AdvertiserLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $displayVideo360AdvertiserLinksElement = new DisplayVideo360AdvertiserLink();
        $displayVideo360AdvertiserLinks = [
            $displayVideo360AdvertiserLinksElement,
        ];
        $expectedResponse = new ListDisplayVideo360AdvertiserLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDisplayVideo360AdvertiserLinks($displayVideo360AdvertiserLinks);
        $transport->addResponse($expectedResponse);
        $request = new ListDisplayVideo360AdvertiserLinksRequest();
        $response = $gapicClient->listDisplayVideo360AdvertiserLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDisplayVideo360AdvertiserLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListDisplayVideo360AdvertiserLinks', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDisplayVideo360AdvertiserLinksExceptionTest()
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
        $request = new ListDisplayVideo360AdvertiserLinksRequest();
        try {
            $gapicClient->listDisplayVideo360AdvertiserLinks($request);
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
    public function listEventCreateRulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $eventCreateRulesElement = new EventCreateRule();
        $eventCreateRules = [
            $eventCreateRulesElement,
        ];
        $expectedResponse = new ListEventCreateRulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEventCreateRules($eventCreateRules);
        $transport->addResponse($expectedResponse);
        $request = new ListEventCreateRulesRequest();
        $response = $gapicClient->listEventCreateRules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEventCreateRules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListEventCreateRules', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEventCreateRulesExceptionTest()
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
        $request = new ListEventCreateRulesRequest();
        try {
            $gapicClient->listEventCreateRules($request);
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
    public function listExpandedDataSetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $expandedDataSetsElement = new ExpandedDataSet();
        $expandedDataSets = [
            $expandedDataSetsElement,
        ];
        $expectedResponse = new ListExpandedDataSetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setExpandedDataSets($expandedDataSets);
        $transport->addResponse($expectedResponse);
        $request = new ListExpandedDataSetsRequest();
        $response = $gapicClient->listExpandedDataSets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getExpandedDataSets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListExpandedDataSets', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExpandedDataSetsExceptionTest()
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
        $request = new ListExpandedDataSetsRequest();
        try {
            $gapicClient->listExpandedDataSets($request);
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
        $request = new ListFirebaseLinksRequest();
        $response = $gapicClient->listFirebaseLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFirebaseLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListFirebaseLinks', $actualFuncCall);
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
        $request = new ListFirebaseLinksRequest();
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
        $request = new ListGoogleAdsLinksRequest();
        $response = $gapicClient->listGoogleAdsLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGoogleAdsLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListGoogleAdsLinks', $actualFuncCall);
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
        $request = new ListGoogleAdsLinksRequest();
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
        $request = new ListMeasurementProtocolSecretsRequest();
        $response = $gapicClient->listMeasurementProtocolSecrets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMeasurementProtocolSecrets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListMeasurementProtocolSecrets', $actualFuncCall);
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
        $request = new ListMeasurementProtocolSecretsRequest();
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
        $request = new ListPropertiesRequest();
        $response = $gapicClient->listProperties($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getProperties()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListProperties', $actualFuncCall);
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
        $request = new ListPropertiesRequest();
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
    public function listRollupPropertySourceLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $rollupPropertySourceLinksElement = new RollupPropertySourceLink();
        $rollupPropertySourceLinks = [
            $rollupPropertySourceLinksElement,
        ];
        $expectedResponse = new ListRollupPropertySourceLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRollupPropertySourceLinks($rollupPropertySourceLinks);
        $transport->addResponse($expectedResponse);
        $request = new ListRollupPropertySourceLinksRequest();
        $response = $gapicClient->listRollupPropertySourceLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRollupPropertySourceLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListRollupPropertySourceLinks', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRollupPropertySourceLinksExceptionTest()
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
        $request = new ListRollupPropertySourceLinksRequest();
        try {
            $gapicClient->listRollupPropertySourceLinks($request);
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
    public function listSKAdNetworkConversionValueSchemasTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $skadnetworkConversionValueSchemasElement = new SKAdNetworkConversionValueSchema();
        $skadnetworkConversionValueSchemas = [
            $skadnetworkConversionValueSchemasElement,
        ];
        $expectedResponse = new ListSKAdNetworkConversionValueSchemasResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSkadnetworkConversionValueSchemas($skadnetworkConversionValueSchemas);
        $transport->addResponse($expectedResponse);
        $request = new ListSKAdNetworkConversionValueSchemasRequest();
        $response = $gapicClient->listSKAdNetworkConversionValueSchemas($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSkadnetworkConversionValueSchemas()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListSKAdNetworkConversionValueSchemas', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSKAdNetworkConversionValueSchemasExceptionTest()
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
        $request = new ListSKAdNetworkConversionValueSchemasRequest();
        try {
            $gapicClient->listSKAdNetworkConversionValueSchemas($request);
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
    public function listSearchAds360LinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $searchAds360LinksElement = new SearchAds360Link();
        $searchAds360Links = [
            $searchAds360LinksElement,
        ];
        $expectedResponse = new ListSearchAds360LinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSearchAds360Links($searchAds360Links);
        $transport->addResponse($expectedResponse);
        $request = new ListSearchAds360LinksRequest();
        $response = $gapicClient->listSearchAds360Links($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSearchAds360Links()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListSearchAds360Links', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSearchAds360LinksExceptionTest()
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
        $request = new ListSearchAds360LinksRequest();
        try {
            $gapicClient->listSearchAds360Links($request);
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
    public function listSubpropertyEventFiltersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $subpropertyEventFiltersElement = new SubpropertyEventFilter();
        $subpropertyEventFilters = [
            $subpropertyEventFiltersElement,
        ];
        $expectedResponse = new ListSubpropertyEventFiltersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSubpropertyEventFilters($subpropertyEventFilters);
        $transport->addResponse($expectedResponse);
        $request = new ListSubpropertyEventFiltersRequest();
        $response = $gapicClient->listSubpropertyEventFilters($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSubpropertyEventFilters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListSubpropertyEventFilters', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSubpropertyEventFiltersExceptionTest()
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
        $request = new ListSubpropertyEventFiltersRequest();
        try {
            $gapicClient->listSubpropertyEventFilters($request);
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
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/ProvisionAccountTicket', $actualFuncCall);
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
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/RunAccessReport', $actualFuncCall);
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
        $request = new SearchChangeHistoryEventsRequest();
        $response = $gapicClient->searchChangeHistoryEvents($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getChangeHistoryEvents()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/SearchChangeHistoryEvents', $actualFuncCall);
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
        $request = new SearchChangeHistoryEventsRequest();
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
    public function setAutomatedGa4ConfigurationOptOutTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SetAutomatedGa4ConfigurationOptOutResponse();
        $transport->addResponse($expectedResponse);
        $request = new SetAutomatedGa4ConfigurationOptOutRequest();
        $response = $gapicClient->setAutomatedGa4ConfigurationOptOut($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/SetAutomatedGa4ConfigurationOptOut', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setAutomatedGa4ConfigurationOptOutExceptionTest()
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
        $request = new SetAutomatedGa4ConfigurationOptOutRequest();
        try {
            $gapicClient->setAutomatedGa4ConfigurationOptOut($request);
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
    public function updateAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $user = 'user3599307';
        $name = 'name3373707';
        $expectedResponse = new AccessBinding();
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        $request = new UpdateAccessBindingRequest();
        $response = $gapicClient->updateAccessBinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAccessBinding', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAccessBindingExceptionTest()
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
        $request = new UpdateAccessBindingRequest();
        try {
            $gapicClient->updateAccessBinding($request);
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
        $request = new UpdateAccountRequest();
        $response = $gapicClient->updateAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAccount', $actualFuncCall);
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
        $request = new UpdateAccountRequest();
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
    public function updateAttributionSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new AttributionSettings();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        $request = new UpdateAttributionSettingsRequest();
        $response = $gapicClient->updateAttributionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAttributionSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAttributionSettingsExceptionTest()
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
        $request = new UpdateAttributionSettingsRequest();
        try {
            $gapicClient->updateAttributionSettings($request);
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
    public function updateAudienceTest()
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
        $membershipDurationDays = 1702404985;
        $adsPersonalizationEnabled = false;
        $expectedResponse = new Audience();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setMembershipDurationDays($membershipDurationDays);
        $expectedResponse->setAdsPersonalizationEnabled($adsPersonalizationEnabled);
        $transport->addResponse($expectedResponse);
        $request = new UpdateAudienceRequest();
        $response = $gapicClient->updateAudience($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAudience', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAudienceExceptionTest()
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
        $request = new UpdateAudienceRequest();
        try {
            $gapicClient->updateAudience($request);
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
    public function updateCalculatedMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $calculatedMetricId = 'calculatedMetricId8203465';
        $formula = 'formula-677424794';
        $invalidMetricReference = true;
        $expectedResponse = new CalculatedMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setCalculatedMetricId($calculatedMetricId);
        $expectedResponse->setFormula($formula);
        $expectedResponse->setInvalidMetricReference($invalidMetricReference);
        $transport->addResponse($expectedResponse);
        $request = new UpdateCalculatedMetricRequest();
        $response = $gapicClient->updateCalculatedMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateCalculatedMetric', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCalculatedMetricExceptionTest()
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
        $request = new UpdateCalculatedMetricRequest();
        try {
            $gapicClient->updateCalculatedMetric($request);
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
    public function updateChannelGroupTest()
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
        $systemDefined = false;
        $expectedResponse = new ChannelGroup();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setSystemDefined($systemDefined);
        $transport->addResponse($expectedResponse);
        $request = new UpdateChannelGroupRequest();
        $response = $gapicClient->updateChannelGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateChannelGroup', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateChannelGroupExceptionTest()
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
        $request = new UpdateChannelGroupRequest();
        try {
            $gapicClient->updateChannelGroup($request);
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
        $request = new UpdateConversionEventRequest();
        $response = $gapicClient->updateConversionEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateConversionEvent', $actualFuncCall);
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
        $request = new UpdateConversionEventRequest();
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
        $request = new UpdateCustomDimensionRequest();
        $response = $gapicClient->updateCustomDimension($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateCustomDimension', $actualFuncCall);
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
        $request = new UpdateCustomDimensionRequest();
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
        $request = new UpdateCustomMetricRequest();
        $response = $gapicClient->updateCustomMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateCustomMetric', $actualFuncCall);
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
        $request = new UpdateCustomMetricRequest();
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
    public function updateDataRedactionSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $emailRedactionEnabled = true;
        $queryParameterRedactionEnabled = true;
        $expectedResponse = new DataRedactionSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setEmailRedactionEnabled($emailRedactionEnabled);
        $expectedResponse->setQueryParameterRedactionEnabled($queryParameterRedactionEnabled);
        $transport->addResponse($expectedResponse);
        $request = new UpdateDataRedactionSettingsRequest();
        $response = $gapicClient->updateDataRedactionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDataRedactionSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataRedactionSettingsExceptionTest()
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
        $request = new UpdateDataRedactionSettingsRequest();
        try {
            $gapicClient->updateDataRedactionSettings($request);
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
        $request = new UpdateDataRetentionSettingsRequest();
        $response = $gapicClient->updateDataRetentionSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDataRetentionSettings', $actualFuncCall);
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
        $request = new UpdateDataRetentionSettingsRequest();
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
        $request = new UpdateDataStreamRequest();
        $response = $gapicClient->updateDataStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDataStream', $actualFuncCall);
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
        $request = new UpdateDataStreamRequest();
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
    public function updateDisplayVideo360AdvertiserLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $expectedResponse = new DisplayVideo360AdvertiserLink();
        $expectedResponse->setName($name);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $transport->addResponse($expectedResponse);
        $request = new UpdateDisplayVideo360AdvertiserLinkRequest();
        $response = $gapicClient->updateDisplayVideo360AdvertiserLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDisplayVideo360AdvertiserLink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDisplayVideo360AdvertiserLinkExceptionTest()
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
        $request = new UpdateDisplayVideo360AdvertiserLinkRequest();
        try {
            $gapicClient->updateDisplayVideo360AdvertiserLink($request);
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
    public function updateEnhancedMeasurementSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $streamEnabled = true;
        $scrollsEnabled = true;
        $outboundClicksEnabled = true;
        $siteSearchEnabled = true;
        $videoEngagementEnabled = false;
        $fileDownloadsEnabled = true;
        $pageChangesEnabled = false;
        $formInteractionsEnabled = true;
        $searchQueryParameter = 'searchQueryParameter638048347';
        $uriQueryParameter = 'uriQueryParameter964636703';
        $expectedResponse = new EnhancedMeasurementSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setStreamEnabled($streamEnabled);
        $expectedResponse->setScrollsEnabled($scrollsEnabled);
        $expectedResponse->setOutboundClicksEnabled($outboundClicksEnabled);
        $expectedResponse->setSiteSearchEnabled($siteSearchEnabled);
        $expectedResponse->setVideoEngagementEnabled($videoEngagementEnabled);
        $expectedResponse->setFileDownloadsEnabled($fileDownloadsEnabled);
        $expectedResponse->setPageChangesEnabled($pageChangesEnabled);
        $expectedResponse->setFormInteractionsEnabled($formInteractionsEnabled);
        $expectedResponse->setSearchQueryParameter($searchQueryParameter);
        $expectedResponse->setUriQueryParameter($uriQueryParameter);
        $transport->addResponse($expectedResponse);
        $request = new UpdateEnhancedMeasurementSettingsRequest();
        $response = $gapicClient->updateEnhancedMeasurementSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateEnhancedMeasurementSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateEnhancedMeasurementSettingsExceptionTest()
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
        $request = new UpdateEnhancedMeasurementSettingsRequest();
        try {
            $gapicClient->updateEnhancedMeasurementSettings($request);
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
    public function updateEventCreateRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $destinationEvent = 'destinationEvent-1300408535';
        $sourceCopyParameters = true;
        $expectedResponse = new EventCreateRule();
        $expectedResponse->setName($name);
        $expectedResponse->setDestinationEvent($destinationEvent);
        $expectedResponse->setSourceCopyParameters($sourceCopyParameters);
        $transport->addResponse($expectedResponse);
        $request = new UpdateEventCreateRuleRequest();
        $response = $gapicClient->updateEventCreateRule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateEventCreateRule', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateEventCreateRuleExceptionTest()
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
        $request = new UpdateEventCreateRuleRequest();
        try {
            $gapicClient->updateEventCreateRule($request);
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
    public function updateExpandedDataSetTest()
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
        $expectedResponse = new ExpandedDataSet();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        $request = new UpdateExpandedDataSetRequest();
        $response = $gapicClient->updateExpandedDataSet($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateExpandedDataSet', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateExpandedDataSetExceptionTest()
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
        $request = new UpdateExpandedDataSetRequest();
        try {
            $gapicClient->updateExpandedDataSet($request);
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
        $request = new UpdateGoogleAdsLinkRequest();
        $response = $gapicClient->updateGoogleAdsLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateGoogleAdsLink', $actualFuncCall);
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
        $request = new UpdateGoogleAdsLinkRequest();
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
    public function updateGoogleSignalsSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new GoogleSignalsSettings();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        $request = new UpdateGoogleSignalsSettingsRequest();
        $response = $gapicClient->updateGoogleSignalsSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateGoogleSignalsSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateGoogleSignalsSettingsExceptionTest()
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
        $request = new UpdateGoogleSignalsSettingsRequest();
        try {
            $gapicClient->updateGoogleSignalsSettings($request);
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
        $request = new UpdateMeasurementProtocolSecretRequest();
        $response = $gapicClient->updateMeasurementProtocolSecret($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateMeasurementProtocolSecret', $actualFuncCall);
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
        $request = new UpdateMeasurementProtocolSecretRequest();
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
        $request = new UpdatePropertyRequest();
        $response = $gapicClient->updateProperty($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateProperty', $actualFuncCall);
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
        $request = new UpdatePropertyRequest();
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
    public function updateSKAdNetworkConversionValueSchemaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $applyConversionValues = true;
        $expectedResponse = new SKAdNetworkConversionValueSchema();
        $expectedResponse->setName($name);
        $expectedResponse->setApplyConversionValues($applyConversionValues);
        $transport->addResponse($expectedResponse);
        $request = new UpdateSKAdNetworkConversionValueSchemaRequest();
        $response = $gapicClient->updateSKAdNetworkConversionValueSchema($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateSKAdNetworkConversionValueSchema', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSKAdNetworkConversionValueSchemaExceptionTest()
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
        $request = new UpdateSKAdNetworkConversionValueSchemaRequest();
        try {
            $gapicClient->updateSKAdNetworkConversionValueSchema($request);
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
    public function updateSearchAds360LinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $advertiserId = 'advertiserId-127926097';
        $advertiserDisplayName = 'advertiserDisplayName-674771332';
        $expectedResponse = new SearchAds360Link();
        $expectedResponse->setName($name);
        $expectedResponse->setAdvertiserId($advertiserId);
        $expectedResponse->setAdvertiserDisplayName($advertiserDisplayName);
        $transport->addResponse($expectedResponse);
        $request = new UpdateSearchAds360LinkRequest();
        $response = $gapicClient->updateSearchAds360Link($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateSearchAds360Link', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSearchAds360LinkExceptionTest()
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
        $request = new UpdateSearchAds360LinkRequest();
        try {
            $gapicClient->updateSearchAds360Link($request);
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
    public function updateSubpropertyEventFilterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $applyToProperty = 'applyToProperty-1639692344';
        $expectedResponse = new SubpropertyEventFilter();
        $expectedResponse->setName($name);
        $expectedResponse->setApplyToProperty($applyToProperty);
        $transport->addResponse($expectedResponse);
        $request = new UpdateSubpropertyEventFilterRequest();
        $response = $gapicClient->updateSubpropertyEventFilter($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateSubpropertyEventFilter', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSubpropertyEventFilterExceptionTest()
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
        $request = new UpdateSubpropertyEventFilterRequest();
        try {
            $gapicClient->updateSubpropertyEventFilter($request);
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
        $request = new AcknowledgeUserDataCollectionRequest();
        $response = $gapicClient->acknowledgeUserDataCollectionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.admin.v1alpha.AnalyticsAdminService/AcknowledgeUserDataCollection', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }
}
