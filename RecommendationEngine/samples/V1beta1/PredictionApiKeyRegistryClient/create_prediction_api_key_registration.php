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

// [START recommendationengine_v1beta1_generated_PredictionApiKeyRegistry_CreatePredictionApiKeyRegistration_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecommendationEngine\V1beta1\PredictionApiKeyRegistration;
use Google\Cloud\RecommendationEngine\V1beta1\PredictionApiKeyRegistryClient;

/**
 * Register an API key for use with predict method.
 *
 * @param string $formattedParent The parent resource path.
 *                                `projects/&#42;/locations/global/catalogs/default_catalog/eventStores/default_event_store`. Please see
 *                                {@see PredictionApiKeyRegistryClient::eventStoreName()} for help formatting this field.
 */
function create_prediction_api_key_registration_sample(string $formattedParent): void
{
    // Create a client.
    $predictionApiKeyRegistryClient = new PredictionApiKeyRegistryClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $predictionApiKeyRegistration = new PredictionApiKeyRegistration();

    // Call the API and handle any network failures.
    try {
        /** @var PredictionApiKeyRegistration $response */
        $response = $predictionApiKeyRegistryClient->createPredictionApiKeyRegistration(
            $formattedParent,
            $predictionApiKeyRegistration
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
    $formattedParent = PredictionApiKeyRegistryClient::eventStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[EVENT_STORE]'
    );

    create_prediction_api_key_registration_sample($formattedParent);
}
// [END recommendationengine_v1beta1_generated_PredictionApiKeyRegistry_CreatePredictionApiKeyRegistration_sync]
