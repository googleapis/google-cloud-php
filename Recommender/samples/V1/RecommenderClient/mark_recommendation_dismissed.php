<?php
/*
 * Copyright 2023 Google LLC
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

// [START recommender_v1_generated_Recommender_MarkRecommendationDismissed_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Recommender\V1\Client\RecommenderClient;
use Google\Cloud\Recommender\V1\MarkRecommendationDismissedRequest;
use Google\Cloud\Recommender\V1\Recommendation;

/**
 * Mark the Recommendation State as Dismissed. Users can use this method to
 * indicate to the Recommender API that an ACTIVE recommendation has to
 * be marked back as DISMISSED.
 *
 * MarkRecommendationDismissed can be applied to recommendations in ACTIVE
 * state.
 *
 * Requires the recommender.*.update IAM permission for the specified
 * recommender.
 *
 * @param string $formattedName Name of the recommendation. Please see
 *                              {@see RecommenderClient::recommendationName()} for help formatting this field.
 */
function mark_recommendation_dismissed_sample(string $formattedName): void
{
    // Create a client.
    $recommenderClient = new RecommenderClient();

    // Prepare the request message.
    $request = (new MarkRecommendationDismissedRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Recommendation $response */
        $response = $recommenderClient->markRecommendationDismissed($request);
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

    mark_recommendation_dismissed_sample($formattedName);
}
// [END recommender_v1_generated_Recommender_MarkRecommendationDismissed_sync]
