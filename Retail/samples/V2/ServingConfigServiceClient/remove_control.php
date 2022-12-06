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

// [START retail_v2_generated_ServingConfigService_RemoveControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\ServingConfig;
use Google\Cloud\Retail\V2\ServingConfigServiceClient;

/**
 * Disables a Control on the specified ServingConfig.
 * The control is removed from the ServingConfig.
 * Returns a NOT_FOUND error if the Control is not enabled for the
 * ServingConfig.
 *
 * @param string $formattedServingConfig The source ServingConfig resource name . Format:
 *                                       projects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/servingConfigs/{serving_config_id}
 *                                       Please see {@see ServingConfigServiceClient::servingConfigName()} for help formatting this field.
 * @param string $controlId              The id of the control to apply. Assumed to be in the same catalog
 *                                       as the serving config.
 */
function remove_control_sample(string $formattedServingConfig, string $controlId): void
{
    // Create a client.
    $servingConfigServiceClient = new ServingConfigServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ServingConfig $response */
        $response = $servingConfigServiceClient->removeControl($formattedServingConfig, $controlId);
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
    $formattedServingConfig = ServingConfigServiceClient::servingConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[SERVING_CONFIG]'
    );
    $controlId = '[CONTROL_ID]';

    remove_control_sample($formattedServingConfig, $controlId);
}
// [END retail_v2_generated_ServingConfigService_RemoveControl_sync]
