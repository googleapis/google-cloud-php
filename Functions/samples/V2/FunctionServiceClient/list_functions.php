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

// [START cloudfunctions_v2_generated_FunctionService_ListFunctions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Functions\V2\FunctionServiceClient;
use Google\Cloud\Functions\V2\PBFunction;

/**
 * Returns a list of functions that belong to the requested project.
 *
 * @param string $formattedParent The project and location from which the function should be listed,
 *                                specified in the format `projects/&#42;/locations/*`
 *                                If you want to list functions in all locations, use "-" in place of a
 *                                location. When listing functions in all locations, if one or more
 *                                location(s) are unreachable, the response will contain functions from all
 *                                reachable locations along with the names of any unreachable locations. Please see
 *                                {@see FunctionServiceClient::locationName()} for help formatting this field.
 */
function list_functions_sample(string $formattedParent): void
{
    // Create a client.
    $functionServiceClient = new FunctionServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $functionServiceClient->listFunctions($formattedParent);

        /** @var PBFunction $element */
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
    $formattedParent = FunctionServiceClient::locationName('[PROJECT]', '[LOCATION]');

    list_functions_sample($formattedParent);
}
// [END cloudfunctions_v2_generated_FunctionService_ListFunctions_sync]
