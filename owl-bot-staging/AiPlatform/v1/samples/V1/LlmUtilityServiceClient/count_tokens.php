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

// [START aiplatform_v1_generated_LlmUtilityService_CountTokens_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\LlmUtilityServiceClient;
use Google\Cloud\AIPlatform\V1\Content;
use Google\Cloud\AIPlatform\V1\CountTokensRequest;
use Google\Cloud\AIPlatform\V1\CountTokensResponse;
use Google\Cloud\AIPlatform\V1\Part;
use Google\Protobuf\Value;

/**
 * Perform a token counting.
 *
 * @param string $formattedEndpoint The name of the Endpoint requested to perform token counting.
 *                                  Format:
 *                                  `projects/{project}/locations/{location}/endpoints/{endpoint}`
 *                                  Please see {@see LlmUtilityServiceClient::endpointName()} for help formatting this field.
 * @param string $model             The name of the publisher model requested to serve the
 *                                  prediction. Format:
 *                                  `projects/{project}/locations/{location}/publishers/&#42;/models/*`
 */
function count_tokens_sample(string $formattedEndpoint, string $model): void
{
    // Create a client.
    $llmUtilityServiceClient = new LlmUtilityServiceClient();

    // Prepare the request message.
    $instances = [new Value()];
    $contentsParts = [new Part()];
    $content = (new Content())
        ->setParts($contentsParts);
    $contents = [$content,];
    $request = (new CountTokensRequest())
        ->setEndpoint($formattedEndpoint)
        ->setModel($model)
        ->setInstances($instances)
        ->setContents($contents);

    // Call the API and handle any network failures.
    try {
        /** @var CountTokensResponse $response */
        $response = $llmUtilityServiceClient->countTokens($request);
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
    $formattedEndpoint = LlmUtilityServiceClient::endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
    $model = '[MODEL]';

    count_tokens_sample($formattedEndpoint, $model);
}
// [END aiplatform_v1_generated_LlmUtilityService_CountTokens_sync]
