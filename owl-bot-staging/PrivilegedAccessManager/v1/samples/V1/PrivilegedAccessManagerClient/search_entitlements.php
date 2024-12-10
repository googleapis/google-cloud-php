<?php
/*
 * Copyright 2024 Google LLC
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

// [START privilegedaccessmanager_v1_generated_PrivilegedAccessManager_SearchEntitlements_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\PrivilegedAccessManager\V1\Client\PrivilegedAccessManagerClient;
use Google\Cloud\PrivilegedAccessManager\V1\Entitlement;
use Google\Cloud\PrivilegedAccessManager\V1\SearchEntitlementsRequest;
use Google\Cloud\PrivilegedAccessManager\V1\SearchEntitlementsRequest\CallerAccessType;

/**
 * `SearchEntitlements` returns entitlements on which the caller has the
 * specified access.
 *
 * @param string $formattedParent  The parent which owns the entitlement resources. Please see
 *                                 {@see PrivilegedAccessManagerClient::organizationLocationName()} for help formatting this field.
 * @param int    $callerAccessType Only entitlements where the calling user has this access are
 *                                 returned.
 */
function search_entitlements_sample(string $formattedParent, int $callerAccessType): void
{
    // Create a client.
    $privilegedAccessManagerClient = new PrivilegedAccessManagerClient();

    // Prepare the request message.
    $request = (new SearchEntitlementsRequest())
        ->setParent($formattedParent)
        ->setCallerAccessType($callerAccessType);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $privilegedAccessManagerClient->searchEntitlements($request);

        /** @var Entitlement $element */
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
    $formattedParent = PrivilegedAccessManagerClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );
    $callerAccessType = CallerAccessType::CALLER_ACCESS_TYPE_UNSPECIFIED;

    search_entitlements_sample($formattedParent, $callerAccessType);
}
// [END privilegedaccessmanager_v1_generated_PrivilegedAccessManager_SearchEntitlements_sync]
