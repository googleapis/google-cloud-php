<?php
/*
 * Copyright 2024 Google LLC
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

// [START retail_v2_generated_GenerativeQuestionService_BatchUpdateGenerativeQuestionConfigs_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\BatchUpdateGenerativeQuestionConfigsRequest;
use Google\Cloud\Retail\V2\BatchUpdateGenerativeQuestionConfigsResponse;
use Google\Cloud\Retail\V2\Client\GenerativeQuestionServiceClient;
use Google\Cloud\Retail\V2\GenerativeQuestionConfig;
use Google\Cloud\Retail\V2\UpdateGenerativeQuestionConfigRequest;

/**
 * Allows management of multiple questions.
 *
 * @param string $requestsGenerativeQuestionConfigCatalog Resource name of the catalog.
 *                                                        Format: projects/{project}/locations/{location}/catalogs/{catalog}
 * @param string $requestsGenerativeQuestionConfigFacet   The facet to which the question is associated.
 */
function batch_update_generative_question_configs_sample(
    string $requestsGenerativeQuestionConfigCatalog,
    string $requestsGenerativeQuestionConfigFacet
): void {
    // Create a client.
    $generativeQuestionServiceClient = new GenerativeQuestionServiceClient();

    // Prepare the request message.
    $requestsGenerativeQuestionConfig = (new GenerativeQuestionConfig())
        ->setCatalog($requestsGenerativeQuestionConfigCatalog)
        ->setFacet($requestsGenerativeQuestionConfigFacet);
    $updateGenerativeQuestionConfigRequest = (new UpdateGenerativeQuestionConfigRequest())
        ->setGenerativeQuestionConfig($requestsGenerativeQuestionConfig);
    $requests = [$updateGenerativeQuestionConfigRequest,];
    $request = (new BatchUpdateGenerativeQuestionConfigsRequest())
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateGenerativeQuestionConfigsResponse $response */
        $response = $generativeQuestionServiceClient->batchUpdateGenerativeQuestionConfigs($request);
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
    $requestsGenerativeQuestionConfigCatalog = '[CATALOG]';
    $requestsGenerativeQuestionConfigFacet = '[FACET]';

    batch_update_generative_question_configs_sample(
        $requestsGenerativeQuestionConfigCatalog,
        $requestsGenerativeQuestionConfigFacet
    );
}
// [END retail_v2_generated_GenerativeQuestionService_BatchUpdateGenerativeQuestionConfigs_sync]
