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

// [START recommender_v1_generated_Recommender_MarkRecommendationSucceeded_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Recommender\V1\Client\RecommenderClient;
use Google\Cloud\Recommender\V1\MarkRecommendationSucceededRequest;
use Google\Cloud\Recommender\V1\Recommendation;

/**
 * Marks the Recommendation State as Succeeded. Users can use this method to
 * indicate to the Recommender API that they have applied the recommendation
 * themselves, and the operation was successful. This stops the recommendation
 * content from being updated. Associated insights are frozen and placed in
 * the ACCEPTED state.
 *
 * MarkRecommendationSucceeded can be applied to recommendations in ACTIVE,
 * CLAIMED, SUCCEEDED, or FAILED state.
 *
 * Requires the recommender.*.update IAM permission for the specified
 * recommender.
 *
 * @param string $formattedName Name of the recommendation. Please see
 *                              {@see RecommenderClient::recommendationName()} for help formatting this field.
 * @param string $etag          Fingerprint of the Recommendation. Provides optimistic locking.
 */
function mark_recommendation_succeeded_sample(string $formattedName, string $etag): void
{
    // Create a client.
    $recommenderClient = new RecommenderClient();

    // Prepare the request message.
    $request = (new MarkRecommendationSucceededRequest())
        ->setName($formattedName)
        ->setEtag($etag);

    // Call the API and handle any network failures.
    try {
        /** @var Recommendation $response */
        $response = $recommenderClient->markRecommendationSucceeded($request);
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
    $formattedName = RecommenderClient::recommendationName(
        '[PROJECT]',
        '[LOCATION]',
        '[RECOMMENDER]',
        '[RECOMMENDATION]'
    );
    $etag = '[ETAG]';

    mark_recommendation_succeeded_sample($formattedName, $etag);
}
// [END recommender_v1_generated_Recommender_MarkRecommendationSucceeded_sync]
