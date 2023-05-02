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

// [START webrisk_v1_generated_WebRiskService_ComputeThreatListDiff_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\WebRisk\V1\ComputeThreatListDiffRequest\Constraints;
use Google\Cloud\WebRisk\V1\ComputeThreatListDiffResponse;
use Google\Cloud\WebRisk\V1\ThreatType;
use Google\Cloud\WebRisk\V1\WebRiskServiceClient;

/**
 * Gets the most recent threat list diffs. These diffs should be applied to
 * a local database of hashes to keep it up-to-date. If the local database is
 * empty or excessively out-of-date, a complete snapshot of the database will
 * be returned. This Method only updates a single ThreatList at a time. To
 * update multiple ThreatList databases, this method needs to be called once
 * for each list.
 *
 * @param int $threatType The threat list to update. Only a single ThreatType should be specified
 *                        per request. If you want to handle multiple ThreatTypes, you must make one
 *                        request per ThreatType.
 */
function compute_threat_list_diff_sample(int $threatType): void
{
    // Create a client.
    $webRiskServiceClient = new WebRiskServiceClient();

    // Prepare the request message.
    $constraints = new Constraints();

    // Call the API and handle any network failures.
    try {
        /** @var ComputeThreatListDiffResponse $response */
        $response = $webRiskServiceClient->computeThreatListDiff($threatType, $constraints);
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
    $threatType = ThreatType::THREAT_TYPE_UNSPECIFIED;

    compute_threat_list_diff_sample($threatType);
}
// [END webrisk_v1_generated_WebRiskService_ComputeThreatListDiff_sync]
