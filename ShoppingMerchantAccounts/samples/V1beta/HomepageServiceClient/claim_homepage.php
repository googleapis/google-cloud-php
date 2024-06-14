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

// [START merchantapi_v1beta_generated_HomepageService_ClaimHomepage_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\ClaimHomepageRequest;
use Google\Shopping\Merchant\Accounts\V1beta\Client\HomepageServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\Homepage;

/**
 * Claims a store's homepage. Executing this method requires admin access.
 *
 * If the homepage is already claimed, this will recheck the
 * verification (unless the merchant is exempted from claiming, which also
 * exempts from verification) and return a successful response. If ownership
 * can no longer be verified, it will return an error, but it won't clear the
 * claim. In case of failure, a canonical error message will be returned:
 * * PERMISSION_DENIED: user doesn't have the necessary permissions on this
 * MC account;
 * * FAILED_PRECONDITION:
 * - The account is not a Merchant Center account;
 * - MC account doesn't have a homepage;
 * - claiming failed (in this case the error message will contain more
 * details).
 *
 * @param string $formattedName The name of the homepage to claim.
 *                              Format: `accounts/{account}/homepage`
 *                              Please see {@see HomepageServiceClient::homepageName()} for help formatting this field.
 */
function claim_homepage_sample(string $formattedName): void
{
    // Create a client.
    $homepageServiceClient = new HomepageServiceClient();

    // Prepare the request message.
    $request = (new ClaimHomepageRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Homepage $response */
        $response = $homepageServiceClient->claimHomepage($request);
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
    $formattedName = HomepageServiceClient::homepageName('[ACCOUNT]');

    claim_homepage_sample($formattedName);
}
// [END merchantapi_v1beta_generated_HomepageService_ClaimHomepage_sync]
