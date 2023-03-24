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

// [START analyticsadmin_v1beta_generated_AnalyticsAdminService_CreateProperty_sync]
use Google\Analytics\Admin\V1beta\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1beta\Property;
use Google\ApiCore\ApiException;

/**
 * Creates an "GA4" property with the specified location and attributes.
 *
 * @param string $propertyDisplayName Human-readable display name for this property.
 *
 *                                    The max allowed display name length is 100 UTF-16 code units.
 * @param string $propertyTimeZone    Reporting Time Zone, used as the day boundary for reports,
 *                                    regardless of where the data originates. If the time zone honors DST,
 *                                    Analytics will automatically adjust for the changes.
 *
 *                                    NOTE: Changing the time zone only affects data going forward, and is not
 *                                    applied retroactively.
 *
 *                                    Format: https://www.iana.org/time-zones
 *                                    Example: "America/Los_Angeles"
 */
function create_property_sample(string $propertyDisplayName, string $propertyTimeZone): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $property = (new Property())
        ->setDisplayName($propertyDisplayName)
        ->setTimeZone($propertyTimeZone);

    // Call the API and handle any network failures.
    try {
        /** @var Property $response */
        $response = $analyticsAdminServiceClient->createProperty($property);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $propertyDisplayName = '[DISPLAY_NAME]';
    $propertyTimeZone = '[TIME_ZONE]';

    create_property_sample($propertyDisplayName, $propertyTimeZone);
}
// [END analyticsadmin_v1beta_generated_AnalyticsAdminService_CreateProperty_sync]
