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

// [START kmsinventory_v1_generated_KeyDashboardService_ListCryptoKeys_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Kms\Inventory\V1\KeyDashboardServiceClient;
use Google\Cloud\Kms\V1\CryptoKey;

/**
 * Returns cryptographic keys managed by Cloud KMS in a given Cloud project.
 * Note that this data is sourced from snapshots, meaning it may not
 * completely reflect the actual state of key metadata at call time.
 *
 * @param string $formattedParent The Google Cloud project for which to retrieve key metadata, in
 *                                the format `projects/*`
 *                                Please see {@see KeyDashboardServiceClient::projectName()} for help formatting this field.
 */
function list_crypto_keys_sample(string $formattedParent): void
{
    // Create a client.
    $keyDashboardServiceClient = new KeyDashboardServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $keyDashboardServiceClient->listCryptoKeys($formattedParent);

        /** @var CryptoKey $element */
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
    $formattedParent = KeyDashboardServiceClient::projectName('[PROJECT]');

    list_crypto_keys_sample($formattedParent);
}
// [END kmsinventory_v1_generated_KeyDashboardService_ListCryptoKeys_sync]
