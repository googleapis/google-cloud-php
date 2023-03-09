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

// [START jobs_v4beta1_generated_Completion_CompleteQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Talent\V4beta1\CompleteQueryResponse;
use Google\Cloud\Talent\V4beta1\CompletionClient;

/**
 * Completes the specified prefix with keyword suggestions.
 * Intended for use by a job search auto-complete search box.
 *
 * @param string $formattedParent Resource name of tenant the completion is performed within.
 *
 *                                The format is "projects/{project_id}/tenants/{tenant_id}", for example,
 *                                "projects/foo/tenant/bar".
 *
 *                                If tenant id is unspecified, the default tenant is used, for
 *                                example, "projects/foo". Please see
 *                                {@see CompletionClient::projectName()} for help formatting this field.
 * @param string $query           The query used to generate suggestions.
 *
 *                                The maximum number of allowed characters is 255.
 * @param int    $pageSize        Completion result count.
 *
 *                                The maximum allowed page size is 10.
 */
function complete_query_sample(string $formattedParent, string $query, int $pageSize): void
{
    // Create a client.
    $completionClient = new CompletionClient();

    // Call the API and handle any network failures.
    try {
        /** @var CompleteQueryResponse $response */
        $response = $completionClient->completeQuery($formattedParent, $query, $pageSize);
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
    $formattedParent = CompletionClient::projectName('[PROJECT]');
    $query = '[QUERY]';
    $pageSize = 0;

    complete_query_sample($formattedParent, $query, $pageSize);
}
// [END jobs_v4beta1_generated_Completion_CompleteQuery_sync]
