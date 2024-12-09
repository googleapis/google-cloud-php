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

// [START aiplatform_v1_generated_PredictionService_GenerateContent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient;
use Google\Cloud\AIPlatform\V1\GenerationConfig;
use Google\Cloud\AIPlatform\V1\Content;
use Google\Cloud\AIPlatform\V1\GenerateContentRequest;
use Google\Cloud\AIPlatform\V1\GenerateContentResponse;
use Google\Cloud\AIPlatform\V1\Part;

/**
 * Generate content with multimodal inputs.
 *
 * @param string $model The fully qualified name of the publisher model or tuned model
 *                      endpoint to use.
 *
 *                      Publisher model format:
 *                      `projects/{project}/locations/{location}/publishers/&#42;/models/*`
 *
 *                      Publisher Google Gemini 1.5 Flash model format:
 *                      `projects/{project}/locations/{location}/publishers/google/models/gemini-1.5-flash-002`
 *
 *                      Publisher Google Gemini 1.5 Pro model format:
 *                      `projects/{project}/locations/{location}/publishers/google/models/gemini-1.5-pro-002`
 *
 *                      Tuned model endpoint format:
 *                      `projects/{project}/locations/{location}/endpoints/{endpoint}`
 */
function generate_content_sample(string $model): void
{
    // Get api endpoint from model
    $region = explode("/", $model)[3];
    $apiEndpoint = "{$region}-aiplatform.googleapis.com";

    // Create a client.
    $predictionServiceClient = new PredictionServiceClient([
       'apiEndpoint' => $apiEndpoint
    ]);

    // Prepare the generation config.
    $generation_config = (new GenerationConfig())
                ->setMaxOutputTokens(8192)
                ->setTemperature(1);

    // Prepare the request message.
    $textPrompt =( new Part())
        ->setText("Write a lesson for a history class of 20 third-graders on Versailles' history. Make it engaging, interactive, and tech-friendly. .");
    $contentsParts = [$textPrompt];
    $content = (new Content())
        ->setRole("user")
        ->setParts($contentsParts);
    $contents = [$content,];
    $request = (new GenerateContentRequest())
        ->setModel($model)
        ->setContents($contents);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateContentResponse $response */
        $response = $predictionServiceClient->generateContent($request);
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
    $model = '[MODEL]';

    generate_content_sample($model);
}
// [END aiplatform_v1_generated_PredictionService_GenerateContent_sync]