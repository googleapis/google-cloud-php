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

// [START networkservices_v1_generated_DepService_UpdateAuthzExtension_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\AuthzExtension;
use Google\Cloud\NetworkServices\V1\Client\DepServiceClient;
use Google\Cloud\NetworkServices\V1\LoadBalancingScheme;
use Google\Cloud\NetworkServices\V1\UpdateAuthzExtensionRequest;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of the specified `AuthzExtension`
 * resource.
 *
 * @param string $authzExtensionName                Identifier. Name of the `AuthzExtension` resource in the
 *                                                  following format:
 *                                                  `projects/{project}/locations/{location}/authzExtensions/{authz_extension}`.
 * @param int    $authzExtensionLoadBalancingScheme All backend services and forwarding rules referenced by this
 *                                                  extension must share the same load balancing scheme. Supported values:
 *                                                  `INTERNAL_MANAGED`, `EXTERNAL_MANAGED`. For more information, refer to
 *                                                  [Backend services
 *                                                  overview](https://cloud.google.com/load-balancing/docs/backend-service).
 * @param string $authzExtensionAuthority           The `:authority` header in the gRPC request sent from Envoy
 *                                                  to the extension service.
 * @param string $authzExtensionService             The reference to the service that runs the extension.
 *
 *                                                  To configure a callout extension, `service` must be a fully-qualified
 *                                                  reference
 *                                                  to a [backend
 *                                                  service](https://cloud.google.com/compute/docs/reference/rest/v1/backendServices)
 *                                                  in the format:
 *                                                  `https://www.googleapis.com/compute/v1/projects/{project}/regions/{region}/backendServices/{backendService}`
 *                                                  or
 *                                                  `https://www.googleapis.com/compute/v1/projects/{project}/global/backendServices/{backendService}`.
 */
function update_authz_extension_sample(
    string $authzExtensionName,
    int $authzExtensionLoadBalancingScheme,
    string $authzExtensionAuthority,
    string $authzExtensionService
): void {
    // Create a client.
    $depServiceClient = new DepServiceClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $authzExtensionTimeout = new Duration();
    $authzExtension = (new AuthzExtension())
        ->setName($authzExtensionName)
        ->setLoadBalancingScheme($authzExtensionLoadBalancingScheme)
        ->setAuthority($authzExtensionAuthority)
        ->setService($authzExtensionService)
        ->setTimeout($authzExtensionTimeout);
    $request = (new UpdateAuthzExtensionRequest())
        ->setUpdateMask($updateMask)
        ->setAuthzExtension($authzExtension);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $depServiceClient->updateAuthzExtension($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AuthzExtension $result */
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
    $authzExtensionName = '[NAME]';
    $authzExtensionLoadBalancingScheme = LoadBalancingScheme::LOAD_BALANCING_SCHEME_UNSPECIFIED;
    $authzExtensionAuthority = '[AUTHORITY]';
    $authzExtensionService = '[SERVICE]';

    update_authz_extension_sample(
        $authzExtensionName,
        $authzExtensionLoadBalancingScheme,
        $authzExtensionAuthority,
        $authzExtensionService
    );
}
// [END networkservices_v1_generated_DepService_UpdateAuthzExtension_sync]
