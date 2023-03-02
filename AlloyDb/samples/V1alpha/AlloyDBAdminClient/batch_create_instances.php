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

// [START alloydb_v1alpha_generated_AlloyDBAdmin_BatchCreateInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AlloyDb\V1alpha\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1alpha\BatchCreateInstancesResponse;
use Google\Cloud\AlloyDb\V1alpha\CreateInstanceRequest;
use Google\Cloud\AlloyDb\V1alpha\CreateInstanceRequests;
use Google\Cloud\AlloyDb\V1alpha\Instance;
use Google\Cloud\AlloyDb\V1alpha\Instance\InstanceType;
use Google\Rpc\Status;

/**
 * Creates new instances under the given project, location and cluster.
 * There can be only one primary instance in a cluster. If the primary
 * instance exists in the cluster as well as this request, then API will
 * throw an error.
 * The primary instance should exist before any read pool instance is
 * created. If the primary instance is a part of the request payload, then
 * the API will take care of creating instances in the correct order.
 * This method is here to support Google-internal use cases, and is not meant
 * for external customers to consume. Please do not start relying on it; its
 * behavior is subject to change without notice.
 *
 * @param string $formattedParent                                    The name of the parent resource. Please see
 *                                                                   {@see AlloyDBAdminClient::clusterName()} for help formatting this field.
 * @param string $formattedRequestsCreateInstanceRequestsParent      The name of the parent resource. For the required format, see the
 *                                                                   comment on the Instance.name field. Please see
 *                                                                   {@see AlloyDBAdminClient::clusterName()} for help formatting this field.
 * @param string $requestsCreateInstanceRequestsInstanceId           ID of the requesting object.
 * @param int    $requestsCreateInstanceRequestsInstanceInstanceType The type of the instance. Specified at creation time.
 */
function batch_create_instances_sample(
    string $formattedParent,
    string $formattedRequestsCreateInstanceRequestsParent,
    string $requestsCreateInstanceRequestsInstanceId,
    int $requestsCreateInstanceRequestsInstanceInstanceType
): void {
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requestsCreateInstanceRequestsInstance = (new Instance())
        ->setInstanceType($requestsCreateInstanceRequestsInstanceInstanceType);
    $createInstanceRequest = (new CreateInstanceRequest())
        ->setParent($formattedRequestsCreateInstanceRequestsParent)
        ->setInstanceId($requestsCreateInstanceRequestsInstanceId)
        ->setInstance($requestsCreateInstanceRequestsInstance);
    $requestsCreateInstanceRequests = [$createInstanceRequest,];
    $requests = (new CreateInstanceRequests())
        ->setCreateInstanceRequests($requestsCreateInstanceRequests);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alloyDBAdminClient->batchCreateInstances($formattedParent, $requests);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchCreateInstancesResponse $result */
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
    $formattedParent = AlloyDBAdminClient::clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
    $formattedRequestsCreateInstanceRequestsParent = AlloyDBAdminClient::clusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]'
    );
    $requestsCreateInstanceRequestsInstanceId = '[INSTANCE_ID]';
    $requestsCreateInstanceRequestsInstanceInstanceType = InstanceType::INSTANCE_TYPE_UNSPECIFIED;

    batch_create_instances_sample(
        $formattedParent,
        $formattedRequestsCreateInstanceRequestsParent,
        $requestsCreateInstanceRequestsInstanceId,
        $requestsCreateInstanceRequestsInstanceInstanceType
    );
}
// [END alloydb_v1alpha_generated_AlloyDBAdmin_BatchCreateInstances_sync]
