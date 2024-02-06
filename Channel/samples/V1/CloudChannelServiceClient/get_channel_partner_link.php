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

// [START cloudchannel_v1_generated_CloudChannelService_GetChannelPartnerLink_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\ChannelPartnerLink;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\GetChannelPartnerLinkRequest;

/**
 * Returns the requested
 * [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource.
 * You must be a distributor to call this method.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request is different
 * from the reseller account in the API request.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: ChannelPartnerLink resource not found because of an
 * invalid channel partner link name.
 *
 * Return value:
 * The [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink]
 * resource.
 *
 * @param string $name The resource name of the channel partner link to retrieve.
 *                     Name uses the format: accounts/{account_id}/channelPartnerLinks/{id}
 *                     where {id} is the Cloud Identity ID of the partner.
 */
function get_channel_partner_link_sample(string $name): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new GetChannelPartnerLinkRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var ChannelPartnerLink $response */
        $response = $cloudChannelServiceClient->getChannelPartnerLink($request);
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
    $name = '[NAME]';

    get_channel_partner_link_sample($name);
}
// [END cloudchannel_v1_generated_CloudChannelService_GetChannelPartnerLink_sync]
