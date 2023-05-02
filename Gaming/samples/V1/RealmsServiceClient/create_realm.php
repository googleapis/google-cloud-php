<?php
/*
 * Copyright 2022 Google LLC
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

// [START gameservices_v1_generated_RealmsService_CreateRealm_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Gaming\V1\Realm;
use Google\Cloud\Gaming\V1\RealmsServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new realm in a given project and location.
 *
 * @param string $formattedParent The parent resource name, in the following form:
 *                                `projects/{project}/locations/{location}`. Please see
 *                                {@see RealmsServiceClient::locationName()} for help formatting this field.
 * @param string $realmId         The ID of the realm resource to be created.
 * @param string $realmTimeZone   Time zone where all policies targeting this realm are evaluated. The value
 *                                of this field must be from the IANA time zone database:
 *                                https://www.iana.org/time-zones.
 */
function create_realm_sample(
    string $formattedParent,
    string $realmId,
    string $realmTimeZone
): void {
    // Create a client.
    $realmsServiceClient = new RealmsServiceClient();

    // Prepare the request message.
    $realm = (new Realm())
        ->setTimeZone($realmTimeZone);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $realmsServiceClient->createRealm($formattedParent, $realmId, $realm);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Realm $result */
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
    $formattedParent = RealmsServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $realmId = '[REALM_ID]';
    $realmTimeZone = '[TIME_ZONE]';

    create_realm_sample($formattedParent, $realmId, $realmTimeZone);
}
// [END gameservices_v1_generated_RealmsService_CreateRealm_sync]
