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

// [START visionai_v1_generated_Warehouse_CreateCorpus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\Corpus;
use Google\Cloud\VisionAI\V1\WarehouseClient;
use Google\Rpc\Status;

/**
 * Creates a corpus inside a project.
 *
 * @param string $parent            Form: `projects/{project_number}/locations/{location_id}`
 * @param string $corpusDisplayName The corpus name to shown in the UI. The name can be up to 32
 *                                  characters long.
 */
function create_corpus_sample(string $parent, string $corpusDisplayName): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $corpus = (new Corpus())
        ->setDisplayName($corpusDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $warehouseClient->createCorpus($parent, $corpus);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Corpus $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $corpusDisplayName = '[DISPLAY_NAME]';

    create_corpus_sample($parent, $corpusDisplayName);
}
// [END visionai_v1_generated_Warehouse_CreateCorpus_sync]
