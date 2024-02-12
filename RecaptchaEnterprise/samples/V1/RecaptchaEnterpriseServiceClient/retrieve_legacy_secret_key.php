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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_RetrieveLegacySecretKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\RetrieveLegacySecretKeyRequest;
use Google\Cloud\RecaptchaEnterprise\V1\RetrieveLegacySecretKeyResponse;

/**
 * Returns the secret key related to the specified public key.
 * You must use the legacy secret key only in a 3rd party integration with
 * legacy reCAPTCHA.
 *
 * @param string $formattedKey The public key name linked to the requested secret key in the
 *                             format `projects/{project}/keys/{key}`. Please see
 *                             {@see RecaptchaEnterpriseServiceClient::keyName()} for help formatting this field.
 */
function retrieve_legacy_secret_key_sample(string $formattedKey): void
{
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $request = (new RetrieveLegacySecretKeyRequest())
        ->setKey($formattedKey);

    // Call the API and handle any network failures.
    try {
        /** @var RetrieveLegacySecretKeyResponse $response */
        $response = $recaptchaEnterpriseServiceClient->retrieveLegacySecretKey($request);
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
    $formattedKey = RecaptchaEnterpriseServiceClient::keyName('[PROJECT]', '[KEY]');

    retrieve_legacy_secret_key_sample($formattedKey);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_RetrieveLegacySecretKey_sync]
