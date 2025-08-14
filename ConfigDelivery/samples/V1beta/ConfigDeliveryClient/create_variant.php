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

// [START configdelivery_v1beta_generated_ConfigDelivery_CreateVariant_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ConfigDelivery\V1beta\Client\ConfigDeliveryClient;
use Google\Cloud\ConfigDelivery\V1beta\CreateVariantRequest;
use Google\Cloud\ConfigDelivery\V1beta\Variant;
use Google\Rpc\Status;

/**
 * Creates a new Variant in a given project, location, resource bundle, and
 * release.
 *
 * @param string $formattedParent         Value for parent. Please see
 *                                        {@see ConfigDeliveryClient::releaseName()} for help formatting this field.
 * @param string $variantId               Id of the requesting object
 * @param string $variantResourcesElement Input only. Unordered list. resources contain the kubernetes
 *                                        manifests (YAMLs) for this variant.
 */
function create_variant_sample(
    string $formattedParent,
    string $variantId,
    string $variantResourcesElement
): void {
    // Create a client.
    $configDeliveryClient = new ConfigDeliveryClient();

    // Prepare the request message.
    $variantResources = [$variantResourcesElement,];
    $variant = (new Variant())
        ->setResources($variantResources);
    $request = (new CreateVariantRequest())
        ->setParent($formattedParent)
        ->setVariantId($variantId)
        ->setVariant($variant);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $configDeliveryClient->createVariant($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Variant $result */
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
    $formattedParent = ConfigDeliveryClient::releaseName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESOURCE_BUNDLE]',
        '[RELEASE]'
    );
    $variantId = '[VARIANT_ID]';
    $variantResourcesElement = '[RESOURCES]';

    create_variant_sample($formattedParent, $variantId, $variantResourcesElement);
}
// [END configdelivery_v1beta_generated_ConfigDelivery_CreateVariant_sync]
