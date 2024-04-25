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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_MigrateKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Key;
use Google\Cloud\RecaptchaEnterprise\V1\MigrateKeyRequest;

/**
 * Migrates an existing key from reCAPTCHA to reCAPTCHA Enterprise.
 * Once a key is migrated, it can be used from either product. SiteVerify
 * requests are billed as CreateAssessment calls. You must be
 * authenticated as one of the current owners of the reCAPTCHA Key, and
 * your user must have the reCAPTCHA Enterprise Admin IAM role in the
 * destination project.
 *
 * @param string $formattedName The name of the key to be migrated, in the format
 *                              `projects/{project}/keys/{key}`. Please see
 *                              {@see RecaptchaEnterpriseServiceClient::keyName()} for help formatting this field.
 */
function migrate_key_sample(string $formattedName): void
{
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $request = (new MigrateKeyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Key $response */
        $response = $recaptchaEnterpriseServiceClient->migrateKey($request);
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
    $formattedName = RecaptchaEnterpriseServiceClient::keyName('[PROJECT]', '[KEY]');

    migrate_key_sample($formattedName);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_MigrateKey_sync]
