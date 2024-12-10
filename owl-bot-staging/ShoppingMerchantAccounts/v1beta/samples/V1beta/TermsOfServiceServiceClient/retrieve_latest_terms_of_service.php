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

// [START merchantapi_v1beta_generated_TermsOfServiceService_RetrieveLatestTermsOfService_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1beta\Client\TermsOfServiceServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\RetrieveLatestTermsOfServiceRequest;
use Google\Shopping\Merchant\Accounts\V1beta\TermsOfService;
use Google\Shopping\Merchant\Accounts\V1beta\TermsOfServiceKind;

/**
 * Retrieves the latest version of the `TermsOfService` for a given `kind` and
 * `region_code`.
 *
 * @param string $regionCode Region code as defined by [CLDR](https://cldr.unicode.org/). This
 *                           is either a country when the ToS applies specifically to that country or
 *                           001 when it applies globally.
 * @param int    $kind       The Kind this terms of service version applies to.
 */
function retrieve_latest_terms_of_service_sample(string $regionCode, int $kind): void
{
    // Create a client.
    $termsOfServiceServiceClient = new TermsOfServiceServiceClient();

    // Prepare the request message.
    $request = (new RetrieveLatestTermsOfServiceRequest())
        ->setRegionCode($regionCode)
        ->setKind($kind);

    // Call the API and handle any network failures.
    try {
        /** @var TermsOfService $response */
        $response = $termsOfServiceServiceClient->retrieveLatestTermsOfService($request);
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
    $regionCode = '[REGION_CODE]';
    $kind = TermsOfServiceKind::TERMS_OF_SERVICE_KIND_UNSPECIFIED;

    retrieve_latest_terms_of_service_sample($regionCode, $kind);
}
// [END merchantapi_v1beta_generated_TermsOfServiceService_RetrieveLatestTermsOfService_sync]
