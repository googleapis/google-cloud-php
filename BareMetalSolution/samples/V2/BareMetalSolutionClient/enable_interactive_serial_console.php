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

// [START baremetalsolution_v2_generated_BareMetalSolution_EnableInteractiveSerialConsole_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BareMetalSolution\V2\Client\BareMetalSolutionClient;
use Google\Cloud\BareMetalSolution\V2\EnableInteractiveSerialConsoleRequest;
use Google\Cloud\BareMetalSolution\V2\EnableInteractiveSerialConsoleResponse;
use Google\Rpc\Status;

/**
 * Enable the interactive serial console feature on an instance.
 *
 * @param string $formattedName Name of the resource. Please see
 *                              {@see BareMetalSolutionClient::instanceName()} for help formatting this field.
 */
function enable_interactive_serial_console_sample(string $formattedName): void
{
    // Create a client.
    $bareMetalSolutionClient = new BareMetalSolutionClient();

    // Prepare the request message.
    $request = (new EnableInteractiveSerialConsoleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bareMetalSolutionClient->enableInteractiveSerialConsole($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var EnableInteractiveSerialConsoleResponse $result */
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
    $formattedName = BareMetalSolutionClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');

    enable_interactive_serial_console_sample($formattedName);
}
// [END baremetalsolution_v2_generated_BareMetalSolution_EnableInteractiveSerialConsole_sync]
