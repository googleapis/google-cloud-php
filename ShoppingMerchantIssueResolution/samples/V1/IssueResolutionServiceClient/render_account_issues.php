<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1_generated_IssueResolutionService_RenderAccountIssues_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\IssueResolution\V1\Client\IssueResolutionServiceClient;
use Google\Shopping\Merchant\IssueResolution\V1\RenderAccountIssuesRequest;
use Google\Shopping\Merchant\IssueResolution\V1\RenderAccountIssuesResponse;

/**
 * Provide a list of business's account issues with an issue resolution
 * content and available actions. This content and actions are meant to be
 * rendered and shown in third-party applications.
 *
 * @param string $formattedName The account to fetch issues for.
 *                              Format: `accounts/{account}`
 *                              Please see {@see IssueResolutionServiceClient::accountName()} for help formatting this field.
 */
function render_account_issues_sample(string $formattedName): void
{
    // Create a client.
    $issueResolutionServiceClient = new IssueResolutionServiceClient();

    // Prepare the request message.
    $request = (new RenderAccountIssuesRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var RenderAccountIssuesResponse $response */
        $response = $issueResolutionServiceClient->renderAccountIssues($request);
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
    $formattedName = IssueResolutionServiceClient::accountName('[ACCOUNT]');

    render_account_issues_sample($formattedName);
}
// [END merchantapi_v1_generated_IssueResolutionService_RenderAccountIssues_sync]
