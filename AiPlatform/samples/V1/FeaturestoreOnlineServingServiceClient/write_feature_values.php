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

// [START aiplatform_v1_generated_FeaturestoreOnlineServingService_WriteFeatureValues_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\FeaturestoreOnlineServingServiceClient;
use Google\Cloud\AIPlatform\V1\WriteFeatureValuesPayload;
use Google\Cloud\AIPlatform\V1\WriteFeatureValuesResponse;

/**
 * Writes Feature values of one or more entities of an EntityType.
 *
 * The Feature values are merged into existing entities if any. The Feature
 * values to be written must have timestamp within the online storage
 * retention.
 *
 * @param string $formattedEntityType The resource name of the EntityType for the entities being written.
 *                                    Value format: `projects/{project}/locations/{location}/featurestores/
 *                                    {featurestore}/entityTypes/{entityType}`. For example,
 *                                    for a machine learning model predicting user clicks on a website, an
 *                                    EntityType ID could be `user`. Please see
 *                                    {@see FeaturestoreOnlineServingServiceClient::entityTypeName()} for help formatting this field.
 * @param string $payloadsEntityId    The ID of the entity.
 */
function write_feature_values_sample(string $formattedEntityType, string $payloadsEntityId): void
{
    // Create a client.
    $featurestoreOnlineServingServiceClient = new FeaturestoreOnlineServingServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $payloadsFeatureValues = [];
    $writeFeatureValuesPayload = (new WriteFeatureValuesPayload())
        ->setEntityId($payloadsEntityId)
        ->setFeatureValues($payloadsFeatureValues);
    $payloads = [$writeFeatureValuesPayload,];

    // Call the API and handle any network failures.
    try {
        /** @var WriteFeatureValuesResponse $response */
        $response = $featurestoreOnlineServingServiceClient->writeFeatureValues(
            $formattedEntityType,
            $payloads
        );
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
    $formattedEntityType = FeaturestoreOnlineServingServiceClient::entityTypeName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURESTORE]',
        '[ENTITY_TYPE]'
    );
    $payloadsEntityId = '[ENTITY_ID]';

    write_feature_values_sample($formattedEntityType, $payloadsEntityId);
}
// [END aiplatform_v1_generated_FeaturestoreOnlineServingService_WriteFeatureValues_sync]
