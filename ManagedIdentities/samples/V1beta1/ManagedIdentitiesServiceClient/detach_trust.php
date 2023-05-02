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

// [START managedidentities_v1beta1_generated_ManagedIdentitiesService_DetachTrust_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedIdentities\V1beta1\Domain;
use Google\Cloud\ManagedIdentities\V1beta1\ManagedIdentitiesServiceClient;
use Google\Cloud\ManagedIdentities\V1beta1\Trust;
use Google\Rpc\Status;

/**
 * Removes an AD trust.
 *
 * @param string $formattedName The resource domain name, project name, and location using the form:
 *                              `projects/{project_id}/locations/global/domains/{domain_name}`
 *                              Please see {@see ManagedIdentitiesServiceClient::domainName()} for help formatting this field.
 */
function detach_trust_sample(string $formattedName): void
{
    // Create a client.
    $managedIdentitiesServiceClient = new ManagedIdentitiesServiceClient();

    // Prepare the request message.
    $trust = new Trust();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedIdentitiesServiceClient->detachTrust($formattedName, $trust);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Domain $result */
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
    $formattedName = ManagedIdentitiesServiceClient::domainName('[PROJECT]', '[LOCATION]', '[DOMAIN]');

    detach_trust_sample($formattedName);
}
// [END managedidentities_v1beta1_generated_ManagedIdentitiesService_DetachTrust_sync]
