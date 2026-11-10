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

// [START admanager_v1_generated_ProposalService_FetchMarketplaceComments_sync]
use Google\Ads\AdManager\V1\Client\ProposalServiceClient;
use Google\Ads\AdManager\V1\FetchMarketplaceCommentsRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Fetches MarketplaceComments made on `Proposal`s.
 *
 * @param string $formattedParent       The parent resource where MarketplaceComments will be fetched
 *                                      from. Format: `networks/{network_code}`
 *                                      Please see {@see ProposalServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the Proposals for which to fetch
 *                                      marketplace comments. A maximum of 50 proposal names can be specified.
 *                                      Format: `networks/{network_code}/proposals/{proposal_id}`
 *                                      Please see {@see ProposalServiceClient::proposalName()} for help formatting this field.
 */
function fetch_marketplace_comments_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $proposalServiceClient = new ProposalServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement];
    $request = (new FetchMarketplaceCommentsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $proposalServiceClient->fetchMarketplaceComments($request);

        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $formattedParent = ProposalServiceClient::networkName('[NETWORK_CODE]');
    $formattedNamesElement = ProposalServiceClient::proposalName('[NETWORK_CODE]', '[PROPOSAL]');

    fetch_marketplace_comments_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_ProposalService_FetchMarketplaceComments_sync]
