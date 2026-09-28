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

// [START networksecurity_v1_generated_SSERealmService_CreateSACRealm_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\SSERealmServiceClient;
use Google\Cloud\NetworkSecurity\V1\CreateSACRealmRequest;
use Google\Cloud\NetworkSecurity\V1\SACRealm;
use Google\Rpc\Status;

/**
 * Creates a new SACRealm in a given project.
 *
 * @param string $formattedParent The parent, in the form `projects/{project}/locations/global`. Please see
 *                                {@see SSERealmServiceClient::locationName()} for help formatting this field.
 * @param string $sacRealmId      ID of the created realm.
 *                                The ID must be 1-63 characters long, and comply with
 *                                <a href="https://www.ietf.org/rfc/rfc1035.txt" target="_blank">RFC1035</a>.
 *                                Specifically, it must be 1-63 characters long and match the regular
 *                                expression `[a-z]([-a-z0-9]*[a-z0-9])?`
 *                                which means the first character must be a lowercase letter, and all
 *                                following characters must be a dash, lowercase letter, or digit, except
 *                                the last character, which cannot be a dash.
 */
function create_sac_realm_sample(string $formattedParent, string $sacRealmId): void
{
    // Create a client.
    $sSERealmServiceClient = new SSERealmServiceClient();

    // Prepare the request message.
    $sacRealm = new SACRealm();
    $request = (new CreateSACRealmRequest())
        ->setParent($formattedParent)
        ->setSacRealmId($sacRealmId)
        ->setSacRealm($sacRealm);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $sSERealmServiceClient->createSACRealm($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SACRealm $result */
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
    $formattedParent = SSERealmServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $sacRealmId = '[SAC_REALM_ID]';

    create_sac_realm_sample($formattedParent, $sacRealmId);
}
// [END networksecurity_v1_generated_SSERealmService_CreateSACRealm_sync]
