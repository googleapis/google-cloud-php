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

// [START discoveryengine_v1_generated_ServingConfigService_CreateServingConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\ServingConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateServingConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\ServingConfig;
use Google\Cloud\DiscoveryEngine\V1\SolutionType;

/**
 * Creates a ServingConfig.
 *
 * Note: The Google Cloud console works only with the default serving config.
 * Additional ServingConfigs can be created and managed only via the API.
 *
 * A maximum of 100
 * [ServingConfig][google.cloud.discoveryengine.v1.ServingConfig]s are allowed
 * in an [Engine][google.cloud.discoveryengine.v1.Engine], otherwise a
 * RESOURCE_EXHAUSTED error is returned.
 *
 * @param string $formattedParent           Full resource name of parent. Format:
 *                                          `projects/{project}/locations/{location}/collections/{collection}/engines/{engine}`
 *                                          Please see {@see ServingConfigServiceClient::dataStoreName()} for help formatting this field.
 * @param string $servingConfigDisplayName  The human readable serving config display name. Used in Discovery
 *                                          UI.
 *
 *                                          This field must be a UTF-8 encoded string with a length limit of 128
 *                                          characters. Otherwise, an INVALID_ARGUMENT error is returned.
 * @param int    $servingConfigSolutionType Immutable. Specifies the solution type that a serving config can
 *                                          be associated with.
 * @param string $servingConfigId           The ID to use for the ServingConfig, which will become the final
 *                                          component of the ServingConfig's resource name.
 *
 *                                          This value should be 4-63 characters, and valid characters
 *                                          are /[a-zA-Z0-9][a-zA-Z0-9_-]+/.
 */
function create_serving_config_sample(
    string $formattedParent,
    string $servingConfigDisplayName,
    int $servingConfigSolutionType,
    string $servingConfigId
): void {
    // Create a client.
    $servingConfigServiceClient = new ServingConfigServiceClient();

    // Prepare the request message.
    $servingConfig = (new ServingConfig())
        ->setDisplayName($servingConfigDisplayName)
        ->setSolutionType($servingConfigSolutionType);
    $request = (new CreateServingConfigRequest())
        ->setParent($formattedParent)
        ->setServingConfig($servingConfig)
        ->setServingConfigId($servingConfigId);

    // Call the API and handle any network failures.
    try {
        /** @var ServingConfig $response */
        $response = $servingConfigServiceClient->createServingConfig($request);
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
    $formattedParent = ServingConfigServiceClient::dataStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );
    $servingConfigDisplayName = '[DISPLAY_NAME]';
    $servingConfigSolutionType = SolutionType::SOLUTION_TYPE_UNSPECIFIED;
    $servingConfigId = '[SERVING_CONFIG_ID]';

    create_serving_config_sample(
        $formattedParent,
        $servingConfigDisplayName,
        $servingConfigSolutionType,
        $servingConfigId
    );
}
// [END discoveryengine_v1_generated_ServingConfigService_CreateServingConfig_sync]
