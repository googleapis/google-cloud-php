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

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START chronicle_v1_generated_EntityService_CreateWatchlist_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\EntityServiceClient;
use Google\Cloud\Chronicle\V1\CreateWatchlistRequest;
use Google\Cloud\Chronicle\V1\Watchlist;
use Google\Cloud\Chronicle\V1\Watchlist\EntityPopulationMechanism;

/**
 * Creates a watchlist for the given instance.
 * Note that there can be at most 200 watchlists per instance.
 *
 * @param string $formattedParent      The parent resource where this watchlist will be created.
 *                                     Format: `projects/{project}/locations/{location}/instances/{instance}`
 *                                     Please see {@see EntityServiceClient::instanceName()} for help formatting this field.
 * @param string $watchlistDisplayName Display name of the watchlist.
 *                                     Note that it must be at least one character and less than 63 characters
 *                                     (https://google.aip.dev/148).
 */
function create_watchlist_sample(string $formattedParent, string $watchlistDisplayName): void
{
    // Create a client.
    $entityServiceClient = new EntityServiceClient();

    // Prepare the request message.
    $watchlistEntityPopulationMechanism = new EntityPopulationMechanism();
    $watchlist = (new Watchlist())
        ->setDisplayName($watchlistDisplayName)
        ->setEntityPopulationMechanism($watchlistEntityPopulationMechanism);
    $request = (new CreateWatchlistRequest())
        ->setParent($formattedParent)
        ->setWatchlist($watchlist);

    // Call the API and handle any network failures.
    try {
        /** @var Watchlist $response */
        $response = $entityServiceClient->createWatchlist($request);
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
    $formattedParent = EntityServiceClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $watchlistDisplayName = '[DISPLAY_NAME]';

    create_watchlist_sample($formattedParent, $watchlistDisplayName);
}
// [END chronicle_v1_generated_EntityService_CreateWatchlist_sync]
