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

// [START transcoder_v1_generated_TranscoderService_CreateJobTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Video\Transcoder\V1\JobTemplate;
use Google\Cloud\Video\Transcoder\V1\TranscoderServiceClient;

/**
 * Creates a job template in the specified region.
 *
 * @param string $formattedParent The parent location to create this job template.
 *                                Format: `projects/{project}/locations/{location}`
 *                                Please see {@see TranscoderServiceClient::locationName()} for help formatting this field.
 * @param string $jobTemplateId   The ID to use for the job template, which will become the final
 *                                component of the job template's resource name.
 *
 *                                This value should be 4-63 characters, and valid characters must match the
 *                                regular expression `[a-zA-Z][a-zA-Z0-9_-]*`.
 */
function create_job_template_sample(string $formattedParent, string $jobTemplateId): void
{
    // Create a client.
    $transcoderServiceClient = new TranscoderServiceClient();

    // Prepare the request message.
    $jobTemplate = new JobTemplate();

    // Call the API and handle any network failures.
    try {
        /** @var JobTemplate $response */
        $response = $transcoderServiceClient->createJobTemplate(
            $formattedParent,
            $jobTemplate,
            $jobTemplateId
        );
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
    $formattedParent = TranscoderServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $jobTemplateId = '[JOB_TEMPLATE_ID]';

    create_job_template_sample($formattedParent, $jobTemplateId);
}
// [END transcoder_v1_generated_TranscoderService_CreateJobTemplate_sync]
