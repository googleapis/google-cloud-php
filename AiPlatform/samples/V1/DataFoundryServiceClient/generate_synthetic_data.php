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

// [START aiplatform_v1_generated_DataFoundryService_GenerateSyntheticData_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\DataFoundryServiceClient;
use Google\Cloud\AIPlatform\V1\GenerateSyntheticDataRequest;
use Google\Cloud\AIPlatform\V1\GenerateSyntheticDataResponse;
use Google\Cloud\AIPlatform\V1\OutputFieldSpec;

/**
 * Generates synthetic data based on the provided configuration.
 *
 * @param string $formattedLocation         The resource name of the Location to run the job.
 *                                          Format: `projects/{project}/locations/{location}`
 *                                          Please see {@see DataFoundryServiceClient::locationName()} for help formatting this field.
 * @param int    $count                     The number of synthetic examples to generate.
 *                                          For this stateless API, the count is limited to a small number.
 * @param string $outputFieldSpecsFieldName The name of the output field.
 */
function generate_synthetic_data_sample(
    string $formattedLocation,
    int $count,
    string $outputFieldSpecsFieldName
): void {
    // Create a client.
    $dataFoundryServiceClient = new DataFoundryServiceClient();

    // Prepare the request message.
    $outputFieldSpec = (new OutputFieldSpec())
        ->setFieldName($outputFieldSpecsFieldName);
    $outputFieldSpecs = [$outputFieldSpec,];
    $request = (new GenerateSyntheticDataRequest())
        ->setLocation($formattedLocation)
        ->setCount($count)
        ->setOutputFieldSpecs($outputFieldSpecs);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateSyntheticDataResponse $response */
        $response = $dataFoundryServiceClient->generateSyntheticData($request);
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
    $formattedLocation = DataFoundryServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $count = 0;
    $outputFieldSpecsFieldName = '[FIELD_NAME]';

    generate_synthetic_data_sample($formattedLocation, $count, $outputFieldSpecsFieldName);
}
// [END aiplatform_v1_generated_DataFoundryService_GenerateSyntheticData_sync]
