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

// [START dialogflow_v2_generated_GeneratorEvaluations_CreateGeneratorEvaluation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Client\GeneratorEvaluationsClient;
use Google\Cloud\Dialogflow\V2\CreateGeneratorEvaluationRequest;
use Google\Cloud\Dialogflow\V2\Generator;
use Google\Cloud\Dialogflow\V2\GeneratorEvaluation;
use Google\Cloud\Dialogflow\V2\GeneratorEvaluationConfig;
use Google\Cloud\Dialogflow\V2\GeneratorEvaluationConfig\InputDataConfig;
use Google\Cloud\Dialogflow\V2\GeneratorEvaluationConfig\InputDataSourceType;
use Google\Rpc\Status;

/**
 * Creates evaluation of a generator.
 *
 * @param string $formattedParent                                                                The generator resource name. Format:
 *                                                                                               `projects/<Project ID>/locations/<Location ID>/generators/<Generator ID>`
 *                                                                                               Please see {@see GeneratorEvaluationsClient::generatorName()} for help formatting this field.
 * @param int    $generatorEvaluationGeneratorEvaluationConfigInputDataConfigInputDataSourceType The source type of input data.
 * @param string $generatorEvaluationGeneratorEvaluationConfigOutputGcsBucketPath                The output Cloud Storage bucket path to store eval files, e.g.
 *                                                                                               per_summary_accuracy_score report. This path is provided by customer and
 *                                                                                               files stored in it are visible to customer, no internal data should be
 *                                                                                               stored in this path.
 */
function create_generator_evaluation_sample(
    string $formattedParent,
    int $generatorEvaluationGeneratorEvaluationConfigInputDataConfigInputDataSourceType,
    string $generatorEvaluationGeneratorEvaluationConfigOutputGcsBucketPath
): void {
    // Create a client.
    $generatorEvaluationsClient = new GeneratorEvaluationsClient();

    // Prepare the request message.
    $generatorEvaluationGeneratorEvaluationConfigInputDataConfig = (new InputDataConfig())
        ->setInputDataSourceType(
            $generatorEvaluationGeneratorEvaluationConfigInputDataConfigInputDataSourceType
        );
    $generatorEvaluationGeneratorEvaluationConfig = (new GeneratorEvaluationConfig())
        ->setInputDataConfig($generatorEvaluationGeneratorEvaluationConfigInputDataConfig)
        ->setOutputGcsBucketPath($generatorEvaluationGeneratorEvaluationConfigOutputGcsBucketPath);
    $generatorEvaluationInitialGenerator = new Generator();
    $generatorEvaluation = (new GeneratorEvaluation())
        ->setGeneratorEvaluationConfig($generatorEvaluationGeneratorEvaluationConfig)
        ->setInitialGenerator($generatorEvaluationInitialGenerator);
    $request = (new CreateGeneratorEvaluationRequest())
        ->setParent($formattedParent)
        ->setGeneratorEvaluation($generatorEvaluation);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $generatorEvaluationsClient->createGeneratorEvaluation($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GeneratorEvaluation $result */
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
    $formattedParent = GeneratorEvaluationsClient::generatorName(
        '[PROJECT]',
        '[LOCATION]',
        '[GENERATOR]'
    );
    $generatorEvaluationGeneratorEvaluationConfigInputDataConfigInputDataSourceType = InputDataSourceType::INPUT_DATA_SOURCE_TYPE_UNSPECIFIED;
    $generatorEvaluationGeneratorEvaluationConfigOutputGcsBucketPath = '[OUTPUT_GCS_BUCKET_PATH]';

    create_generator_evaluation_sample(
        $formattedParent,
        $generatorEvaluationGeneratorEvaluationConfigInputDataConfigInputDataSourceType,
        $generatorEvaluationGeneratorEvaluationConfigOutputGcsBucketPath
    );
}
// [END dialogflow_v2_generated_GeneratorEvaluations_CreateGeneratorEvaluation_sync]
