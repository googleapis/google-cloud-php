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

// [START documentai_v1_generated_DocumentProcessorService_EnableProcessor_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DocumentAI\V1\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\EnableProcessorResponse;
use Google\Rpc\Status;

/**
 * Enables a processor
 *
 * @param string $formattedName The processor resource name to be enabled. Please see
 *                              {@see DocumentProcessorServiceClient::processorName()} for help formatting this field.
 */
function enable_processor_sample(string $formattedName): void
{
    // Create a client.
    $documentProcessorServiceClient = new DocumentProcessorServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentProcessorServiceClient->enableProcessor($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var EnableProcessorResponse $result */
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
    $formattedName = DocumentProcessorServiceClient::processorName(
        '[PROJECT]',
        '[LOCATION]',
        '[PROCESSOR]'
    );

    enable_processor_sample($formattedName);
}
// [END documentai_v1_generated_DocumentProcessorService_EnableProcessor_sync]
