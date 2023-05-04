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

// [START secretmanager_v1_generated_SecretManagerService_ListSecrets_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

/**
 * Lists [Secrets][google.cloud.secretmanager.v1.Secret].
 *
 * @param string $formattedParent The resource name of the project associated with the
 *                                [Secrets][google.cloud.secretmanager.v1.Secret], in the format `projects/*`. Please see
 *                                {@see SecretManagerServiceClient::projectName()} for help formatting this field.
 */
function list_secrets_sample(string $formattedParent): void
{
    // Create a client.
    $secretManagerServiceClient = new SecretManagerServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $secretManagerServiceClient->listSecrets($formattedParent);

        /** @var Secret $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = SecretManagerServiceClient::projectName('[PROJECT]');

    list_secrets_sample($formattedParent);
}
// [END secretmanager_v1_generated_SecretManagerService_ListSecrets_sync]
