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

// [START bigtableadmin_v2_generated_BigtableInstanceAdmin_UpdateInstance_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance\Type;

/**
 * Updates an instance within a project. This method updates only the display
 * name and type for an Instance. To update other Instance properties, such as
 * labels, use PartialUpdateInstance.
 *
 * @param string $name        The unique name of the instance. Values are of the form
 *                            `projects/{project}/instances/[a-z][a-z0-9\\-]+[a-z0-9]`.
 * @param string $displayName The descriptive name for this instance as it appears in UIs.
 *                            Can be changed at any time, but should be kept globally unique
 *                            to avoid confusion.
 * @param int    $type        The type of the instance. Defaults to `PRODUCTION`.
 */
function update_instance_sample(string $name, string $displayName, int $type): void
{
    // Create a client.
    $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();

    // Prepare the request message.
    $labels = [];
    $request = (new Instance())
        ->setName($name)
        ->setDisplayName($displayName)
        ->setType($type)
        ->setLabels($labels);

    // Call the API and handle any network failures.
    try {
        /** @var Instance $response */
        $response = $bigtableInstanceAdminClient->updateInstance($request);
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
    $name = '[NAME]';
    $displayName = '[DISPLAY_NAME]';
    $type = Type::TYPE_UNSPECIFIED;

    update_instance_sample($name, $displayName, $type);
}
// [END bigtableadmin_v2_generated_BigtableInstanceAdmin_UpdateInstance_sync]
