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

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START admanager_v1_generated_ForecastAdjustmentService_BatchCreateForecastAdjustments_sync]
use Google\Ads\AdManager\V1\BatchCreateForecastAdjustmentsRequest;
use Google\Ads\AdManager\V1\BatchCreateForecastAdjustmentsResponse;
use Google\Ads\AdManager\V1\Client\ForecastAdjustmentServiceClient;
use Google\Ads\AdManager\V1\CreateForecastAdjustmentRequest;
use Google\Ads\AdManager\V1\DateRange;
use Google\Ads\AdManager\V1\ForecastAdjustment;
use Google\Ads\AdManager\V1\ForecastAdjustmentVolumeTypeEnum\ForecastAdjustmentVolumeType;
use Google\ApiCore\ApiException;

/**
 * Creates `ForecastAdjustment` objects.
 *
 * @param string $formattedParent                                           The parent resource where `ForecastAdjustments` will be created.
 *                                                                          Format: `networks/{network_code}`
 *                                                                          The parent field in the CreateForecastAdjustmentRequest must match this
 *                                                                          field. Please see
 *                                                                          {@see ForecastAdjustmentServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent                                   The parent resource where this `ForecastAdjustment` will be
 *                                                                          created. Format: `networks/{network_code}`
 *                                                                          Please see {@see ForecastAdjustmentServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsForecastAdjustmentTrafficForecastSegment Immutable. The resource name of the `TrafficForecastSegment` that
 *                                                                          this adjustment is associated with. Format:
 *                                                                          `networks/{network_code}/trafficForecastSegments/{trafficForecastSegmentId}`
 *                                                                          Please see {@see ForecastAdjustmentServiceClient::trafficForecastSegmentName()} for help formatting this field.
 * @param string $requestsForecastAdjustmentDisplayName                     Display name of the ForecastAdjustment.
 * @param int    $requestsForecastAdjustmentVolumeType                      The volume type of the adjustment.
 */
function batch_create_forecast_adjustments_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $formattedRequestsForecastAdjustmentTrafficForecastSegment,
    string $requestsForecastAdjustmentDisplayName,
    int $requestsForecastAdjustmentVolumeType
): void {
    // Create a client.
    $forecastAdjustmentServiceClient = new ForecastAdjustmentServiceClient();

    // Prepare the request message.
    $requestsForecastAdjustmentDateRange = new DateRange();
    $requestsForecastAdjustment = (new ForecastAdjustment())
        ->setTrafficForecastSegment($formattedRequestsForecastAdjustmentTrafficForecastSegment)
        ->setDisplayName($requestsForecastAdjustmentDisplayName)
        ->setDateRange($requestsForecastAdjustmentDateRange)
        ->setVolumeType($requestsForecastAdjustmentVolumeType);
    $createForecastAdjustmentRequest = (new CreateForecastAdjustmentRequest())
        ->setParent($formattedRequestsParent)
        ->setForecastAdjustment($requestsForecastAdjustment);
    $requests = [$createForecastAdjustmentRequest];
    $request = (new BatchCreateForecastAdjustmentsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateForecastAdjustmentsResponse $response */
        $response = $forecastAdjustmentServiceClient->batchCreateForecastAdjustments($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = ForecastAdjustmentServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = ForecastAdjustmentServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsForecastAdjustmentTrafficForecastSegment = ForecastAdjustmentServiceClient::trafficForecastSegmentName(
        '[NETWORK_CODE]',
        '[TRAFFIC_FORECAST_SEGMENT]'
    );
    $requestsForecastAdjustmentDisplayName = '[DISPLAY_NAME]';
    $requestsForecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;

    batch_create_forecast_adjustments_sample(
        $formattedParent,
        $formattedRequestsParent,
        $formattedRequestsForecastAdjustmentTrafficForecastSegment,
        $requestsForecastAdjustmentDisplayName,
        $requestsForecastAdjustmentVolumeType
    );
}
// [END admanager_v1_generated_ForecastAdjustmentService_BatchCreateForecastAdjustments_sync]
