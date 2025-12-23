<?php
/*
 * Copyright 2025 Google LLC
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

// [START dialogflow_v2_generated_GeneratorEvaluations_ListGeneratorEvaluations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dialogflow\V2\Client\GeneratorEvaluationsClient;
use Google\Cloud\Dialogflow\V2\GeneratorEvaluation;
use Google\Cloud\Dialogflow\V2\ListGeneratorEvaluationsRequest;

/**
 * Lists evaluations of generator.
 *
 * @param string $formattedParent The generator resource name. Format:
 *                                `projects/<Project ID>/locations/<Location ID>/generators/<Generator ID>`
 *                                Wildcard value `-` is supported on generator_id to list evaluations across
 *                                all generators under same project. Please see
 *                                {@see GeneratorEvaluationsClient::generatorName()} for help formatting this field.
 */
function list_generator_evaluations_sample(string $formattedParent): void
{
    // Create a client.
    $generatorEvaluationsClient = new GeneratorEvaluationsClient();

    // Prepare the request message.
    $request = (new ListGeneratorEvaluationsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $generatorEvaluationsClient->listGeneratorEvaluations($request);

        /** @var GeneratorEvaluation $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = GeneratorEvaluationsClient::generatorName(
        '[PROJECT]',
        '[LOCATION]',
        '[GENERATOR]'
    );

    list_generator_evaluations_sample($formattedParent);
}
// [END dialogflow_v2_generated_GeneratorEvaluations_ListGeneratorEvaluations_sync]
