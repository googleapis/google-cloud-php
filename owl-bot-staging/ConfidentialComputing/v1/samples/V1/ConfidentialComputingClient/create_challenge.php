<?php
/*
 * Copyright 2023 Google LLC
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

// [START confidentialcomputing_v1_generated_ConfidentialComputing_CreateChallenge_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ConfidentialComputing\V1\Challenge;
use Google\Cloud\ConfidentialComputing\V1\Client\ConfidentialComputingClient;
use Google\Cloud\ConfidentialComputing\V1\CreateChallengeRequest;

/**
 * Creates a new Challenge in a given project and location.
 *
 * @param string $formattedParent The resource name of the location where the Challenge will be
 *                                used, in the format `projects/&#42;/locations/*`. Please see
 *                                {@see ConfidentialComputingClient::locationName()} for help formatting this field.
 */
function create_challenge_sample(string $formattedParent): void
{
    // Create a client.
    $confidentialComputingClient = new ConfidentialComputingClient();

    // Prepare the request message.
    $challenge = new Challenge();
    $request = (new CreateChallengeRequest())
        ->setParent($formattedParent)
        ->setChallenge($challenge);

    // Call the API and handle any network failures.
    try {
        /** @var Challenge $response */
        $response = $confidentialComputingClient->createChallenge($request);
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
    $formattedParent = ConfidentialComputingClient::locationName('[PROJECT]', '[LOCATION]');

    create_challenge_sample($formattedParent);
}
// [END confidentialcomputing_v1_generated_ConfidentialComputing_CreateChallenge_sync]
