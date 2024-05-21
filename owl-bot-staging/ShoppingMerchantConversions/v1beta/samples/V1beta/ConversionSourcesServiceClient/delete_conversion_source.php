<?php
/*
 * Copyright 2024 Google LLC
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

// [START merchantapi_v1beta_generated_ConversionSourcesService_DeleteConversionSource_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Conversions\V1beta\Client\ConversionSourcesServiceClient;
use Google\Shopping\Merchant\Conversions\V1beta\DeleteConversionSourceRequest;

/**
 * Archives an existing conversion source. If the conversion source is a
 * Merchant Center Destination, it will be recoverable for 30 days. If the
 * conversion source is a Google Analytics Link, it will be deleted
 * immediately and can be restored by creating a new one.
 *
 * @param string $formattedName The name of the conversion source to be deleted.
 *                              Format: accounts/{account}/conversionSources/{conversion_source}
 *                              Please see {@see ConversionSourcesServiceClient::conversionSourceName()} for help formatting this field.
 */
function delete_conversion_source_sample(string $formattedName): void
{
    // Create a client.
    $conversionSourcesServiceClient = new ConversionSourcesServiceClient();

    // Prepare the request message.
    $request = (new DeleteConversionSourceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $conversionSourcesServiceClient->deleteConversionSource($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = ConversionSourcesServiceClient::conversionSourceName(
        '[ACCOUNT]',
        '[CONVERSION_SOURCE]'
    );

    delete_conversion_source_sample($formattedName);
}
// [END merchantapi_v1beta_generated_ConversionSourcesService_DeleteConversionSource_sync]
