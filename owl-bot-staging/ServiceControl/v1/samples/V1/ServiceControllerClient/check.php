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

// [START servicecontrol_v1_generated_ServiceController_Check_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceControl\V1\CheckResponse;
use Google\Cloud\ServiceControl\V1\ServiceControllerClient;

/**
 * Checks whether an operation on a service should be allowed to proceed
 * based on the configuration of the service and related policies. It must be
 * called before the operation is executed.
 *
 * If feasible, the client should cache the check results and reuse them for
 * 60 seconds. In case of any server errors, the client should rely on the
 * cached results for much longer time to avoid outage.
 * WARNING: There is general 60s delay for the configuration and policy
 * propagation, therefore callers MUST NOT depend on the `Check` method having
 * the latest policy information.
 *
 * NOTE: the [CheckRequest][google.api.servicecontrol.v1.CheckRequest] has
 * the size limit (wire-format byte size) of 1MB.
 *
 * This method requires the `servicemanagement.services.check` permission
 * on the specified service. For more information, see
 * [Cloud IAM](https://cloud.google.com/iam).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function check_sample(): void
{
    // Create a client.
    $serviceControllerClient = new ServiceControllerClient();

    // Call the API and handle any network failures.
    try {
        /** @var CheckResponse $response */
        $response = $serviceControllerClient->check();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END servicecontrol_v1_generated_ServiceController_Check_sync]
