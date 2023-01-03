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

// [START cloudfunctions_v1_generated_CloudFunctionsService_DeleteFunction_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Functions\V1\CloudFunctionsServiceClient;
use Google\Rpc\Status;

/**
 * Deletes a function with the given name from the specified project. If the
 * given function is used by some trigger, the trigger will be updated to
 * remove this function.
 *
 * @param string $formattedName The name of the function which should be deleted. Please see
 *                              {@see CloudFunctionsServiceClient::cloudFunctionName()} for help formatting this field.
 */
function delete_function_sample(string $formattedName): void
{
    // Create a client.
    $cloudFunctionsServiceClient = new CloudFunctionsServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudFunctionsServiceClient->deleteFunction($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = CloudFunctionsServiceClient::cloudFunctionName(
        '[PROJECT]',
        '[LOCATION]',
        '[FUNCTION]'
    );

    delete_function_sample($formattedName);
}
// [END cloudfunctions_v1_generated_CloudFunctionsService_DeleteFunction_sync]
