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

// [START documentai_v1_generated_DocumentProcessorService_BatchProcessDocuments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DocumentAI\V1\BatchProcessRequest;
use Google\Cloud\DocumentAI\V1\BatchProcessResponse;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Rpc\Status;

/**
 * LRO endpoint to batch process many documents. The output is written
 * to Cloud Storage as JSON in the [Document] format.
 *
 * @param string $name The resource name of
 *                     [Processor][google.cloud.documentai.v1.Processor] or
 *                     [ProcessorVersion][google.cloud.documentai.v1.ProcessorVersion].
 *                     Format: `projects/{project}/locations/{location}/processors/{processor}`,
 *                     or
 *                     `projects/{project}/locations/{location}/processors/{processor}/processorVersions/{processorVersion}`
 */
function batch_process_documents_sample(string $name): void
{
    // Create a client.
    $documentProcessorServiceClient = new DocumentProcessorServiceClient();

    // Prepare the request message.
    $request = (new BatchProcessRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentProcessorServiceClient->batchProcessDocuments($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchProcessResponse $result */
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
    $name = '[NAME]';

    batch_process_documents_sample($name);
}
// [END documentai_v1_generated_DocumentProcessorService_BatchProcessDocuments_sync]
