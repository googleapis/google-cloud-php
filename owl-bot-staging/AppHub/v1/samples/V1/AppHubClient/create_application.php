<?php
/*
 * Copyright 2024 Google LLC
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

// [START apphub_v1_generated_AppHub_CreateApplication_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppHub\V1\Application;
use Google\Cloud\AppHub\V1\Client\AppHubClient;
use Google\Cloud\AppHub\V1\CreateApplicationRequest;
use Google\Cloud\AppHub\V1\Scope;
use Google\Cloud\AppHub\V1\Scope\Type;
use Google\Rpc\Status;

/**
 * Creates an Application in a host project and location.
 *
 * @param string $formattedParent      Project and location to create Application in.
 *                                     Expected format: `projects/{project}/locations/{location}`. Please see
 *                                     {@see AppHubClient::locationName()} for help formatting this field.
 * @param string $applicationId        The Application identifier.
 *                                     Must contain only lowercase letters, numbers
 *                                     or hyphens, with the first character a letter, the last a letter or a
 *                                     number, and a 63 character maximum.
 * @param int    $applicationScopeType Scope Type.
 */
function create_application_sample(
    string $formattedParent,
    string $applicationId,
    int $applicationScopeType
): void {
    // Create a client.
    $appHubClient = new AppHubClient();

    // Prepare the request message.
    $applicationScope = (new Scope())
        ->setType($applicationScopeType);
    $application = (new Application())
        ->setScope($applicationScope);
    $request = (new CreateApplicationRequest())
        ->setParent($formattedParent)
        ->setApplicationId($applicationId)
        ->setApplication($application);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appHubClient->createApplication($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Application $result */
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
    $formattedParent = AppHubClient::locationName('[PROJECT]', '[LOCATION]');
    $applicationId = '[APPLICATION_ID]';
    $applicationScopeType = Type::TYPE_UNSPECIFIED;

    create_application_sample($formattedParent, $applicationId, $applicationScopeType);
}
// [END apphub_v1_generated_AppHub_CreateApplication_sync]
