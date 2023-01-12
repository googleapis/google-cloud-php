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

// [START cloudresourcemanager_v3_generated_TagKeys_GetTagKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceManager\V3\TagKey;
use Google\Cloud\ResourceManager\V3\TagKeysClient;

/**
 * Retrieves a TagKey. This method will return `PERMISSION_DENIED` if the
 * key does not exist or the user does not have permission to view it.
 *
 * @param string $formattedName A resource name in the format `tagKeys/{id}`, such as
 *                              `tagKeys/123`. Please see
 *                              {@see TagKeysClient::tagKeyName()} for help formatting this field.
 */
function get_tag_key_sample(string $formattedName): void
{
    // Create a client.
    $tagKeysClient = new TagKeysClient();

    // Call the API and handle any network failures.
    try {
        /** @var TagKey $response */
        $response = $tagKeysClient->getTagKey($formattedName);
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

    get_tag_key_sample($formattedName);
}
// [END cloudresourcemanager_v3_generated_TagKeys_GetTagKey_sync]
