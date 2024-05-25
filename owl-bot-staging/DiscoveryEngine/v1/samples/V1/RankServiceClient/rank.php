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

// [START discoveryengine_v1_generated_RankService_Rank_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\RankServiceClient;
use Google\Cloud\DiscoveryEngine\V1\RankRequest;
use Google\Cloud\DiscoveryEngine\V1\RankResponse;
use Google\Cloud\DiscoveryEngine\V1\RankingRecord;

/**
 * Ranks a list of text records based on the given input query.
 *
 * @param string $formattedRankingConfig The resource name of the rank service config, such as
 *                                       `projects/{project_num}/locations/{location_id}/rankingConfigs/default_ranking_config`. Please see
 *                                       {@see RankServiceClient::rankingConfigName()} for help formatting this field.
 */
function rank_sample(string $formattedRankingConfig): void
{
    // Create a client.
    $rankServiceClient = new RankServiceClient();

    // Prepare the request message.
    $records = [new RankingRecord()];
    $request = (new RankRequest())
        ->setRankingConfig($formattedRankingConfig)
        ->setRecords($records);

    // Call the API and handle any network failures.
    try {
        /** @var RankResponse $response */
        $response = $rankServiceClient->rank($request);
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
    $formattedRankingConfig = RankServiceClient::rankingConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[RANKING_CONFIG]'
    );

    rank_sample($formattedRankingConfig);
}
// [END discoveryengine_v1_generated_RankService_Rank_sync]
