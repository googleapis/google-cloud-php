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

// [START documentai_v1_generated_DocumentProcessorService_EvaluateProcessorVersion_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\EvaluateProcessorVersionRequest;
use Google\Cloud\DocumentAI\V1\EvaluateProcessorVersionResponse;
use Google\Rpc\Status;

/**
 * Evaluates a ProcessorVersion against annotated documents, producing an
 * Evaluation.
 *
 * @param string $formattedProcessorVersion The resource name of the [ProcessorVersion][google.cloud.documentai.v1.ProcessorVersion] to evaluate.
 *                                          `projects/{project}/locations/{location}/processors/{processor}/processorVersions/{processorVersion}`
 *                                          Please see {@see DocumentProcessorServiceClient::processorVersionName()} for help formatting this field.
 */
function evaluate_processor_version_sample(string $formattedProcessorVersion): void
{
    // Create a client.
    $documentProcessorServiceClient = new DocumentProcessorServiceClient();

    // Prepare the request message.
    $request = (new EvaluateProcessorVersionRequest())
        ->setProcessorVersion($formattedProcessorVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentProcessorServiceClient->evaluateProcessorVersion($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var EvaluateProcessorVersionResponse $result */
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
    $formattedProcessorVersion = DocumentProcessorServiceClient::processorVersionName(
        '[PROJECT]',
        '[LOCATION]',
        '[PROCESSOR]',
        '[PROCESSOR_VERSION]'
    );

    evaluate_processor_version_sample($formattedProcessorVersion);
}
// [END documentai_v1_generated_DocumentProcessorService_EvaluateProcessorVersion_sync]
