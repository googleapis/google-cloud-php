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

// [START accesscontextmanager_v1_generated_AccessContextManager_ListAccessPolicies_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Identity\AccessContextManager\V1\AccessPolicy;
use Google\Identity\AccessContextManager\V1\Client\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\ListAccessPoliciesRequest;

/**
 * Lists all [access policies]
 * [google.identity.accesscontextmanager.v1.AccessPolicy] in an
 * organization.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function list_access_policies_sample(): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Prepare the request message.
    $request = new ListAccessPoliciesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $accessContextManagerClient->listAccessPolicies($request);

        /** @var AccessPolicy $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END accesscontextmanager_v1_generated_AccessContextManager_ListAccessPolicies_sync]
