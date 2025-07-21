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

// [START configdelivery_v1beta_generated_ConfigDelivery_UpdateFleetPackage_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ConfigDelivery\V1beta\Client\ConfigDeliveryClient;
use Google\Cloud\ConfigDelivery\V1beta\FleetPackage;
use Google\Cloud\ConfigDelivery\V1beta\FleetPackage\ResourceBundleSelector;
use Google\Cloud\ConfigDelivery\V1beta\FleetPackage\VariantSelector;
use Google\Cloud\ConfigDelivery\V1beta\UpdateFleetPackageRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single FleetPackage.
 *
 * @param string $fleetPackageVariantSelectorVariantNameTemplate variant_name_template is a template that can refer to
 *                                                               variables containing cluster membership metadata such as location,
 *                                                               name, and labels to generate the name of the variant for a target
 *                                                               cluster. The variable syntax is similar to the unix shell variables.
 *
 *                                                               Available variables are `${membership.name}`, `${membership.location}`,
 *                                                               `${membership.project}` and `${membership.labels['label_name']}`.
 *
 *                                                               If you want to deploy a specific variant, say "default" to all the
 *                                                               clusters, you can use "default" (string without any variables) as
 *                                                               the variant_name_template.
 */
function update_fleet_package_sample(string $fleetPackageVariantSelectorVariantNameTemplate): void
{
    // Create a client.
    $configDeliveryClient = new ConfigDeliveryClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $fleetPackageResourceBundleSelector = new ResourceBundleSelector();
    $fleetPackageVariantSelector = (new VariantSelector())
        ->setVariantNameTemplate($fleetPackageVariantSelectorVariantNameTemplate);
    $fleetPackage = (new FleetPackage())
        ->setResourceBundleSelector($fleetPackageResourceBundleSelector)
        ->setVariantSelector($fleetPackageVariantSelector);
    $request = (new UpdateFleetPackageRequest())
        ->setUpdateMask($updateMask)
        ->setFleetPackage($fleetPackage);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $configDeliveryClient->updateFleetPackage($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var FleetPackage $result */
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
    $fleetPackageVariantSelectorVariantNameTemplate = '[VARIANT_NAME_TEMPLATE]';

    update_fleet_package_sample($fleetPackageVariantSelectorVariantNameTemplate);
}
// [END configdelivery_v1beta_generated_ConfigDelivery_UpdateFleetPackage_sync]
