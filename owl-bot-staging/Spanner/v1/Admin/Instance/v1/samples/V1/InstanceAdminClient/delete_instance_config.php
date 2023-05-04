<?php
/*
 * Copyright 2023 Google LLC
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

// [START spanner_v1_generated_InstanceAdmin_DeleteInstanceConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;

/**
 * Deletes the instance config. Deletion is only allowed when no
 * instances are using the configuration. If any instances are using
 * the config, returns `FAILED_PRECONDITION`.
 *
 * Only user managed configurations can be deleted.
 *
 * Authorization requires `spanner.instanceConfigs.delete` permission on
 * the resource [name][google.spanner.admin.instance.v1.InstanceConfig.name].
 *
 * @param string $formattedName The name of the instance configuration to be deleted.
 *                              Values are of the form
 *                              `projects/<project>/instanceConfigs/<instance_config>`
 *                              Please see {@see InstanceAdminClient::instanceConfigName()} for help formatting this field.
 */
function delete_instance_config_sample(string $formattedName): void
{
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Call the API and handle any network failures.
    try {
        $instanceAdminClient->deleteInstanceConfig($formattedName);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = InstanceAdminClient::instanceConfigName('[PROJECT]', '[INSTANCE_CONFIG]');

    delete_instance_config_sample($formattedName);
}
// [END spanner_v1_generated_InstanceAdmin_DeleteInstanceConfig_sync]
