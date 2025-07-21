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

// [START dataform_v1_generated_Dataform_ListRepositories_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dataform\V1\Client\DataformClient;
use Google\Cloud\Dataform\V1\ListRepositoriesRequest;
use Google\Cloud\Dataform\V1\Repository;

/**
 * Lists Repositories in a given project and location.
 *
 * **Note:** *This method can return repositories not shown in the [Dataform
 * UI](https://console.cloud.google.com/bigquery/dataform)*.
 *
 * @param string $formattedParent The location in which to list repositories. Must be in the format
 *                                `projects/&#42;/locations/*`. Please see
 *                                {@see DataformClient::locationName()} for help formatting this field.
 */
function list_repositories_sample(string $formattedParent): void
{
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $request = (new ListRepositoriesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataformClient->listRepositories($request);

        /** @var Repository $element */
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
    $formattedParent = DataformClient::locationName('[PROJECT]', '[LOCATION]');

    list_repositories_sample($formattedParent);
}
// [END dataform_v1_generated_Dataform_ListRepositories_sync]
