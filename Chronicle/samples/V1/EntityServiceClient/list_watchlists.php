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

// [START chronicle_v1_generated_EntityService_ListWatchlists_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Chronicle\V1\Client\EntityServiceClient;
use Google\Cloud\Chronicle\V1\ListWatchlistsRequest;
use Google\Cloud\Chronicle\V1\Watchlist;

/**
 * Lists all watchlists for the given instance.
 *
 * @param string $formattedParent The parent, which owns this collection of watchlists.
 *                                Format: `projects/{project}/locations/{location}/instances/{instance}`
 *                                Please see {@see EntityServiceClient::instanceName()} for help formatting this field.
 */
function list_watchlists_sample(string $formattedParent): void
{
    // Create a client.
    $entityServiceClient = new EntityServiceClient();

    // Prepare the request message.
    $request = (new ListWatchlistsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $entityServiceClient->listWatchlists($request);

        /** @var Watchlist $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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

    list_watchlists_sample($formattedParent);
}
// [END chronicle_v1_generated_EntityService_ListWatchlists_sync]
