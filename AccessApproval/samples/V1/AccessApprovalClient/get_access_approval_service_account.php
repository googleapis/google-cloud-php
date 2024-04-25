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

// [START accessapproval_v1_generated_AccessApproval_GetAccessApprovalServiceAccount_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AccessApproval\V1\AccessApprovalServiceAccount;
use Google\Cloud\AccessApproval\V1\Client\AccessApprovalClient;
use Google\Cloud\AccessApproval\V1\GetAccessApprovalServiceAccountMessage;

/**
 * Retrieves the service account that is used by Access Approval to access KMS
 * keys for signing approved approval requests.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function get_access_approval_service_account_sample(): void
{
    // Create a client.
    $accessApprovalClient = new AccessApprovalClient();

    // Prepare the request message.
    $request = new GetAccessApprovalServiceAccountMessage();

    // Call the API and handle any network failures.
    try {
        /** @var AccessApprovalServiceAccount $response */
        $response = $accessApprovalClient->getAccessApprovalServiceAccount($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END accessapproval_v1_generated_AccessApproval_GetAccessApprovalServiceAccount_sync]
