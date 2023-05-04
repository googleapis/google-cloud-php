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

// [START cloudresourcemanager_v3_generated_TagValues_GetNamespacedTagValue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceManager\V3\TagValue;
use Google\Cloud\ResourceManager\V3\TagValuesClient;

/**
 * Retrieves a TagValue by its namespaced name.
 * This method will return `PERMISSION_DENIED` if the value does not exist
 * or the user does not have permission to view it.
 *
 * @param string $formattedName A namespaced tag value name in the following format:
 *
 *                              `{parentId}/{tagKeyShort}/{tagValueShort}`
 *
 *                              Examples:
 *                              - `42/foo/abc` for a value with short name "abc" under the key with short
 *                              name "foo" under the organization with ID 42
 *                              - `r2-d2/bar/xyz` for a value with short name "xyz" under the key with
 *                              short name "bar" under the project with ID "r2-d2"
 *                              Please see {@see TagValuesClient::tagValueName()} for help formatting this field.
 */
function get_namespaced_tag_value_sample(string $formattedName): void
{
    // Create a client.
    $tagValuesClient = new TagValuesClient();

    // Call the API and handle any network failures.
    try {
        /** @var TagValue $response */
        $response = $tagValuesClient->getNamespacedTagValue($formattedName);
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
    $formattedName = TagValuesClient::tagValueName('[TAG_VALUE]');

    get_namespaced_tag_value_sample($formattedName);
}
// [END cloudresourcemanager_v3_generated_TagValues_GetNamespacedTagValue_sync]
