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

// [START admanager_v1_generated_TrafficForecastSegmentService_BatchUpdateTrafficForecastSegments_sync]
use Google\Ads\AdManager\V1\BatchUpdateTrafficForecastSegmentsRequest;
use Google\Ads\AdManager\V1\BatchUpdateTrafficForecastSegmentsResponse;
use Google\Ads\AdManager\V1\Client\TrafficForecastSegmentServiceClient;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\TrafficForecastSegment;
use Google\Ads\AdManager\V1\UpdateTrafficForecastSegmentRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `TrafficForecastSegment` objects.
 *
 * @param string $formattedParent                           The parent resource where `TrafficForecastSegments` will be
 *                                                          updated. Format: `networks/{network_code}` The parent field in the
 *                                                          UpdateTrafficForecastSegmentRequest must match this field. Please see
 *                                                          {@see TrafficForecastSegmentServiceClient::networkName()} for help formatting this field.
 * @param string $requestsTrafficForecastSegmentDisplayName Name of the TrafficForecastSegment. This field must be unique
 *                                                          among all segments for this network.
 */
function batch_update_traffic_forecast_segments_sample(
    string $formattedParent,
    string $requestsTrafficForecastSegmentDisplayName
): void {
    // Create a client.
    $trafficForecastSegmentServiceClient = new TrafficForecastSegmentServiceClient();

    // Prepare the request message.
    $requestsTrafficForecastSegmentTargeting = new Targeting();
    $requestsTrafficForecastSegment = (new TrafficForecastSegment())
        ->setDisplayName($requestsTrafficForecastSegmentDisplayName)
        ->setTargeting($requestsTrafficForecastSegmentTargeting);
    $updateTrafficForecastSegmentRequest = (new UpdateTrafficForecastSegmentRequest())
        ->setTrafficForecastSegment($requestsTrafficForecastSegment);
    $requests = [$updateTrafficForecastSegmentRequest];
    $request = (new BatchUpdateTrafficForecastSegmentsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateTrafficForecastSegmentsResponse $response */
        $response = $trafficForecastSegmentServiceClient->batchUpdateTrafficForecastSegments($request);
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
    $formattedParent = TrafficForecastSegmentServiceClient::networkName('[NETWORK_CODE]');
    $requestsTrafficForecastSegmentDisplayName = '[DISPLAY_NAME]';

    batch_update_traffic_forecast_segments_sample(
        $formattedParent,
        $requestsTrafficForecastSegmentDisplayName
    );
}
// [END admanager_v1_generated_TrafficForecastSegmentService_BatchUpdateTrafficForecastSegments_sync]
