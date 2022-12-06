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

// [START recommendationengine_v1beta1_generated_PredictionApiKeyRegistry_DeletePredictionApiKeyRegistration_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecommendationEngine\V1beta1\PredictionApiKeyRegistryClient;

/**
 * Unregister an apiKey from using for predict method.
 *
 * @param string $formattedName The API key to unregister including full resource path.
 *                              `projects/&#42;/locations/global/catalogs/default_catalog/eventStores/default_event_store/predictionApiKeyRegistrations/<YOUR_API_KEY>`
 *                              Please see {@see PredictionApiKeyRegistryClient::predictionApiKeyRegistrationName()} for help formatting this field.
 */
function delete_prediction_api_key_registration_sample(string $formattedName): void
{
    // Create a client.
    $predictionApiKeyRegistryClient = new PredictionApiKeyRegistryClient();

    // Call the API and handle any network failures.
    try {
        $predictionApiKeyRegistryClient->deletePredictionApiKeyRegistration($formattedName);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = PredictionApiKeyRegistryClient::predictionApiKeyRegistrationName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[EVENT_STORE]',
        '[PREDICTION_API_KEY_REGISTRATION]'
    );

    delete_prediction_api_key_registration_sample($formattedName);
}
// [END recommendationengine_v1beta1_generated_PredictionApiKeyRegistry_DeletePredictionApiKeyRegistration_sync]
