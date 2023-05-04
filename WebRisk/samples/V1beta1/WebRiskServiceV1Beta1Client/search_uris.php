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

// [START webrisk_v1beta1_generated_WebRiskServiceV1Beta1_SearchUris_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\WebRisk\V1beta1\SearchUrisResponse;
use Google\Cloud\WebRisk\V1beta1\ThreatType;
use Google\Cloud\WebRisk\V1beta1\WebRiskServiceV1Beta1Client;

/**
 * This method is used to check whether a URI is on a given threatList.
 *
 * @param string $uri                The URI to be checked for matches.
 * @param int    $threatTypesElement The ThreatLists to search in.
 */
function search_uris_sample(string $uri, int $threatTypesElement): void
{
    // Create a client.
    $webRiskServiceV1Beta1Client = new WebRiskServiceV1Beta1Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $threatTypes = [$threatTypesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var SearchUrisResponse $response */
        $response = $webRiskServiceV1Beta1Client->searchUris($uri, $threatTypes);
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
// [END webrisk_v1beta1_generated_WebRiskServiceV1Beta1_SearchUris_sync]
