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

// [START aiplatform_v1_generated_FeatureOnlineStoreService_SearchNearestEntities_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\FeatureOnlineStoreServiceClient;
use Google\Cloud\AIPlatform\V1\NearestNeighborQuery;
use Google\Cloud\AIPlatform\V1\SearchNearestEntitiesRequest;
use Google\Cloud\AIPlatform\V1\SearchNearestEntitiesResponse;

/**
 * Search the nearest entities under a FeatureView.
 * Search only works for indexable feature view; if a feature view isn't
 * indexable, returns Invalid argument response.
 *
 * @param string $formattedFeatureView FeatureView resource format
 *                                     `projects/{project}/locations/{location}/featureOnlineStores/{featureOnlineStore}/featureViews/{featureView}`
 *                                     Please see {@see FeatureOnlineStoreServiceClient::featureViewName()} for help formatting this field.
 */
function search_nearest_entities_sample(string $formattedFeatureView): void
{
    // Create a client.
    $featureOnlineStoreServiceClient = new FeatureOnlineStoreServiceClient();

    // Prepare the request message.
    $query = new NearestNeighborQuery();
    $request = (new SearchNearestEntitiesRequest())
        ->setFeatureView($formattedFeatureView)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var SearchNearestEntitiesResponse $response */
        $response = $featureOnlineStoreServiceClient->searchNearestEntities($request);
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
    $formattedFeatureView = FeatureOnlineStoreServiceClient::featureViewName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURE_ONLINE_STORE]',
        '[FEATURE_VIEW]'
    );

    search_nearest_entities_sample($formattedFeatureView);
}
// [END aiplatform_v1_generated_FeatureOnlineStoreService_SearchNearestEntities_sync]
