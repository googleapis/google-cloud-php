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

// [START cloudresourcemanager_v3_generated_TagBindings_ListEffectiveTags_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ResourceManager\V3\Client\TagBindingsClient;
use Google\Cloud\ResourceManager\V3\EffectiveTag;
use Google\Cloud\ResourceManager\V3\ListEffectiveTagsRequest;

/**
 * Return a list of effective tags for the given Google Cloud resource, as
 * specified in `parent`.
 *
 * @param string $parent The full resource name of a resource for which you want to list
 *                       the effective tags. E.g.
 *                       "//cloudresourcemanager.googleapis.com/projects/123"
 */
function list_effective_tags_sample(string $parent): void
{
    // Create a client.
    $tagBindingsClient = new TagBindingsClient();

    // Prepare the request message.
    $request = (new ListEffectiveTagsRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $tagBindingsClient->listEffectiveTags($request);

        /** @var EffectiveTag $element */
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
    $parent = '[PARENT]';

    list_effective_tags_sample($parent);
}
// [END cloudresourcemanager_v3_generated_TagBindings_ListEffectiveTags_sync]
