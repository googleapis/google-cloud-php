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

// [START cloudchannel_v1_generated_CloudChannelService_ListEntitlementChanges_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\EntitlementChange;
use Google\Cloud\Channel\V1\ListEntitlementChangesRequest;

/**
 * List entitlement history.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request and the
 * provided reseller account are different.
 * * INVALID_ARGUMENT: Missing or invalid required fields in the request.
 * * NOT_FOUND: The parent resource doesn't exist. Usually the result of an
 * invalid name parameter.
 * * INTERNAL: Any non-user error related to a technical issue in the backend.
 * In this case, contact CloudChannel support.
 * * UNKNOWN: Any non-user error related to a technical issue in the backend.
 * In this case, contact Cloud Channel support.
 *
 * Return value:
 * List of [EntitlementChange][google.cloud.channel.v1.EntitlementChange]s.
 *
 * @param string $formattedParent The resource name of the entitlement for which to list
 *                                entitlement changes. The `-` wildcard may be used to match entitlements
 *                                across a customer. Formats:
 *
 *                                * accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
 *                                * accounts/{account_id}/customers/{customer_id}/entitlements/-
 *                                Please see {@see CloudChannelServiceClient::entitlementName()} for help formatting this field.
 */
function list_entitlement_changes_sample(string $formattedParent): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new ListEntitlementChangesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudChannelServiceClient->listEntitlementChanges($request);

        /** @var EntitlementChange $element */
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
    $formattedParent = CloudChannelServiceClient::entitlementName(
        '[ACCOUNT]',
        '[CUSTOMER]',
        '[ENTITLEMENT]'
    );

    list_entitlement_changes_sample($formattedParent);
}
// [END cloudchannel_v1_generated_CloudChannelService_ListEntitlementChanges_sync]
