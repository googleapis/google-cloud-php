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

// [START ces_v1_generated_AgentService_CreateApp_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Ces\V1\App;
use Google\Cloud\Ces\V1\Client\AgentServiceClient;
use Google\Cloud\Ces\V1\CreateAppRequest;
use Google\Rpc\Status;

/**
 * Creates a new app in the given project and location.
 *
 * @param string $formattedParent The resource name of the location to create an app in. Please see
 *                                {@see AgentServiceClient::locationName()} for help formatting this field.
 * @param string $appDisplayName  Display name of the app.
 */
function create_app_sample(string $formattedParent, string $appDisplayName): void
{
    // Create a client.
    $agentServiceClient = new AgentServiceClient();

    // Prepare the request message.
    $app = (new App())
        ->setDisplayName($appDisplayName);
    $request = (new CreateAppRequest())
        ->setParent($formattedParent)
        ->setApp($app);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $agentServiceClient->createApp($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var App $result */
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
    $formattedParent = AgentServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $appDisplayName = '[DISPLAY_NAME]';

    create_app_sample($formattedParent, $appDisplayName);
}
// [END ces_v1_generated_AgentService_CreateApp_sync]
