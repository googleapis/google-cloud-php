<?php
/*
 * Copyright 2026 Google LLC
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

// [START gkerecommender_v1_generated_GkeInferenceQuickstart_FetchProfiles_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\GkeRecommender\V1\Client\GkeInferenceQuickstartClient;
use Google\Cloud\GkeRecommender\V1\FetchProfilesRequest;
use Google\Cloud\GkeRecommender\V1\Profile;

/**
 * Fetches available profiles. A profile contains performance metrics and
 * cost information for a specific model server setup. Profiles can be
 * filtered by parameters. If no filters are provided, all profiles are
 * returned.
 *
 * Profiles display a single value per performance metric based on the
 * provided performance requirements. If no requirements are given, the
 * metrics represent the inflection point. See [Run best practice inference
 * with GKE Inference Quickstart
 * recipes](https://cloud.google.com/kubernetes-engine/docs/how-to/machine-learning/inference/inference-quickstart#how)
 * for details.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function fetch_profiles_sample(): void
{
    // Create a client.
    $gkeInferenceQuickstartClient = new GkeInferenceQuickstartClient();

    // Prepare the request message.
    $request = new FetchProfilesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $gkeInferenceQuickstartClient->fetchProfiles($request);

        /** @var Profile $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END gkerecommender_v1_generated_GkeInferenceQuickstart_FetchProfiles_sync]
