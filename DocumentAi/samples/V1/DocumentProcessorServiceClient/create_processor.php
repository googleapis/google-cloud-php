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

// [START documentai_v1_generated_DocumentProcessorService_CreateProcessor_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DocumentAI\V1\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\Processor;

/**
 * Creates a processor from the type processor that the user chose.
 * The processor will be at "ENABLED" state by default after its creation.
 *
 * @param string $formattedParent The parent (project and location) under which to create the
 *                                processor. Format: `projects/{project}/locations/{location}`
 *                                Please see {@see DocumentProcessorServiceClient::locationName()} for help formatting this field.
 */
function create_processor_sample(string $formattedParent): void
{
    // Create a client.
    $documentProcessorServiceClient = new DocumentProcessorServiceClient();

    // Prepare the request message.
    $processor = new Processor();

    // Call the API and handle any network failures.
    try {
        /** @var Processor $response */
        $response = $documentProcessorServiceClient->createProcessor($formattedParent, $processor);
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
    $formattedParent = DocumentProcessorServiceClient::locationName('[PROJECT]', '[LOCATION]');

    create_processor_sample($formattedParent);
}
// [END documentai_v1_generated_DocumentProcessorService_CreateProcessor_sync]
