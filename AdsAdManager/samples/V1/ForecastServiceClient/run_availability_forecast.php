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

// [START admanager_v1_generated_ForecastService_RunAvailabilityForecast_sync]
use Google\Ads\AdManager\V1\AvailabilityForecastOptions;
use Google\Ads\AdManager\V1\Client\ForecastServiceClient;
use Google\Ads\AdManager\V1\RunAvailabilityForecastRequest;
use Google\Ads\AdManager\V1\RunAvailabilityForecastResponse;
use Google\ApiCore\ApiException;

/**
 * Gets the availability forecast for a [ProposalLineItem][] or
 * [LineItem][google.ads.admanager.v1.LineItem]. An availability forecast
 * reports the maximum number of available units that the line item can book,
 * and the total number of units matching the line item's targeting.
 *
 * @param string $formattedParent Format: `networks/{network_code}`
 *                                Please see {@see ForecastServiceClient::networkName()} for help formatting this field.
 */
function run_availability_forecast_sample(string $formattedParent): void
{
    // Create a client.
    $forecastServiceClient = new ForecastServiceClient();

    // Prepare the request message.
    $availabilityForecastOptions = new AvailabilityForecastOptions();
    $request = (new RunAvailabilityForecastRequest())
        ->setParent($formattedParent)
        ->setAvailabilityForecastOptions($availabilityForecastOptions);

    // Call the API and handle any network failures.
    try {
        /** @var RunAvailabilityForecastResponse $response */
        $response = $forecastServiceClient->runAvailabilityForecast($request);
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
    $formattedParent = ForecastServiceClient::networkName('[NETWORK_CODE]');

    run_availability_forecast_sample($formattedParent);
}
// [END admanager_v1_generated_ForecastService_RunAvailabilityForecast_sync]
