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

// [START apikeys_v2_generated_ApiKeys_LookupKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiKeys\V2\ApiKeysClient;
use Google\Cloud\ApiKeys\V2\LookupKeyResponse;

/**
 * Find the parent project and resource name of the API
 * key that matches the key string in the request. If the API key has been
 * purged, resource name will not be set.
 * The service account must have the `apikeys.keys.lookup` permission
 * on the parent project.
 *
 * @param string $keyString Finds the project that owns the key string value.
 */
function lookup_key_sample(string $keyString): void
{
    // Create a client.
    $apiKeysClient = new ApiKeysClient();

    // Call the API and handle any network failures.
    try {
        /** @var LookupKeyResponse $response */
        $response = $apiKeysClient->lookupKey($keyString);
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
    $keyString = '[KEY_STRING]';

    lookup_key_sample($keyString);
}
// [END apikeys_v2_generated_ApiKeys_LookupKey_sync]
