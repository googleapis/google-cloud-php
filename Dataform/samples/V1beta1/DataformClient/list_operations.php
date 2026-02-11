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

// [START dataform_v1beta1_generated_Dataform_ListOperations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\Operation;

/**
 * Lists operations that match the specified filter in the request. If the
 * server doesn't support this method, it returns `UNIMPLEMENTED`.
 *
 * @param string $name   The name of the operation's parent resource.
 * @param string $filter The standard list filter.
 */
function list_operations_sample(string $name, string $filter): void
{
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $request = (new ListOperationsRequest())
        ->setName($name)
        ->setFilter($filter);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataformClient->listOperations($request);

        /** @var Operation $element */
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
    $name = '[NAME]';
    $filter = '[FILTER]';

    list_operations_sample($name, $filter);
}
// [END dataform_v1beta1_generated_Dataform_ListOperations_sync]
