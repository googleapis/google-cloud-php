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

// [START dataform_v1beta1_generated_Dataform_UpdateConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;
use Google\Cloud\Dataform\V1beta1\Config;
use Google\Cloud\Dataform\V1beta1\UpdateConfigRequest;

/**
 * Update default config for a given project and location.
 *
 * **Note:** This method does not fully implement
 * [AIP-134](https://google.aip.dev/134); in particular:
 * - The wildcard entry (**\***) is treated as a bad request
 * - When the **field_mask** is omitted, instead of only updating the set
 * fields, the request is treated as a full update on all modifiable fields
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_config_sample(): void
{
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $config = new Config();
    $request = (new UpdateConfigRequest())
        ->setConfig($config);

    // Call the API and handle any network failures.
    try {
        /** @var Config $response */
        $response = $dataformClient->updateConfig($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END dataform_v1beta1_generated_Dataform_UpdateConfig_sync]
