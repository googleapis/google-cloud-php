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

// [START cloudchannel_v1_generated_CloudChannelService_CreateChannelPartnerLink_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\ChannelPartnerLink;
use Google\Cloud\Channel\V1\ChannelPartnerLinkState;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\CreateChannelPartnerLinkRequest;

/**
 * Initiates a channel partner link between a distributor and a reseller, or
 * between resellers in an n-tier reseller channel.
 * Invited partners need to follow the invite_link_uri provided in the
 * response to accept. After accepting the invitation, a link is set up
 * between the two parties.
 * You must be a distributor to call this method.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request is different
 * from the reseller account in the API request.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * ALREADY_EXISTS: The ChannelPartnerLink sent in the request already
 * exists.
 * * NOT_FOUND: No Cloud Identity customer exists for provided domain.
 * * INTERNAL: Any non-user error related to a technical issue in the
 * backend. Contact Cloud Channel support.
 * * UNKNOWN: Any non-user error related to a technical issue in the backend.
 * Contact Cloud Channel support.
 *
 * Return value:
 * The new [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink]
 * resource.
 *
 * @param string $parent                                    Create a channel partner link for the provided reseller account's
 *                                                          resource name.
 *                                                          Parent uses the format: accounts/{account_id}
 * @param string $channelPartnerLinkResellerCloudIdentityId Cloud Identity ID of the linked reseller.
 * @param int    $channelPartnerLinkLinkState               State of the channel partner link.
 */
function create_channel_partner_link_sample(
    string $parent,
    string $channelPartnerLinkResellerCloudIdentityId,
    int $channelPartnerLinkLinkState
): void {
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $channelPartnerLink = (new ChannelPartnerLink())
        ->setResellerCloudIdentityId($channelPartnerLinkResellerCloudIdentityId)
        ->setLinkState($channelPartnerLinkLinkState);
    $request = (new CreateChannelPartnerLinkRequest())
        ->setParent($parent)
        ->setChannelPartnerLink($channelPartnerLink);

    // Call the API and handle any network failures.
    try {
        /** @var ChannelPartnerLink $response */
        $response = $cloudChannelServiceClient->createChannelPartnerLink($request);
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
    $parent = '[PARENT]';
    $channelPartnerLinkResellerCloudIdentityId = '[RESELLER_CLOUD_IDENTITY_ID]';
    $channelPartnerLinkLinkState = ChannelPartnerLinkState::CHANNEL_PARTNER_LINK_STATE_UNSPECIFIED;

    create_channel_partner_link_sample(
        $parent,
        $channelPartnerLinkResellerCloudIdentityId,
        $channelPartnerLinkLinkState
    );
}
// [END cloudchannel_v1_generated_CloudChannelService_CreateChannelPartnerLink_sync]
