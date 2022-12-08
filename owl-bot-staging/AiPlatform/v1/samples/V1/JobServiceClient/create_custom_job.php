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

// [START aiplatform_v1_generated_JobService_CreateCustomJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\CustomJob;
use Google\Cloud\AIPlatform\V1\CustomJobSpec;
use Google\Cloud\AIPlatform\V1\JobServiceClient;
use Google\Cloud\AIPlatform\V1\WorkerPoolSpec;

/**
 * Creates a CustomJob. A created CustomJob right away
 * will be attempted to be run.
 *
 * @param string $formattedParent      The resource name of the Location to create the CustomJob in.
 *                                     Format: `projects/{project}/locations/{location}`
 *                                     Please see {@see JobServiceClient::locationName()} for help formatting this field.
 * @param string $customJobDisplayName The display name of the CustomJob.
 *                                     The name can be up to 128 characters long and can consist of any UTF-8
 *                                     characters.
 */
function create_custom_job_sample(string $formattedParent, string $customJobDisplayName): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $customJobJobSpecWorkerPoolSpecs = [new WorkerPoolSpec()];
    $customJobJobSpec = (new CustomJobSpec())
        ->setWorkerPoolSpecs($customJobJobSpecWorkerPoolSpecs);
    $customJob = (new CustomJob())
        ->setDisplayName($customJobDisplayName)
        ->setJobSpec($customJobJobSpec);

    // Call the API and handle any network failures.
    try {
        /** @var CustomJob $response */
        $response = $jobServiceClient->createCustomJob($formattedParent, $customJob);
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
    $formattedParent = JobServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $customJobDisplayName = '[DISPLAY_NAME]';

    create_custom_job_sample($formattedParent, $customJobDisplayName);
}
// [END aiplatform_v1_generated_JobService_CreateCustomJob_sync]
