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

// [START iap_v1_generated_IdentityAwareProxyOAuthService_ListBrands_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iap\V1\Client\IdentityAwareProxyOAuthServiceClient;
use Google\Cloud\Iap\V1\ListBrandsRequest;
use Google\Cloud\Iap\V1\ListBrandsResponse;

/**
 * Lists the existing brands for the project.
 *
 * @param string $parent GCP Project number/id.
 *                       In the following format: projects/{project_number/id}.
 */
function list_brands_sample(string $parent): void
{
    // Create a client.
    $identityAwareProxyOAuthServiceClient = new IdentityAwareProxyOAuthServiceClient();

    // Prepare the request message.
    $request = (new ListBrandsRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var ListBrandsResponse $response */
        $response = $identityAwareProxyOAuthServiceClient->listBrands($request);
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
    $parent = '[PARENT]';

    list_brands_sample($parent);
}
// [END iap_v1_generated_IdentityAwareProxyOAuthService_ListBrands_sync]
