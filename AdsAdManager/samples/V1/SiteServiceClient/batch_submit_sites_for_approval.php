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

// [START admanager_v1_generated_SiteService_BatchSubmitSitesForApproval_sync]
use Google\Ads\AdManager\V1\BatchSubmitSitesForApprovalRequest;
use Google\Ads\AdManager\V1\BatchSubmitSitesForApprovalResponse;
use Google\Ads\AdManager\V1\Client\SiteServiceClient;
use Google\ApiCore\ApiException;

/**
 * Submits a list of `Site` objects for approval.
 *
 * @param string $formattedParent Format: `networks/{network_code}`
 *                                Please see {@see SiteServiceClient::networkName()} for help formatting this field.
 * @param string $namesElement    The resource names of the `Site` objects to submit for approval.
 */
function batch_submit_sites_for_approval_sample(
    string $formattedParent,
    string $namesElement
): void {
    // Create a client.
    $siteServiceClient = new SiteServiceClient();

    // Prepare the request message.
    $names = [$namesElement,];
    $request = (new BatchSubmitSitesForApprovalRequest())
        ->setParent($formattedParent)
        ->setNames($names);

    // Call the API and handle any network failures.
    try {
        /** @var BatchSubmitSitesForApprovalResponse $response */
        $response = $siteServiceClient->batchSubmitSitesForApproval($request);
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
    $formattedParent = SiteServiceClient::networkName('[NETWORK_CODE]');
    $namesElement = '[NAMES]';

    batch_submit_sites_for_approval_sample($formattedParent, $namesElement);
}
// [END admanager_v1_generated_SiteService_BatchSubmitSitesForApproval_sync]
