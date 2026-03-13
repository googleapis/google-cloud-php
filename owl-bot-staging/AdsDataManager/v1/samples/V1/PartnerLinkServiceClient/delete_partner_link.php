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

// [START datamanager_v1_generated_PartnerLinkService_DeletePartnerLink_sync]
use Google\Ads\DataManager\V1\Client\PartnerLinkServiceClient;
use Google\Ads\DataManager\V1\DeletePartnerLinkRequest;
use Google\ApiCore\ApiException;

/**
 * Deletes a partner link for the given account.
 *
 * Authorization Headers:
 *
 * This method supports the following optional headers to define how the API
 * authorizes access for the request:
 *
 * * `login-account`: (Optional) The resource name of the account where the
 * Google Account of the credentials is a user. If not set, defaults to the
 * account of the request. Format:
 * `accountTypes/{loginAccountType}/accounts/{loginAccountId}`
 * * `linked-account`: (Optional) The resource name of the account with an
 * established product link to the `login-account`. Format:
 * `accountTypes/{linkedAccountType}/accounts/{linkedAccountId}`
 *
 * @param string $formattedName The resource name of the partner link to delete.
 *                              Format:
 *                              accountTypes/{account_type}/accounts/{account}/partnerLinks/{partner_link}
 *                              Please see {@see PartnerLinkServiceClient::partnerLinkName()} for help formatting this field.
 */
function delete_partner_link_sample(string $formattedName): void
{
    // Create a client.
    $partnerLinkServiceClient = new PartnerLinkServiceClient();

    // Prepare the request message.
    $request = (new DeletePartnerLinkRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $partnerLinkServiceClient->deletePartnerLink($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = PartnerLinkServiceClient::partnerLinkName(
        '[ACCOUNT_TYPE]',
        '[ACCOUNT]',
        '[PARTNER_LINK]'
    );

    delete_partner_link_sample($formattedName);
}
// [END datamanager_v1_generated_PartnerLinkService_DeletePartnerLink_sync]
