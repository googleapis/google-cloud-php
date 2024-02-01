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

// [START recommender_v1_generated_Recommender_MarkInsightAccepted_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Recommender\V1\Client\RecommenderClient;
use Google\Cloud\Recommender\V1\Insight;
use Google\Cloud\Recommender\V1\MarkInsightAcceptedRequest;

/**
 * Marks the Insight State as Accepted. Users can use this method to
 * indicate to the Recommender API that they have applied some action based
 * on the insight. This stops the insight content from being updated.
 *
 * MarkInsightAccepted can be applied to insights in ACTIVE state. Requires
 * the recommender.*.update IAM permission for the specified insight.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function mark_insight_accepted_sample(): void
{
    // Create a client.
    $recommenderClient = new RecommenderClient();

    // Prepare the request message.
    $request = new MarkInsightAcceptedRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Insight $response */
        $response = $recommenderClient->markInsightAccepted($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END recommender_v1_generated_Recommender_MarkInsightAccepted_sync]
