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

// [START discoveryengine_v1beta_generated_GroundedGenerationService_CheckGrounding_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1beta\CheckGroundingRequest;
use Google\Cloud\DiscoveryEngine\V1beta\CheckGroundingResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\GroundedGenerationServiceClient;

/**
 * Performs a grounding check.
 *
 * @param string $formattedGroundingConfig The resource name of the grounding config, such as
 *                                         `projects/&#42;/locations/global/groundingConfigs/default_grounding_config`. Please see
 *                                         {@see GroundedGenerationServiceClient::groundingConfigName()} for help formatting this field.
 */
function check_grounding_sample(string $formattedGroundingConfig): void
{
    // Create a client.
    $groundedGenerationServiceClient = new GroundedGenerationServiceClient();

    // Prepare the request message.
    $request = (new CheckGroundingRequest())
        ->setGroundingConfig($formattedGroundingConfig);

    // Call the API and handle any network failures.
    try {
        /** @var CheckGroundingResponse $response */
        $response = $groundedGenerationServiceClient->checkGrounding($request);
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
    $formattedGroundingConfig = GroundedGenerationServiceClient::groundingConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[GROUNDING_CONFIG]'
    );

    check_grounding_sample($formattedGroundingConfig);
}
// [END discoveryengine_v1beta_generated_GroundedGenerationService_CheckGrounding_sync]
