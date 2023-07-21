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

// [START aiplatform_v1_generated_VizierService_CreateTrial_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\VizierServiceClient;
use Google\Cloud\AIPlatform\V1\CreateTrialRequest;
use Google\Cloud\AIPlatform\V1\Trial;

/**
 * Adds a user provided Trial to a Study.
 *
 * @param string $formattedParent The resource name of the Study to create the Trial in.
 *                                Format: `projects/{project}/locations/{location}/studies/{study}`
 *                                Please see {@see VizierServiceClient::studyName()} for help formatting this field.
 */
function create_trial_sample(string $formattedParent): void
{
    // Create a client.
    $vizierServiceClient = new VizierServiceClient();

    // Prepare the request message.
    $trial = new Trial();
    $request = (new CreateTrialRequest())
        ->setParent($formattedParent)
        ->setTrial($trial);

    // Call the API and handle any network failures.
    try {
        /** @var Trial $response */
        $response = $vizierServiceClient->createTrial($request);
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
    $formattedParent = VizierServiceClient::studyName('[PROJECT]', '[LOCATION]', '[STUDY]');

    create_trial_sample($formattedParent);
}
// [END aiplatform_v1_generated_VizierService_CreateTrial_sync]
