<?php
/*
 * Copyright 2022 Google LLC
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

// [START domains_v1beta1_generated_Domains_ResetAuthorizationCode_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Domains\V1beta1\AuthorizationCode;
use Google\Cloud\Domains\V1beta1\DomainsClient;

/**
 * Resets the authorization code of the `Registration` to a new random string.
 *
 * You can call this method only after 60 days have elapsed since the initial
 * domain registration.
 *
 * @param string $formattedRegistration The name of the `Registration` whose authorization code is being reset,
 *                                      in the format `projects/&#42;/locations/&#42;/registrations/*`. Please see
 *                                      {@see DomainsClient::registrationName()} for help formatting this field.
 */
function reset_authorization_code_sample(string $formattedRegistration): void
{
    // Create a client.
    $domainsClient = new DomainsClient();

    // Call the API and handle any network failures.
    try {
        /** @var AuthorizationCode $response */
        $response = $domainsClient->resetAuthorizationCode($formattedRegistration);
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
    $formattedRegistration = DomainsClient::registrationName(
        '[PROJECT]',
        '[LOCATION]',
        '[REGISTRATION]'
    );

    reset_authorization_code_sample($formattedRegistration);
}
// [END domains_v1beta1_generated_Domains_ResetAuthorizationCode_sync]
