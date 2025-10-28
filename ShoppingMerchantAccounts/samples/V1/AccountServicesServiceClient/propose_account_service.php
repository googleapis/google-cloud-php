<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1_generated_AccountServicesService_ProposeAccountService_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\AccountService;
use Google\Shopping\Merchant\Accounts\V1\Client\AccountServicesServiceClient;
use Google\Shopping\Merchant\Accounts\V1\ProposeAccountServiceRequest;

/**
 * Propose an account service.
 *
 * @param string $formattedParent The resource name of the parent account for the service.
 *                                Format: `accounts/{account}`
 *                                Please see {@see AccountServicesServiceClient::accountName()} for help formatting this field.
 * @param string $provider        The provider of the service. Either the reference to an account
 *                                such as `providers/123` or a well-known service provider (one of
 *                                `providers/GOOGLE_ADS` or `providers/GOOGLE_BUSINESS_PROFILE`).
 */
function propose_account_service_sample(string $formattedParent, string $provider): void
{
    // Create a client.
    $accountServicesServiceClient = new AccountServicesServiceClient();

    // Prepare the request message.
    $accountService = new AccountService();
    $request = (new ProposeAccountServiceRequest())
        ->setParent($formattedParent)
        ->setProvider($provider)
        ->setAccountService($accountService);

    // Call the API and handle any network failures.
    try {
        /** @var AccountService $response */
        $response = $accountServicesServiceClient->proposeAccountService($request);
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
    $formattedParent = AccountServicesServiceClient::accountName('[ACCOUNT]');
    $provider = '[PROVIDER]';

    propose_account_service_sample($formattedParent, $provider);
}
// [END merchantapi_v1_generated_AccountServicesService_ProposeAccountService_sync]
