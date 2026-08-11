<?php
/*
 * Copyright 2026 Google LLC
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

// [START storage_v2_generated_StorageControl_ViewObjectFullContext_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
use Google\Cloud\Storage\Control\V2\ObjectFullContext;
use Google\Cloud\Storage\Control\V2\ViewObjectFullContextRequest;

/**
 * Retrieves the full content of an object context, including its key, value,
 * and any associated extended data for a given context key.
 *
 * Object contexts can optionally contain extended data. If an object context
 * contains extended data, the metadata payload structure will contain only
 * its type URL. To retrieve the full extended data, call this method.
 *
 * Returns the complete representation of the context as an
 * [`ObjectFullContext`][google.storage.control.v2.ObjectFullContext].
 *
 * @param string $contextKey    The key of the object context to retrieve.
 * @param string $formattedName The name of the object.
 *                              Format: `projects/{project}/buckets/{bucket}/objects/{object}`
 *                              Please see {@see StorageControlClient::objectName()} for help formatting this field.
 */
function view_object_full_context_sample(string $contextKey, string $formattedName): void
{
    // Create a client.
    $storageControlClient = new StorageControlClient();

    // Prepare the request message.
    $request = (new ViewObjectFullContextRequest())
        ->setContextKey($contextKey)
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ObjectFullContext $response */
        $response = $storageControlClient->viewObjectFullContext($request);
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
    $contextKey = '[CONTEXT_KEY]';
    $formattedName = StorageControlClient::objectName('[PROJECT]', '[BUCKET]', '[OBJECT]');

    view_object_full_context_sample($contextKey, $formattedName);
}
// [END storage_v2_generated_StorageControl_ViewObjectFullContext_sync]
