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

// [START networksecurity_v1_generated_DnsThreatDetectorService_ListDnsThreatDetectors_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\NetworkSecurity\V1\Client\DnsThreatDetectorServiceClient;
use Google\Cloud\NetworkSecurity\V1\DnsThreatDetector;
use Google\Cloud\NetworkSecurity\V1\ListDnsThreatDetectorsRequest;

/**
 * Lists DnsThreatDetectors in a given project and location.
 *
 * @param string $formattedParent The parent value for `ListDnsThreatDetectorsRequest`. Please see
 *                                {@see DnsThreatDetectorServiceClient::locationName()} for help formatting this field.
 */
function list_dns_threat_detectors_sample(string $formattedParent): void
{
    // Create a client.
    $dnsThreatDetectorServiceClient = new DnsThreatDetectorServiceClient();

    // Prepare the request message.
    $request = (new ListDnsThreatDetectorsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dnsThreatDetectorServiceClient->listDnsThreatDetectors($request);

        /** @var DnsThreatDetector $element */
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
    $formattedParent = DnsThreatDetectorServiceClient::locationName('[PROJECT]', '[LOCATION]');

    list_dns_threat_detectors_sample($formattedParent);
}
// [END networksecurity_v1_generated_DnsThreatDetectorService_ListDnsThreatDetectors_sync]
