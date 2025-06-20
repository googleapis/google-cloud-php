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

// [START parametermanager_v1_generated_ParameterManager_GetParameterVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ParameterManager\V1\Client\ParameterManagerClient;
use Google\Cloud\ParameterManager\V1\GetParameterVersionRequest;
use Google\Cloud\ParameterManager\V1\ParameterVersion;

/**
 * Gets details of a single ParameterVersion.
 *
 * @param string $formattedName Name of the resource in the format
 *                              `projects/&#42;/locations/&#42;/parameters/&#42;/versions/*`. Please see
 *                              {@see ParameterManagerClient::parameterVersionName()} for help formatting this field.
 */
function get_parameter_version_sample(string $formattedName): void
{
    // Create a client.
    $parameterManagerClient = new ParameterManagerClient();

    // Prepare the request message.
    $request = (new GetParameterVersionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ParameterVersion $response */
        $response = $parameterManagerClient->getParameterVersion($request);
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
    $formattedName = ParameterManagerClient::parameterVersionName(
        '[PROJECT]',
        '[LOCATION]',
        '[PARAMETER]',
        '[PARAMETER_VERSION]'
    );

    get_parameter_version_sample($formattedName);
}
// [END parametermanager_v1_generated_ParameterManager_GetParameterVersion_sync]
