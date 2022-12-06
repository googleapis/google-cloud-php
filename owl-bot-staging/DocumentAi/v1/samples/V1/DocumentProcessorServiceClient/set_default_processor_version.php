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

// [START documentai_v1_generated_DocumentProcessorService_SetDefaultProcessorVersion_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DocumentAI\V1\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\SetDefaultProcessorVersionResponse;
use Google\Rpc\Status;

/**
 * Set the default (active) version of a [Processor][google.cloud.documentai.v1.Processor] that will be used in
 * [ProcessDocument][google.cloud.documentai.v1.DocumentProcessorService.ProcessDocument] and
 * [BatchProcessDocuments][google.cloud.documentai.v1.DocumentProcessorService.BatchProcessDocuments].
 *
 * @param string $formattedProcessor               The resource name of the [Processor][google.cloud.documentai.v1.Processor] to change default version. Please see
 *                                                 {@see DocumentProcessorServiceClient::processorName()} for help formatting this field.
 * @param string $formattedDefaultProcessorVersion The resource name of child [ProcessorVersion][google.cloud.documentai.v1.ProcessorVersion] to use as default.
 *                                                 Format:
 *                                                 `projects/{project}/locations/{location}/processors/{processor}/processorVersions/{version}`
 *                                                 Please see {@see DocumentProcessorServiceClient::processorVersionName()} for help formatting this field.
 */
function set_default_processor_version_sample(
    string $formattedProcessor,
    string $formattedDefaultProcessorVersion
): void {
    // Create a client.
    $documentProcessorServiceClient = new DocumentProcessorServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentProcessorServiceClient->setDefaultProcessorVersion(
            $formattedProcessor,
            $formattedDefaultProcessorVersion
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SetDefaultProcessorVersionResponse $result */
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
    $formattedProcessor = DocumentProcessorServiceClient::processorName(
        '[PROJECT]',
        '[LOCATION]',
        '[PROCESSOR]'
    );
    $formattedDefaultProcessorVersion = DocumentProcessorServiceClient::processorVersionName(
        '[PROJECT]',
        '[LOCATION]',
        '[PROCESSOR]',
        '[PROCESSOR_VERSION]'
    );

    set_default_processor_version_sample($formattedProcessor, $formattedDefaultProcessorVersion);
}
// [END documentai_v1_generated_DocumentProcessorService_SetDefaultProcessorVersion_sync]
