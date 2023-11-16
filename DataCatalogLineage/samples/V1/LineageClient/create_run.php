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

// [START datalineage_v1_generated_Lineage_CreateRun_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\Lineage\V1\Client\LineageClient;
use Google\Cloud\DataCatalog\Lineage\V1\CreateRunRequest;
use Google\Cloud\DataCatalog\Lineage\V1\Run;
use Google\Cloud\DataCatalog\Lineage\V1\Run\State;
use Google\Protobuf\Timestamp;

/**
 * Creates a new run.
 *
 * @param string $formattedParent The name of the process that should own the run. Please see
 *                                {@see LineageClient::processName()} for help formatting this field.
 * @param int    $runState        The state of the run.
 */
function create_run_sample(string $formattedParent, int $runState): void
{
    // Create a client.
    $lineageClient = new LineageClient();

    // Prepare the request message.
    $runStartTime = new Timestamp();
    $run = (new Run())
        ->setStartTime($runStartTime)
        ->setState($runState);
    $request = (new CreateRunRequest())
        ->setParent($formattedParent)
        ->setRun($run);

    // Call the API and handle any network failures.
    try {
        /** @var Run $response */
        $response = $lineageClient->createRun($request);
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
    $formattedParent = LineageClient::processName('[PROJECT]', '[LOCATION]', '[PROCESS]');
    $runState = State::UNKNOWN;

    create_run_sample($formattedParent, $runState);
}
// [END datalineage_v1_generated_Lineage_CreateRun_sync]
