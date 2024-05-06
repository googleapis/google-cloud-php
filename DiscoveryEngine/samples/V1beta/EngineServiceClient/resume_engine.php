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

// [START discoveryengine_v1beta_generated_EngineService_ResumeEngine_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1beta\Client\EngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\Engine;
use Google\Cloud\DiscoveryEngine\V1beta\ResumeEngineRequest;

/**
 * Resumes the training of an existing engine. Only applicable if
 * [SolutionType][google.cloud.discoveryengine.v1beta.SolutionType] is
 * [SOLUTION_TYPE_RECOMMENDATION][google.cloud.discoveryengine.v1beta.SolutionType.SOLUTION_TYPE_RECOMMENDATION].
 *
 * @param string $formattedName The name of the engine to resume.
 *                              Format:
 *                              `projects/{project_number}/locations/{location_id}/collections/{collection_id}/engines/{engine_id}`
 *                              Please see {@see EngineServiceClient::engineName()} for help formatting this field.
 */
function resume_engine_sample(string $formattedName): void
{
    // Create a client.
    $engineServiceClient = new EngineServiceClient();

    // Prepare the request message.
    $request = (new ResumeEngineRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Engine $response */
        $response = $engineServiceClient->resumeEngine($request);
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
    $formattedName = EngineServiceClient::engineName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]',
        '[ENGINE]'
    );

    resume_engine_sample($formattedName);
}
// [END discoveryengine_v1beta_generated_EngineService_ResumeEngine_sync]
