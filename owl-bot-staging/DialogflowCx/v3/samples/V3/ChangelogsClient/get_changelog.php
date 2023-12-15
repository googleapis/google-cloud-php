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

// [START dialogflow_v3_generated_Changelogs_GetChangelog_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Changelog;
use Google\Cloud\Dialogflow\Cx\V3\ChangelogsClient;

/**
 * Retrieves the specified Changelog.
 *
 * @param string $formattedName The name of the changelog to get.
 *                              Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent
 *                              ID>/changelogs/<Changelog ID>`. Please see
 *                              {@see ChangelogsClient::changelogName()} for help formatting this field.
 */
function get_changelog_sample(string $formattedName): void
{
    // Create a client.
    $changelogsClient = new ChangelogsClient();

    // Call the API and handle any network failures.
    try {
        /** @var Changelog $response */
        $response = $changelogsClient->getChangelog($formattedName);
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
    $formattedName = ChangelogsClient::changelogName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[CHANGELOG]'
    );

    get_changelog_sample($formattedName);
}
// [END dialogflow_v3_generated_Changelogs_GetChangelog_sync]
