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

// [START privilegedaccessmanager_v1_generated_PrivilegedAccessManager_UpdateEntitlement_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\PrivilegedAccessManager\V1\Client\PrivilegedAccessManagerClient;
use Google\Cloud\PrivilegedAccessManager\V1\Entitlement;
use Google\Cloud\PrivilegedAccessManager\V1\Entitlement\RequesterJustificationConfig;
use Google\Cloud\PrivilegedAccessManager\V1\UpdateEntitlementRequest;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the entitlement specified in the request. Updated fields in the
 * entitlement need to be specified in an update mask. The changes made to an
 * entitlement are applicable only on future grants of the entitlement.
 * However, if new approvers are added or existing approvers are removed from
 * the approval workflow, the changes are effective on existing grants.
 *
 * The following fields are not supported for updates:
 *
 * * All immutable fields
 * * Entitlement name
 * * Resource name
 * * Resource type
 * * Adding an approval workflow in an entitlement which previously had no
 * approval workflow.
 * * Deleting the approval workflow from an entitlement.
 * * Adding or deleting a step in the approval workflow (only one step is
 * supported)
 *
 * Note that updates are allowed on the list of approvers in an approval
 * workflow step.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_entitlement_sample(): void
{
    // Create a client.
    $privilegedAccessManagerClient = new PrivilegedAccessManagerClient();

    // Prepare the request message.
    $entitlementMaxRequestDuration = new Duration();
    $entitlementRequesterJustificationConfig = new RequesterJustificationConfig();
    $entitlement = (new Entitlement())
        ->setMaxRequestDuration($entitlementMaxRequestDuration)
        ->setRequesterJustificationConfig($entitlementRequesterJustificationConfig);
    $updateMask = new FieldMask();
    $request = (new UpdateEntitlementRequest())
        ->setEntitlement($entitlement)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $privilegedAccessManagerClient->updateEntitlement($request);
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
// [END privilegedaccessmanager_v1_generated_PrivilegedAccessManager_UpdateEntitlement_sync]
