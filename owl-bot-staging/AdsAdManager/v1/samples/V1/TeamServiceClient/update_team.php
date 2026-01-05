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

// [START admanager_v1_generated_TeamService_UpdateTeam_sync]
use Google\Ads\AdManager\V1\Client\TeamServiceClient;
use Google\Ads\AdManager\V1\Team;
use Google\Ads\AdManager\V1\UpdateTeamRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * API to update a `Team` object.
 *
 * @param string $teamDisplayName The name of the Team. This value has a maximum length of 127
 *                                characters.
 */
function update_team_sample(string $teamDisplayName): void
{
    // Create a client.
    $teamServiceClient = new TeamServiceClient();

    // Prepare the request message.
    $team = (new Team())
        ->setDisplayName($teamDisplayName);
    $updateMask = new FieldMask();
    $request = (new UpdateTeamRequest())
        ->setTeam($team)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Team $response */
        $response = $teamServiceClient->updateTeam($request);
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
    $teamDisplayName = '[DISPLAY_NAME]';

    update_team_sample($teamDisplayName);
}
// [END admanager_v1_generated_TeamService_UpdateTeam_sync]
