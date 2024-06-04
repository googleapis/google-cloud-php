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

// [START merchantapi_v1beta_generated_HomepageService_UpdateHomepage_sync]
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;
use Google\Shopping\Merchant\Accounts\V1beta\Client\HomepageServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\Homepage;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateHomepageRequest;

/**
 * Updates a store's homepage. Executing this method requires admin access.
 *
 * @param string $homepageUri The URI (typically a URL) of the store's homepage.
 */
function update_homepage_sample(string $homepageUri): void
{
    // Create a client.
    $homepageServiceClient = new HomepageServiceClient();

    // Prepare the request message.
    $homepage = (new Homepage())
        ->setUri($homepageUri);
    $updateMask = new FieldMask();
    $request = (new UpdateHomepageRequest())
        ->setHomepage($homepage)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Homepage $response */
        $response = $homepageServiceClient->updateHomepage($request);
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
    $homepageUri = '[URI]';

    update_homepage_sample($homepageUri);
}
// [END merchantapi_v1beta_generated_HomepageService_UpdateHomepage_sync]
