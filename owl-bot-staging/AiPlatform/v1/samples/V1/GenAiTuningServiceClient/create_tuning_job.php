<?php
/*
 * Copyright 2024 Google LLC
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

// [START aiplatform_v1_generated_GenAiTuningService_CreateTuningJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\GenAiTuningServiceClient;
use Google\Cloud\AIPlatform\V1\CreateTuningJobRequest;
use Google\Cloud\AIPlatform\V1\TuningJob;

/**
 * Creates a TuningJob. A created TuningJob right away will be attempted to
 * be run.
 *
 * @param string $formattedParent The resource name of the Location to create the TuningJob in.
 *                                Format: `projects/{project}/locations/{location}`
 *                                Please see {@see GenAiTuningServiceClient::locationName()} for help formatting this field.
 */
function create_tuning_job_sample(string $formattedParent): void
{
    // Create a client.
    $genAiTuningServiceClient = new GenAiTuningServiceClient();

    // Prepare the request message.
    $tuningJob = new TuningJob();
    $request = (new CreateTuningJobRequest())
        ->setParent($formattedParent)
        ->setTuningJob($tuningJob);

    // Call the API and handle any network failures.
    try {
        /** @var TuningJob $response */
        $response = $genAiTuningServiceClient->createTuningJob($request);
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
    $formattedParent = GenAiTuningServiceClient::locationName('[PROJECT]', '[LOCATION]');

    create_tuning_job_sample($formattedParent);
}
// [END aiplatform_v1_generated_GenAiTuningService_CreateTuningJob_sync]
