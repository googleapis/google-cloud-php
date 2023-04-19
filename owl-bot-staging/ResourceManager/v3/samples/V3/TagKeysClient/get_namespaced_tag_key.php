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

// [START cloudresourcemanager_v3_generated_TagKeys_GetNamespacedTagKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceManager\V3\TagKey;
use Google\Cloud\ResourceManager\V3\TagKeysClient;

/**
 * Retrieves a TagKey by its namespaced name.
 * This method will return `PERMISSION_DENIED` if the key does not exist
 * or the user does not have permission to view it.
 *
 * @param string $formattedName A namespaced tag key name in the format
 *                              `{parentId}/{tagKeyShort}`, such as `42/foo` for a key with short name
 *                              "foo" under the organization with ID 42 or `r2-d2/bar` for a key with short
 *                              name "bar" under the project `r2-d2`. Please see
 *                              {@see TagKeysClient::tagKeyName()} for help formatting this field.
 */
function get_namespaced_tag_key_sample(string $formattedName): void
{
    // Create a client.
    $tagKeysClient = new TagKeysClient();

    // Call the API and handle any network failures.
    try {
        /** @var TagKey $response */
        $response = $tagKeysClient->getNamespacedTagKey($formattedName);
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
    $formattedName = TagKeysClient::tagKeyName('[TAG_KEY]');

    get_namespaced_tag_key_sample($formattedName);
}
// [END cloudresourcemanager_v3_generated_TagKeys_GetNamespacedTagKey_sync]
