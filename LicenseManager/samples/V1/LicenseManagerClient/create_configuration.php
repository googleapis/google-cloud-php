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

// [START licensemanager_v1_generated_LicenseManager_CreateConfiguration_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\LicenseManager\V1\BillingInfo;
use Google\Cloud\LicenseManager\V1\Client\LicenseManagerClient;
use Google\Cloud\LicenseManager\V1\Configuration;
use Google\Cloud\LicenseManager\V1\CreateConfigurationRequest;
use Google\Cloud\LicenseManager\V1\LicenseType;
use Google\Cloud\LicenseManager\V1\UserCountBillingInfo;
use Google\Rpc\Status;

/**
 * Creates a new Configuration in a given project and location.
 *
 * @param string $formattedParent                                          Value for parent. Please see
 *                                                                         {@see LicenseManagerClient::locationName()} for help formatting this field.
 * @param string $configurationId                                          Id of the requesting object
 * @param string $configurationDisplayName                                 User given name.
 * @param string $formattedConfigurationProduct                            Name field (with URL) of the Product offered for SPLA. Please see
 *                                                                         {@see LicenseManagerClient::productName()} for help formatting this field.
 * @param int    $configurationLicenseType                                 LicenseType to be applied for billing
 * @param int    $configurationCurrentBillingInfoUserCountBillingUserCount Number of users to bill for.
 * @param int    $configurationNextBillingInfoUserCountBillingUserCount    Number of users to bill for.
 */
function create_configuration_sample(
    string $formattedParent,
    string $configurationId,
    string $configurationDisplayName,
    string $formattedConfigurationProduct,
    int $configurationLicenseType,
    int $configurationCurrentBillingInfoUserCountBillingUserCount,
    int $configurationNextBillingInfoUserCountBillingUserCount
): void {
    // Create a client.
    $licenseManagerClient = new LicenseManagerClient();

    // Prepare the request message.
    $configurationCurrentBillingInfoUserCountBilling = (new UserCountBillingInfo())
        ->setUserCount($configurationCurrentBillingInfoUserCountBillingUserCount);
    $configurationCurrentBillingInfo = (new BillingInfo())
        ->setUserCountBilling($configurationCurrentBillingInfoUserCountBilling);
    $configurationNextBillingInfoUserCountBilling = (new UserCountBillingInfo())
        ->setUserCount($configurationNextBillingInfoUserCountBillingUserCount);
    $configurationNextBillingInfo = (new BillingInfo())
        ->setUserCountBilling($configurationNextBillingInfoUserCountBilling);
    $configuration = (new Configuration())
        ->setDisplayName($configurationDisplayName)
        ->setProduct($formattedConfigurationProduct)
        ->setLicenseType($configurationLicenseType)
        ->setCurrentBillingInfo($configurationCurrentBillingInfo)
        ->setNextBillingInfo($configurationNextBillingInfo);
    $request = (new CreateConfigurationRequest())
        ->setParent($formattedParent)
        ->setConfigurationId($configurationId)
        ->setConfiguration($configuration);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $licenseManagerClient->createConfiguration($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Configuration $result */
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
    $formattedParent = LicenseManagerClient::locationName('[PROJECT]', '[LOCATION]');
    $configurationId = '[CONFIGURATION_ID]';
    $configurationDisplayName = '[DISPLAY_NAME]';
    $formattedConfigurationProduct = LicenseManagerClient::productName(
        '[PROJECT]',
        '[LOCATION]',
        '[PRODUCT]'
    );
    $configurationLicenseType = LicenseType::LICENSE_TYPE_UNSPECIFIED;
    $configurationCurrentBillingInfoUserCountBillingUserCount = 0;
    $configurationNextBillingInfoUserCountBillingUserCount = 0;

    create_configuration_sample(
        $formattedParent,
        $configurationId,
        $configurationDisplayName,
        $formattedConfigurationProduct,
        $configurationLicenseType,
        $configurationCurrentBillingInfoUserCountBillingUserCount,
        $configurationNextBillingInfoUserCountBillingUserCount
    );
}
// [END licensemanager_v1_generated_LicenseManager_CreateConfiguration_sync]
