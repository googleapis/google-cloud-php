<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudchannel_v1_generated_CloudChannelService_ProvisionCloudIdentity_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Customer;
use Google\Rpc\Status;

/**
 * Creates a Cloud Identity for the given customer using the customer's
 * information, or the information provided here.
 *
 * Possible error codes:
 *
 * *  PERMISSION_DENIED:
 * * The customer doesn't belong to the reseller.
 * * You are not authorized to provision cloud identity id. See
 * https://support.google.com/channelservices/answer/9759265
 * *  INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * *  NOT_FOUND: The customer was not found.
 * *  ALREADY_EXISTS: The customer's primary email already exists. Retry
 * after changing the customer's primary contact email.
 * * INTERNAL: Any non-user error related to a technical issue in the
 * backend. Contact Cloud Channel support.
 * * UNKNOWN: Any non-user error related to a technical issue in the backend.
 * Contact Cloud Channel support.
 *
 * Return value:
 * The ID of a long-running operation.
 *
 * To get the results of the operation, call the GetOperation method of
 * CloudChannelOperationsService. The Operation metadata contains an
 * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
 *
 * @param string $formattedCustomer Resource name of the customer.
 *                                  Format: accounts/{account_id}/customers/{customer_id}
 *                                  Please see {@see CloudChannelServiceClient::customerName()} for help formatting this field.
 */
function provision_cloud_identity_sample(string $formattedCustomer): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudChannelServiceClient->provisionCloudIdentity($formattedCustomer);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Customer $result */
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
    $formattedCustomer = CloudChannelServiceClient::customerName('[ACCOUNT]', '[CUSTOMER]');

    provision_cloud_identity_sample($formattedCustomer);
}
// [END cloudchannel_v1_generated_CloudChannelService_ProvisionCloudIdentity_sync]
