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

// [START servicemanagement_v1_generated_ServiceManager_CreateServiceRollout_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ServiceManagement\V1\Rollout;
use Google\Cloud\ServiceManagement\V1\ServiceManagerClient;
use Google\Rpc\Status;

/**
 * Creates a new service configuration rollout. Based on rollout, the
 * Google Service Management will roll out the service configurations to
 * different backend services. For example, the logging configuration will be
 * pushed to Google Cloud Logging.
 *
 * Please note that any previous pending and running Rollouts and associated
 * Operations will be automatically cancelled so that the latest Rollout will
 * not be blocked by previous Rollouts.
 *
 * Only the 100 most recent (in any state) and the last 10 successful (if not
 * already part of the set of 100 most recent) rollouts are kept for each
 * service. The rest will be deleted eventually.
 *
 * Operation<response: Rollout>
 *
 * @param string $serviceName The name of the service.  See the
 *                            [overview](https://cloud.google.com/service-infrastructure/docs/overview) for naming requirements.  For
 *                            example: `example.googleapis.com`.
 */
function create_service_rollout_sample(string $serviceName): void
{
    // Create a client.
    $serviceManagerClient = new ServiceManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $rollout = new Rollout();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $serviceManagerClient->createServiceRollout($serviceName, $rollout);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Rollout $result */
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
    $serviceName = '[SERVICE_NAME]';

    create_service_rollout_sample($serviceName);
}
// [END servicemanagement_v1_generated_ServiceManager_CreateServiceRollout_sync]
