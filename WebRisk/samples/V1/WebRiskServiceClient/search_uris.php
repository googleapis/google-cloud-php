<?php
/*
 * Copyright 2022 Google LLC
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

// [START webrisk_v1_generated_WebRiskService_SearchUris_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\WebRisk\V1\SearchUrisResponse;
use Google\Cloud\WebRisk\V1\ThreatType;
use Google\Cloud\WebRisk\V1\WebRiskServiceClient;

/**
 * This method is used to check whether a URI is on a given threatList.
 * Multiple threatLists may be searched in a single query.
 * The response will list all requested threatLists the URI was found to
 * match. If the URI is not found on any of the requested ThreatList an
 * empty response will be returned.
 *
 * @param string $uri                The URI to be checked for matches.
 * @param int    $threatTypesElement The ThreatLists to search in. Multiple ThreatLists may be specified.
 */
function search_uris_sample(string $uri, int $threatTypesElement): void
{
    // Create a client.
    $webRiskServiceClient = new WebRiskServiceClient();

    // Prepare the request message.
    $threatTypes = [$threatTypesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var SearchUrisResponse $response */
        $response = $webRiskServiceClient->searchUris($uri, $threatTypes);
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
    $uri = '[URI]';
    $threatTypesElement = ThreatType::THREAT_TYPE_UNSPECIFIED;

    search_uris_sample($uri, $threatTypesElement);
}
// [END webrisk_v1_generated_WebRiskService_SearchUris_sync]
