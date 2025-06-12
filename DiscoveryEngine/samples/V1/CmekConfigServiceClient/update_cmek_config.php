<?php
/*
 * Copyright 2025 Google LLC
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

// [START discoveryengine_v1_generated_CmekConfigService_UpdateCmekConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\CmekConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CmekConfig;
use Google\Cloud\DiscoveryEngine\V1\UpdateCmekConfigRequest;
use Google\Rpc\Status;

/**
 * Provisions a CMEK key for use in a location of a customer's project.
 * This method will also conduct location validation on the provided
 * cmekConfig to make sure the key is valid and can be used in the
 * selected location.
 *
 * @param string $configName The name of the CmekConfig of the form
 *                           `projects/{project}/locations/{location}/cmekConfig` or
 *                           `projects/{project}/locations/{location}/cmekConfigs/{cmek_config}`.
 */
function update_cmek_config_sample(string $configName): void
{
    // Create a client.
    $cmekConfigServiceClient = new CmekConfigServiceClient();

    // Prepare the request message.
    $config = (new CmekConfig())
        ->setName($configName);
    $request = (new UpdateCmekConfigRequest())
        ->setConfig($config);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cmekConfigServiceClient->updateCmekConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CmekConfig $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $configName = '[NAME]';

    update_cmek_config_sample($configName);
}
// [END discoveryengine_v1_generated_CmekConfigService_UpdateCmekConfig_sync]
