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

// [START secretmanager_v1beta1_generated_SecretManagerService_EnableSecretVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecretManager\V1beta1\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1beta1\SecretVersion;

/**
 * Enables a [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
 *
 * Sets the [state][google.cloud.secrets.v1beta1.SecretVersion.state] of the [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion] to
 * [ENABLED][google.cloud.secrets.v1beta1.SecretVersion.State.ENABLED].
 *
 * @param string $formattedName The resource name of the [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion] to enable in the format
 *                              `projects/&#42;/secrets/&#42;/versions/*`. Please see
 *                              {@see SecretManagerServiceClient::secretVersionName()} for help formatting this field.
 */
function enable_secret_version_sample(string $formattedName): void
{
    // Create a client.
    $secretManagerServiceClient = new SecretManagerServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var SecretVersion $response */
        $response = $secretManagerServiceClient->enableSecretVersion($formattedName);
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

    enable_secret_version_sample($formattedName);
}
// [END secretmanager_v1beta1_generated_SecretManagerService_EnableSecretVersion_sync]
