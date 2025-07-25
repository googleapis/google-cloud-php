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

// [START lustre_v1_generated_Lustre_ImportData_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Lustre\V1\Client\LustreClient;
use Google\Cloud\Lustre\V1\ImportDataRequest;
use Google\Cloud\Lustre\V1\ImportDataResponse;
use Google\Rpc\Status;

/**
 * Imports data from Cloud Storage to a Managed Lustre instance.
 *
 * @param string $formattedName The name of the Managed Lustre instance in the format
 *                              `projects/{project}/locations/{location}/instances/{instance}`. Please see
 *                              {@see LustreClient::instanceName()} for help formatting this field.
 */
function import_data_sample(string $formattedName): void
{
    // Create a client.
    $lustreClient = new LustreClient();

    // Prepare the request message.
    $request = (new ImportDataRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $lustreClient->importData($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportDataResponse $result */
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
    $formattedName = LustreClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');

    import_data_sample($formattedName);
}
// [END lustre_v1_generated_Lustre_ImportData_sync]
