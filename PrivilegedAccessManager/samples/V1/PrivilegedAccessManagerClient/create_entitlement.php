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

// [START privilegedaccessmanager_v1_generated_PrivilegedAccessManager_CreateEntitlement_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\PrivilegedAccessManager\V1\Client\PrivilegedAccessManagerClient;
use Google\Cloud\PrivilegedAccessManager\V1\CreateEntitlementRequest;
use Google\Cloud\PrivilegedAccessManager\V1\Entitlement;
use Google\Cloud\PrivilegedAccessManager\V1\Entitlement\RequesterJustificationConfig;
use Google\Protobuf\Duration;
use Google\Rpc\Status;

/**
 * Creates a new entitlement in a given project/folder/organization and
 * location.
 *
 * @param string $formattedParent Name of the parent resource for the entitlement.
 *                                Possible formats:
 *
 *                                * `organizations/{organization-number}/locations/{region}`
 *                                * `folders/{folder-number}/locations/{region}`
 *                                * `projects/{project-id|project-number}/locations/{region}`
 *                                Please see {@see PrivilegedAccessManagerClient::organizationLocationName()} for help formatting this field.
 * @param string $entitlementId   The ID to use for this entitlement. This becomes the last part of
 *                                the resource name.
 *
 *                                This value should be 4-63 characters in length, and valid characters are
 *                                "[a-z]", "[0-9]", and "-". The first character should be from [a-z].
 *
 *                                This value should be unique among all other entitlements under the
 *                                specified `parent`.
 */
function create_entitlement_sample(string $formattedParent, string $entitlementId): void
{
    // Create a client.
    $privilegedAccessManagerClient = new PrivilegedAccessManagerClient();

    // Prepare the request message.
    $entitlementMaxRequestDuration = new Duration();
    $entitlementRequesterJustificationConfig = new RequesterJustificationConfig();
    $entitlement = (new Entitlement())
        ->setMaxRequestDuration($entitlementMaxRequestDuration)
        ->setRequesterJustificationConfig($entitlementRequesterJustificationConfig);
    $request = (new CreateEntitlementRequest())
        ->setParent($formattedParent)
        ->setEntitlementId($entitlementId)
        ->setEntitlement($entitlement);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $privilegedAccessManagerClient->createEntitlement($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Entitlement $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $entitlementId = '[ENTITLEMENT_ID]';

    create_entitlement_sample($formattedParent, $entitlementId);
}
// [END privilegedaccessmanager_v1_generated_PrivilegedAccessManager_CreateEntitlement_sync]
