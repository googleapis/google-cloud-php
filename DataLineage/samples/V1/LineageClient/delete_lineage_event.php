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

// [START datalineage_v1_generated_Lineage_DeleteLineageEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\Lineage\V1\LineageClient;

/**
 * Deletes the lineage event with the specified name.
 *
 * @param string $formattedName The name of the lineage event to delete. Please see
 *                              {@see LineageClient::lineageEventName()} for help formatting this field.
 */
function delete_lineage_event_sample(string $formattedName): void
{
    // Create a client.
    $lineageClient = new LineageClient();

    // Call the API and handle any network failures.
    try {
        $lineageClient->deleteLineageEvent($formattedName);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = LineageClient::lineageEventName(
        '[PROJECT]',
        '[LOCATION]',
        '[PROCESS]',
        '[RUN]',
        '[LINEAGE_EVENT]'
    );

    delete_lineage_event_sample($formattedName);
}
// [END datalineage_v1_generated_Lineage_DeleteLineageEvent_sync]
