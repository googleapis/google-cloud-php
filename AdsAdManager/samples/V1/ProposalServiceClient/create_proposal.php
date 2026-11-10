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

// [START admanager_v1_generated_ProposalService_CreateProposal_sync]
use Google\Ads\AdManager\V1\Client\ProposalServiceClient;
use Google\Ads\AdManager\V1\CreateProposalRequest;
use Google\Ads\AdManager\V1\Proposal;
use Google\ApiCore\ApiException;

/**
 * Creates a `Proposal` object.
 *
 * @param string $formattedParent             The parent resource where this `Proposal` will be created.
 *                                            Format: `networks/{network_code}`
 *                                            Please see {@see ProposalServiceClient::networkName()} for help formatting this field.
 * @param string $proposalDisplayName         The display name of the Proposal. This value has a maximum length
 *                                            of 255 characters. This value is copied to
 *                                            [Order.displayName][google.ads.admanager.v1.Order.display_name] when the
 *                                            proposal turns into an order.
 * @param string $formattedProposalAdvertiser The resource name of the
 *                                            [Company][google.ads.admanager.v1.Company] of type
 *                                            [ADVERTISER][google.ads.admanager.v1.CompanyTypeEnum.CompanyType.ADVERTISER]
 *                                            to which this Proposal belongs. This attribute is required when the
 *                                            proposal turns into an order, and will be copied to
 *                                            [Order.advertiser][google.ads.admanager.v1.Order.advertiser].  This
 *                                            attribute becomes read-only once the Proposal has been pushed. Format:
 *                                            `networks/{network_code}/companies/{company_id}`
 *                                            Please see {@see ProposalServiceClient::companyName()} for help formatting this field.
 */
function create_proposal_sample(
    string $formattedParent,
    string $proposalDisplayName,
    string $formattedProposalAdvertiser
): void {
    // Create a client.
    $proposalServiceClient = new ProposalServiceClient();

    // Prepare the request message.
    $proposal = (new Proposal())
        ->setDisplayName($proposalDisplayName)
        ->setAdvertiser($formattedProposalAdvertiser);
    $request = (new CreateProposalRequest())
        ->setParent($formattedParent)
        ->setProposal($proposal);

    // Call the API and handle any network failures.
    try {
        /** @var Proposal $response */
        $response = $proposalServiceClient->createProposal($request);
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
    $formattedParent = ProposalServiceClient::networkName('[NETWORK_CODE]');
    $proposalDisplayName = '[DISPLAY_NAME]';
    $formattedProposalAdvertiser = ProposalServiceClient::companyName('[NETWORK_CODE]', '[COMPANY]');

    create_proposal_sample($formattedParent, $proposalDisplayName, $formattedProposalAdvertiser);
}
// [END admanager_v1_generated_ProposalService_CreateProposal_sync]
