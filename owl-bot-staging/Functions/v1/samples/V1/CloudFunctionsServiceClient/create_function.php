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

// [START cloudfunctions_v1_generated_CloudFunctionsService_CreateFunction_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Functions\V1\CloudFunction;
use Google\Cloud\Functions\V1\CloudFunctionsServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new function. If a function with the given name already exists in
 * the specified project, the long running operation will return
 * `ALREADY_EXISTS` error.
 *
 * @param string $formattedLocation The project and location in which the function should be created, specified
 *                                  in the format `projects/&#42;/locations/*`
 *                                  Please see {@see CloudFunctionsServiceClient::locationName()} for help formatting this field.
 */
function create_function_sample(string $formattedLocation): void
{
    // Create a client.
    $cloudFunctionsServiceClient = new CloudFunctionsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $function = new CloudFunction();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudFunctionsServiceClient->createFunction($formattedLocation, $function);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CloudFunction $result */
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
    $formattedLocation = CloudFunctionsServiceClient::locationName('[PROJECT]', '[LOCATION]');

    create_function_sample($formattedLocation);
}
// [END cloudfunctions_v1_generated_CloudFunctionsService_CreateFunction_sync]
