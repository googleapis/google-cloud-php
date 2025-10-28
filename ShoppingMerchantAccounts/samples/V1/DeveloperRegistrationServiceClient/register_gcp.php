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

// [START merchantapi_v1_generated_DeveloperRegistrationService_RegisterGcp_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Client\DeveloperRegistrationServiceClient;
use Google\Shopping\Merchant\Accounts\V1\DeveloperRegistration;
use Google\Shopping\Merchant\Accounts\V1\RegisterGcpRequest;

/**
 * Registers the GCP used for the API call to the shopping account passed in
 * the request. Will create a user with an "API developer" and add the
 * "developer_email" as a contact with "API notifications" email preference
 * on.
 *
 * @param string $formattedName The name of the developer registration to be created for the
 *                              merchant account that the GCP will be registered with. Format:
 *                              `accounts/{account}/developerRegistration`
 *                              Please see {@see DeveloperRegistrationServiceClient::developerRegistrationName()} for help formatting this field.
 */
function register_gcp_sample(string $formattedName): void
{
    // Create a client.
    $developerRegistrationServiceClient = new DeveloperRegistrationServiceClient();

    // Prepare the request message.
    $request = (new RegisterGcpRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DeveloperRegistration $response */
        $response = $developerRegistrationServiceClient->registerGcp($request);
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
    $formattedName = DeveloperRegistrationServiceClient::developerRegistrationName('[ACCOUNT]');

    register_gcp_sample($formattedName);
}
// [END merchantapi_v1_generated_DeveloperRegistrationService_RegisterGcp_sync]
