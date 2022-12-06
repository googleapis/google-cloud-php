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

// [START cloudresourcemanager_v3_generated_TagValues_GetTagValue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceManager\V3\TagValue;
use Google\Cloud\ResourceManager\V3\TagValuesClient;

/**
 * Retrieves TagValue. If the TagValue or namespaced name does not exist, or
 * if the user does not have permission to view it, this method will return
 * `PERMISSION_DENIED`.
 *
 * @param string $formattedName Resource name for TagValue to be fetched in the format `tagValues/456`. Please see
 *                              {@see TagValuesClient::tagValueName()} for help formatting this field.
 */
function get_tag_value_sample(string $formattedName): void
{
    // Create a client.
    $tagValuesClient = new TagValuesClient();

    // Call the API and handle any network failures.
    try {
        /** @var TagValue $response */
        $response = $tagValuesClient->getTagValue($formattedName);
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

    get_tag_value_sample($formattedName);
}
// [END cloudresourcemanager_v3_generated_TagValues_GetTagValue_sync]
