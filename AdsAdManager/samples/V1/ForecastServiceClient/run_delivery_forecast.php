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

// [START admanager_v1_generated_ForecastService_RunDeliveryForecast_sync]
use Google\Ads\AdManager\V1\Client\ForecastServiceClient;
use Google\Ads\AdManager\V1\DeliveryForecastOptions;
use Google\Ads\AdManager\V1\RunDeliveryForecastRequest;
use Google\Ads\AdManager\V1\RunDeliveryForecastResponse;
use Google\ApiCore\ApiException;

/**
 * Runs a delivery simulation forecast for existing or prospective line items.
 * A delivery forecast reports the number of units that will be delivered to
 * each line item given the line item goals. The simulation considers
 * contentions from other line items, including the other prospective line
 * items in the request.
 *
 * @param string $formattedParent Format: `networks/{network_code}`
 *                                Please see {@see ForecastServiceClient::networkName()} for help formatting this field.
 */
function run_delivery_forecast_sample(string $formattedParent): void
{
    // Create a client.
    $forecastServiceClient = new ForecastServiceClient();

    // Prepare the request message.
    $deliveryForecastOptions = new DeliveryForecastOptions();
    $request = (new RunDeliveryForecastRequest())
        ->setParent($formattedParent)
        ->setDeliveryForecastOptions($deliveryForecastOptions);

    // Call the API and handle any network failures.
    try {
        /** @var RunDeliveryForecastResponse $response */
        $response = $forecastServiceClient->runDeliveryForecast($request);
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

    run_delivery_forecast_sample($formattedParent);
}
// [END admanager_v1_generated_ForecastService_RunDeliveryForecast_sync]
