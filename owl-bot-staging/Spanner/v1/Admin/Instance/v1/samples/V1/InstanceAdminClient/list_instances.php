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

// [START spanner_v1_generated_InstanceAdmin_ListInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;

/**
 * Lists all instances in the given project.
 *
 * @param string $formattedParent The name of the project for which a list of instances is
 *                                requested. Values are of the form `projects/<project>`. Please see
 *                                {@see InstanceAdminClient::projectName()} for help formatting this field.
 */
function list_instances_sample(string $formattedParent): void
{
    // Create a client.
    $instanceAdminClient = new InstanceAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $instanceAdminClient->listInstances($formattedParent);

        /** @var Instance $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = InstanceAdminClient::projectName('[PROJECT]');

    list_instances_sample($formattedParent);
}
// [END spanner_v1_generated_InstanceAdmin_ListInstances_sync]
