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

// [START datalineage_v1_generated_Lineage_ProcessOpenLineageRunEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\Lineage\V1\Client\LineageClient;
use Google\Cloud\DataCatalog\Lineage\V1\ProcessOpenLineageRunEventRequest;
use Google\Cloud\DataCatalog\Lineage\V1\ProcessOpenLineageRunEventResponse;
use Google\Protobuf\Struct;

/**
 * Creates new lineage events together with their parents: process and run.
 * Updates the process and run if they already exist.
 * Mapped from Open Lineage specification:
 * https://github.com/OpenLineage/OpenLineage/blob/main/spec/OpenLineage.json.
 *
 * @param string $parent The name of the project and its location that should own the
 *                       process, run, and lineage event.
 */
function process_open_lineage_run_event_sample(string $parent): void
{
    // Create a client.
    $lineageClient = new LineageClient();

    // Prepare the request message.
    $openLineage = new Struct();
    $request = (new ProcessOpenLineageRunEventRequest())
        ->setParent($parent)
        ->setOpenLineage($openLineage);

    // Call the API and handle any network failures.
    try {
        /** @var ProcessOpenLineageRunEventResponse $response */
        $response = $lineageClient->processOpenLineageRunEvent($request);
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
    $parent = '[PARENT]';

    process_open_lineage_run_event_sample($parent);
}
// [END datalineage_v1_generated_Lineage_ProcessOpenLineageRunEvent_sync]
