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

// [START domains_v1beta1_generated_Domains_RegisterDomain_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Domains\V1beta1\DomainsClient;
use Google\Cloud\Domains\V1beta1\Registration;
use Google\Rpc\Status;

/**
 * Registers a new domain name and creates a corresponding `Registration`
 * resource.
 *
 * Call `RetrieveRegisterParameters` first to check availability of the domain
 * name and determine parameters like price that are needed to build a call to
 * this method.
 *
 * A successful call creates a `Registration` resource in state
 * `REGISTRATION_PENDING`, which resolves to `ACTIVE` within 1-2
 * minutes, indicating that the domain was successfully registered. If the
 * resource ends up in state `REGISTRATION_FAILED`, it indicates that the
 * domain was not registered successfully, and you can safely delete the
 * resource and retry registration.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function register_domain_sample(): void
{
    // Create a client.
    $domainsClient = new DomainsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $domainsClient->registerDomain();
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Registration $result */
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
// [END domains_v1beta1_generated_Domains_RegisterDomain_sync]
