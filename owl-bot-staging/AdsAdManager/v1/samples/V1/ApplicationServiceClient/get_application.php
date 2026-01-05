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

// [START admanager_v1_generated_ApplicationService_GetApplication_sync]
use Google\Ads\AdManager\V1\Application;
use Google\Ads\AdManager\V1\Client\ApplicationServiceClient;
use Google\Ads\AdManager\V1\GetApplicationRequest;
use Google\ApiCore\ApiException;

/**
 * API to retrieve a `Application` object.
 *
 * @param string $formattedName The resource name of the Application.
 *                              Format: `networks/{network_code}/applications/{application_id}`
 *                              Please see {@see ApplicationServiceClient::applicationName()} for help formatting this field.
 */
function get_application_sample(string $formattedName): void
{
    // Create a client.
    $applicationServiceClient = new ApplicationServiceClient();

    // Prepare the request message.
    $request = (new GetApplicationRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Application $response */
        $response = $applicationServiceClient->getApplication($request);
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
    $formattedName = ApplicationServiceClient::applicationName('[NETWORK_CODE]', '[APPLICATION]');

    get_application_sample($formattedName);
}
// [END admanager_v1_generated_ApplicationService_GetApplication_sync]
