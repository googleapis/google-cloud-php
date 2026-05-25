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

// [START dataplex_v1_generated_CatalogService_ModifyEntry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\Entry;
use Google\Cloud\Dataplex\V1\ModifyEntryRequest;

/**
 * Modifies an entry using the permission on the source system.
 *
 * @param string $name           The project to which the request should be attributed in the
 *                               following form: `projects/{project}/locations/{location}`.
 * @param string $entryEntryType Immutable. The relative resource name of the entry type that was
 *                               used to create this entry, in the format
 *                               `projects/{project_id_or_number}/locations/{location_id}/entryTypes/{entry_type_id}`.
 */
function modify_entry_sample(string $name, string $entryEntryType): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $entry = (new Entry())
        ->setEntryType($entryEntryType);
    $request = (new ModifyEntryRequest())
        ->setName($name)
        ->setEntry($entry);

    // Call the API and handle any network failures.
    try {
        /** @var Entry $response */
        $response = $catalogServiceClient->modifyEntry($request);
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
    $name = '[NAME]';
    $entryEntryType = '[ENTRY_TYPE]';

    modify_entry_sample($name, $entryEntryType);
}
// [END dataplex_v1_generated_CatalogService_ModifyEntry_sync]
