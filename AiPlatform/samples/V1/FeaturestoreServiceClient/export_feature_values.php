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

// [START aiplatform_v1_generated_FeaturestoreService_ExportFeatureValues_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\ExportFeatureValuesResponse;
use Google\Cloud\AIPlatform\V1\FeatureSelector;
use Google\Cloud\AIPlatform\V1\FeatureValueDestination;
use Google\Cloud\AIPlatform\V1\FeaturestoreServiceClient;
use Google\Cloud\AIPlatform\V1\IdMatcher;
use Google\Rpc\Status;

/**
 * Exports Feature values from all the entities of a target EntityType.
 *
 * @param string $formattedEntityType                The resource name of the EntityType from which to export Feature values.
 *                                                   Format:
 *                                                   `projects/{project}/locations/{location}/featurestores/{featurestore}/entityTypes/{entity_type}`
 *                                                   Please see {@see FeaturestoreServiceClient::entityTypeName()} for help formatting this field.
 * @param string $featureSelectorIdMatcherIdsElement The following are accepted as `ids`:
 *
 *                                                   * A single-element list containing only `*`, which selects all Features
 *                                                   in the target EntityType, or
 *                                                   * A list containing only Feature IDs, which selects only Features with
 *                                                   those IDs in the target EntityType.
 */
function export_feature_values_sample(
    string $formattedEntityType,
    string $featureSelectorIdMatcherIdsElement
): void {
    // Create a client.
    $featurestoreServiceClient = new FeaturestoreServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $destination = new FeatureValueDestination();
    $featureSelectorIdMatcherIds = [$featureSelectorIdMatcherIdsElement,];
    $featureSelectorIdMatcher = (new IdMatcher())
        ->setIds($featureSelectorIdMatcherIds);
    $featureSelector = (new FeatureSelector())
        ->setIdMatcher($featureSelectorIdMatcher);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $featurestoreServiceClient->exportFeatureValues(
            $formattedEntityType,
            $destination,
            $featureSelector
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportFeatureValuesResponse $result */
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
    $formattedEntityType = FeaturestoreServiceClient::entityTypeName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURESTORE]',
        '[ENTITY_TYPE]'
    );
    $featureSelectorIdMatcherIdsElement = '[IDS]';

    export_feature_values_sample($formattedEntityType, $featureSelectorIdMatcherIdsElement);
}
// [END aiplatform_v1_generated_FeaturestoreService_ExportFeatureValues_sync]
