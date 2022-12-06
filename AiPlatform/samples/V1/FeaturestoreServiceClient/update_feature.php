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

// [START aiplatform_v1_generated_FeaturestoreService_UpdateFeature_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Feature;
use Google\Cloud\AIPlatform\V1\Feature\ValueType;
use Google\Cloud\AIPlatform\V1\FeaturestoreServiceClient;

/**
 * Updates the parameters of a single Feature.
 *
 * @param int $featureValueType Immutable. Type of Feature value.
 */
function update_feature_sample(int $featureValueType): void
{
    // Create a client.
    $featurestoreServiceClient = new FeaturestoreServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $feature = (new Feature())
        ->setValueType($featureValueType);

    // Call the API and handle any network failures.
    try {
        /** @var Feature $response */
        $response = $featurestoreServiceClient->updateFeature($feature);
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
    $featureValueType = ValueType::VALUE_TYPE_UNSPECIFIED;

    update_feature_sample($featureValueType);
}
// [END aiplatform_v1_generated_FeaturestoreService_UpdateFeature_sync]
