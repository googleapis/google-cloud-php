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

// [START merchantapi_v1_generated_EmailPreferencesService_GetEmailPreferences_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\Client\EmailPreferencesServiceClient;
use Google\Shopping\Merchant\Accounts\V1\EmailPreferences;
use Google\Shopping\Merchant\Accounts\V1\GetEmailPreferencesRequest;

/**
 * Returns the email preferences for a Merchant Center account user.
 * This service only permits retrieving and updating email preferences for the
 * authenticated user.
 * Use the name=accounts/&#42;/users/me/emailPreferences alias to get preferences
 * for the authenticated user.
 *
 * @param string $formattedName The name of the `EmailPreferences` resource.
 *                              Format: `accounts/{account}/users/{email}/emailPreferences`
 *                              Please see {@see EmailPreferencesServiceClient::emailPreferencesName()} for help formatting this field.
 */
function get_email_preferences_sample(string $formattedName): void
{
    // Create a client.
    $emailPreferencesServiceClient = new EmailPreferencesServiceClient();

    // Prepare the request message.
    $request = (new GetEmailPreferencesRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var EmailPreferences $response */
        $response = $emailPreferencesServiceClient->getEmailPreferences($request);
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
    $formattedName = EmailPreferencesServiceClient::emailPreferencesName('[ACCOUNT]', '[EMAIL]');

    get_email_preferences_sample($formattedName);
}
// [END merchantapi_v1_generated_EmailPreferencesService_GetEmailPreferences_sync]
