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

// [START serviceusage_v1_generated_ServiceUsage_DisableService_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ServiceUsage\V1\Client\ServiceUsageClient;
use Google\Cloud\ServiceUsage\V1\DisableServiceRequest;
use Google\Cloud\ServiceUsage\V1\DisableServiceResponse;
use Google\Rpc\Status;

/**
 * Disable a service so that it can no longer be used with a project.
 * This prevents unintended usage that may cause unexpected billing
 * charges or security leaks.
 *
 * It is not valid to call the disable method on a service that is not
 * currently enabled. Callers will receive a `FAILED_PRECONDITION` status if
 * the target service is not currently enabled.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function disable_service_sample(): void
{
    // Create a client.
    $serviceUsageClient = new ServiceUsageClient();

    // Prepare the request message.
    $request = new DisableServiceRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $serviceUsageClient->disableService($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DisableServiceResponse $result */
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
// [END serviceusage_v1_generated_ServiceUsage_DisableService_sync]
