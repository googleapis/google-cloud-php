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

// [START admanager_v1_generated_ForecastAdjustmentService_CalculateDailyAdOpportunityCounts_sync]
use Google\Ads\AdManager\V1\CalculateDailyAdOpportunityCountsRequest;
use Google\Ads\AdManager\V1\CalculateDailyAdOpportunityCountsResponse;
use Google\Ads\AdManager\V1\Client\ForecastAdjustmentServiceClient;
use Google\Ads\AdManager\V1\DateRange;
use Google\Ads\AdManager\V1\ForecastAdjustment;
use Google\Ads\AdManager\V1\ForecastAdjustmentVolumeTypeEnum\ForecastAdjustmentVolumeType;
use Google\ApiCore\ApiException;

/**
 * Calculates daily ad opportunity counts for a prospective
 * `ForecastAdjustment` object.
 *
 * @param string $formattedParent                                   The parent resource where this `ForecastAdjustment` will be
 *                                                                  calculated. Format: `networks/{network_code}`
 *                                                                  Please see {@see ForecastAdjustmentServiceClient::networkName()} for help formatting this field.
 * @param string $formattedForecastAdjustmentTrafficForecastSegment Immutable. The resource name of the `TrafficForecastSegment` that
 *                                                                  this adjustment is associated with. Format:
 *                                                                  `networks/{network_code}/trafficForecastSegments/{trafficForecastSegmentId}`
 *                                                                  Please see {@see ForecastAdjustmentServiceClient::trafficForecastSegmentName()} for help formatting this field.
 * @param string $forecastAdjustmentDisplayName                     Display name of the ForecastAdjustment.
 * @param int    $forecastAdjustmentVolumeType                      The volume type of the adjustment.
 */
function calculate_daily_ad_opportunity_counts_sample(
    string $formattedParent,
    string $formattedForecastAdjustmentTrafficForecastSegment,
    string $forecastAdjustmentDisplayName,
    int $forecastAdjustmentVolumeType
): void {
    // Create a client.
    $forecastAdjustmentServiceClient = new ForecastAdjustmentServiceClient();

    // Prepare the request message.
    $forecastAdjustmentDateRange = new DateRange();
    $forecastAdjustment = (new ForecastAdjustment())
        ->setTrafficForecastSegment($formattedForecastAdjustmentTrafficForecastSegment)
        ->setDisplayName($forecastAdjustmentDisplayName)
        ->setDateRange($forecastAdjustmentDateRange)
        ->setVolumeType($forecastAdjustmentVolumeType);
    $request = (new CalculateDailyAdOpportunityCountsRequest())
        ->setParent($formattedParent)
        ->setForecastAdjustment($forecastAdjustment);

    // Call the API and handle any network failures.
    try {
        /** @var CalculateDailyAdOpportunityCountsResponse $response */
        $response = $forecastAdjustmentServiceClient->calculateDailyAdOpportunityCounts($request);
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
    $formattedForecastAdjustmentTrafficForecastSegment = ForecastAdjustmentServiceClient::trafficForecastSegmentName(
        '[NETWORK_CODE]',
        '[TRAFFIC_FORECAST_SEGMENT]'
    );
    $forecastAdjustmentDisplayName = '[DISPLAY_NAME]';
    $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;

    calculate_daily_ad_opportunity_counts_sample(
        $formattedParent,
        $formattedForecastAdjustmentTrafficForecastSegment,
        $forecastAdjustmentDisplayName,
        $forecastAdjustmentVolumeType
    );
}
// [END admanager_v1_generated_ForecastAdjustmentService_CalculateDailyAdOpportunityCounts_sync]
