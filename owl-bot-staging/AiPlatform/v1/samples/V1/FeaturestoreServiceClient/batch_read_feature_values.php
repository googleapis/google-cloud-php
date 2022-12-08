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

// [START aiplatform_v1_generated_FeaturestoreService_BatchReadFeatureValues_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\BatchReadFeatureValuesRequest\EntityTypeSpec;
use Google\Cloud\AIPlatform\V1\BatchReadFeatureValuesResponse;
use Google\Cloud\AIPlatform\V1\FeatureSelector;
use Google\Cloud\AIPlatform\V1\FeatureValueDestination;
use Google\Cloud\AIPlatform\V1\FeaturestoreServiceClient;
use Google\Cloud\AIPlatform\V1\IdMatcher;
use Google\Rpc\Status;

/**
 * Batch reads Feature values from a Featurestore.
 *
 * This API enables batch reading Feature values, where each read
 * instance in the batch may read Feature values of entities from one or
 * more EntityTypes. Point-in-time correctness is guaranteed for Feature
 * values of each read instance as of each instance's read timestamp.
 *
 * @param string $formattedFeaturestore                             The resource name of the Featurestore from which to query Feature values.
 *                                                                  Format:
 *                                                                  `projects/{project}/locations/{location}/featurestores/{featurestore}`
 *                                                                  Please see {@see FeaturestoreServiceClient::featurestoreName()} for help formatting this field.
 * @param string $entityTypeSpecsEntityTypeId                       ID of the EntityType to select Features. The EntityType id is the
 *                                                                  [entity_type_id][google.cloud.aiplatform.v1.CreateEntityTypeRequest.entity_type_id] specified
 *                                                                  during EntityType creation.
 * @param string $entityTypeSpecsFeatureSelectorIdMatcherIdsElement The following are accepted as `ids`:
 *
 *                                                                  * A single-element list containing only `*`, which selects all Features
 *                                                                  in the target EntityType, or
 *                                                                  * A list containing only Feature IDs, which selects only Features with
 *                                                                  those IDs in the target EntityType.
 */
function batch_read_feature_values_sample(
    string $formattedFeaturestore,
    string $entityTypeSpecsEntityTypeId,
    string $entityTypeSpecsFeatureSelectorIdMatcherIdsElement
): void {
    // Create a client.
    $featurestoreServiceClient = new FeaturestoreServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $destination = new FeatureValueDestination();
    $entityTypeSpecsFeatureSelectorIdMatcherIds = [
        $entityTypeSpecsFeatureSelectorIdMatcherIdsElement,
    ];
    $entityTypeSpecsFeatureSelectorIdMatcher = (new IdMatcher())
        ->setIds($entityTypeSpecsFeatureSelectorIdMatcherIds);
    $entityTypeSpecsFeatureSelector = (new FeatureSelector())
        ->setIdMatcher($entityTypeSpecsFeatureSelectorIdMatcher);
    $entityTypeSpec = (new EntityTypeSpec())
        ->setEntityTypeId($entityTypeSpecsEntityTypeId)
        ->setFeatureSelector($entityTypeSpecsFeatureSelector);
    $entityTypeSpecs = [$entityTypeSpec,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $featurestoreServiceClient->batchReadFeatureValues(
            $formattedFeaturestore,
            $destination,
            $entityTypeSpecs
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchReadFeatureValuesResponse $result */
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
    $formattedFeaturestore = FeaturestoreServiceClient::featurestoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURESTORE]'
    );
    $entityTypeSpecsEntityTypeId = '[ENTITY_TYPE_ID]';
    $entityTypeSpecsFeatureSelectorIdMatcherIdsElement = '[IDS]';

    batch_read_feature_values_sample(
        $formattedFeaturestore,
        $entityTypeSpecsEntityTypeId,
        $entityTypeSpecsFeatureSelectorIdMatcherIdsElement
    );
}
// [END aiplatform_v1_generated_FeaturestoreService_BatchReadFeatureValues_sync]
