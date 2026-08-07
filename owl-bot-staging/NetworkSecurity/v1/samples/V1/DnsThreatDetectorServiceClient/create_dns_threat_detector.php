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

// [START networksecurity_v1_generated_DnsThreatDetectorService_CreateDnsThreatDetector_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkSecurity\V1\Client\DnsThreatDetectorServiceClient;
use Google\Cloud\NetworkSecurity\V1\CreateDnsThreatDetectorRequest;
use Google\Cloud\NetworkSecurity\V1\DnsThreatDetector;
use Google\Cloud\NetworkSecurity\V1\DnsThreatDetector\Provider;

/**
 * Creates a new DnsThreatDetector in a given project and location.
 *
 * @param string $formattedParent           The value for the parent of the DnsThreatDetector resource. Please see
 *                                          {@see DnsThreatDetectorServiceClient::locationName()} for help formatting this field.
 * @param int    $dnsThreatDetectorProvider The provider used for DNS threat analysis.
 */
function create_dns_threat_detector_sample(
    string $formattedParent,
    int $dnsThreatDetectorProvider
): void {
    // Create a client.
    $dnsThreatDetectorServiceClient = new DnsThreatDetectorServiceClient();

    // Prepare the request message.
    $dnsThreatDetector = (new DnsThreatDetector())
        ->setProvider($dnsThreatDetectorProvider);
    $request = (new CreateDnsThreatDetectorRequest())
        ->setParent($formattedParent)
        ->setDnsThreatDetector($dnsThreatDetector);

    // Call the API and handle any network failures.
    try {
        /** @var DnsThreatDetector $response */
        $response = $dnsThreatDetectorServiceClient->createDnsThreatDetector($request);
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
    $formattedParent = DnsThreatDetectorServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $dnsThreatDetectorProvider = Provider::PROVIDER_UNSPECIFIED;

    create_dns_threat_detector_sample($formattedParent, $dnsThreatDetectorProvider);
}
// [END networksecurity_v1_generated_DnsThreatDetectorService_CreateDnsThreatDetector_sync]
