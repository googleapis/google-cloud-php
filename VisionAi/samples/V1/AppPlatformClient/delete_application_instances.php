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

// [START visionai_v1_generated_AppPlatform_DeleteApplicationInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\AppPlatformClient;
use Google\Cloud\VisionAI\V1\Instance;
use Google\Rpc\Status;

/**
 * Remove target stream input to the Application, if the Application is
 * deployed, the corresponding instance based will be deleted. If the stream
 * is not in the Application, the RPC will fail.
 *
 * @param string $formattedName               the name of the application to retrieve.
 *                                            Format:
 *                                            "projects/{project}/locations/{location}/applications/{application}"
 *                                            Please see {@see AppPlatformClient::applicationName()} for help formatting this field.
 * @param string $formattedInstanceIdsElement Id of the requesting object. Please see
 *                                            {@see AppPlatformClient::instanceName()} for help formatting this field.
 */
function delete_application_instances_sample(
    string $formattedName,
    string $formattedInstanceIdsElement
): void {
    // Create a client.
    $appPlatformClient = new AppPlatformClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedInstanceIds = [$formattedInstanceIdsElement,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appPlatformClient->deleteApplicationInstances($formattedName, $formattedInstanceIds);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedName = AppPlatformClient::applicationName('[PROJECT]', '[LOCATION]', '[APPLICATION]');
    $formattedInstanceIdsElement = AppPlatformClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[APPLICATION]',
        '[INSTANCE]'
    );

    delete_application_instances_sample($formattedName, $formattedInstanceIdsElement);
}
// [END visionai_v1_generated_AppPlatform_DeleteApplicationInstances_sync]
