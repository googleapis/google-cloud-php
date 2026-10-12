<?php
/*
 * Copyright 2026 Google LLC
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

// [START networkservices_v1beta1_generated_DepService_UpdateExtensionBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1beta1\Client\DepServiceClient;
use Google\Cloud\NetworkServices\V1beta1\ExtensionBinding;
use Google\Cloud\NetworkServices\V1beta1\ExtensionBinding\Target;
use Google\Cloud\NetworkServices\V1beta1\UpdateExtensionBindingRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of the specified `ExtensionBinding` resource.
 *
 * @param string $extensionBindingProducerExtension The name of the extension that this binding should attach to
 *                                                  target resources.
 *
 *                                                  Format:
 *                                                  For Google-provided extensions, specify the service endpoint (see
 *                                                  [Model Armor
 *                                                  integration](https://docs.cloud.google.com/model-armor/integrations))
 */
function update_extension_binding_sample(string $extensionBindingProducerExtension): void
{
    // Create a client.
    $depServiceClient = new DepServiceClient();

    // Prepare the request message.
    $extensionBindingTarget = new Target();
    $extensionBinding = (new ExtensionBinding())
        ->setProducerExtension($extensionBindingProducerExtension)
        ->setTarget($extensionBindingTarget);
    $request = (new UpdateExtensionBindingRequest())
        ->setExtensionBinding($extensionBinding);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $depServiceClient->updateExtensionBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExtensionBinding $result */
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
    $extensionBindingProducerExtension = '[PRODUCER_EXTENSION]';

    update_extension_binding_sample($extensionBindingProducerExtension);
}
// [END networkservices_v1beta1_generated_DepService_UpdateExtensionBinding_sync]
