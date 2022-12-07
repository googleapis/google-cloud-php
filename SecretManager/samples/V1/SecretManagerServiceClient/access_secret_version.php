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

// [START secretmanager_v1_generated_SecretManagerService_AccessSecretVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecretManager\V1\AccessSecretVersionResponse;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

/**
 * Accesses a [SecretVersion][google.cloud.secretmanager.v1.SecretVersion]. This call returns the secret data.
 *
 * `projects/&#42;/secrets/&#42;/versions/latest` is an alias to the most recently
 * created [SecretVersion][google.cloud.secretmanager.v1.SecretVersion].
 *
 * @param string $formattedName The resource name of the [SecretVersion][google.cloud.secretmanager.v1.SecretVersion] in the format
 *                              `projects/&#42;/secrets/&#42;/versions/*`.
 *
 *                              `projects/&#42;/secrets/&#42;/versions/latest` is an alias to the most recently
 *                              created [SecretVersion][google.cloud.secretmanager.v1.SecretVersion]. Please see
 *                              {@see SecretManagerServiceClient::secretVersionName()} for help formatting this field.
 */
function access_secret_version_sample(string $formattedName): void
{
    // Create a client.
    $secretManagerServiceClient = new SecretManagerServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AccessSecretVersionResponse $response */
        $response = $secretManagerServiceClient->accessSecretVersion($formattedName);
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
    $formattedName = SecretManagerServiceClient::secretVersionName(
        '[PROJECT]',
        '[SECRET]',
        '[SECRET_VERSION]'
    );

    access_secret_version_sample($formattedName);
}
// [END secretmanager_v1_generated_SecretManagerService_AccessSecretVersion_sync]
