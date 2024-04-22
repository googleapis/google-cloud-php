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

// [START webrisk_v1_generated_WebRiskService_SearchHashes_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\WebRisk\V1\Client\WebRiskServiceClient;
use Google\Cloud\WebRisk\V1\SearchHashesRequest;
use Google\Cloud\WebRisk\V1\SearchHashesResponse;
use Google\Cloud\WebRisk\V1\ThreatType;

/**
 * Gets the full hashes that match the requested hash prefix.
 * This is used after a hash prefix is looked up in a threatList
 * and there is a match. The client side threatList only holds partial hashes
 * so the client must query this method to determine if there is a full
 * hash match of a threat.
 *
 * @param int $threatTypesElement The ThreatLists to search in. Multiple ThreatLists may be
 *                                specified.
 */
function search_hashes_sample(int $threatTypesElement): void
{
    // Create a client.
    $webRiskServiceClient = new WebRiskServiceClient();

    // Prepare the request message.
    $threatTypes = [$threatTypesElement,];
    $request = (new SearchHashesRequest())
        ->setThreatTypes($threatTypes);

    // Call the API and handle any network failures.
    try {
        /** @var SearchHashesResponse $response */
        $response = $webRiskServiceClient->searchHashes($request);
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
    $threatTypesElement = ThreatType::THREAT_TYPE_UNSPECIFIED;

    search_hashes_sample($threatTypesElement);
}
// [END webrisk_v1_generated_WebRiskService_SearchHashes_sync]
