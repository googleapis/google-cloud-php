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

// [START documentai_v1_generated_DocumentProcessorService_GetProcessorType_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\GetProcessorTypeRequest;
use Google\Cloud\DocumentAI\V1\ProcessorType;

/**
 * Gets a processor type detail.
 *
 * @param string $formattedName The processor type resource name. Please see
 *                              {@see DocumentProcessorServiceClient::processorTypeName()} for help formatting this field.
 */
function get_processor_type_sample(string $formattedName): void
{
    // Create a client.
    $documentProcessorServiceClient = new DocumentProcessorServiceClient();

    // Prepare the request message.
    $request = (new GetProcessorTypeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ProcessorType $response */
        $response = $documentProcessorServiceClient->getProcessorType($request);
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
    $formattedName = DocumentProcessorServiceClient::processorTypeName(
        '[PROJECT]',
        '[LOCATION]',
        '[PROCESSOR_TYPE]'
    );

    get_processor_type_sample($formattedName);
}
// [END documentai_v1_generated_DocumentProcessorService_GetProcessorType_sync]
