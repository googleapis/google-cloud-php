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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_RemoveIpOverride_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\IpOverrideData;
use Google\Cloud\RecaptchaEnterprise\V1\IpOverrideData\OverrideType;
use Google\Cloud\RecaptchaEnterprise\V1\RemoveIpOverrideRequest;
use Google\Cloud\RecaptchaEnterprise\V1\RemoveIpOverrideResponse;

/**
 * Removes an IP override from a key. The following restrictions hold:
 * * If the IP isn't found in an existing IP override, a `NOT_FOUND` error
 * is returned.
 * * If the IP is found in an existing IP override, but the
 * override type does not match, a `NOT_FOUND` error is returned.
 *
 * @param string $formattedName              The name of the key from which the IP override is removed, in the
 *                                           format `projects/{project}/keys/{key}`. Please see
 *                                           {@see RecaptchaEnterpriseServiceClient::keyName()} for help formatting this field.
 * @param string $ipOverrideDataIp           The IP address to override (can be IPv4, IPv6 or CIDR).
 *                                           The IP override must be a valid IPv4 or IPv6 address, or a CIDR range.
 *                                           The IP override must be a public IP address.
 *                                           Example of IPv4: 168.192.5.6
 *                                           Example of IPv6: 2001:0000:130F:0000:0000:09C0:876A:130B
 *                                           Example of IPv4 with CIDR: 168.192.5.0/24
 *                                           Example of IPv6 with CIDR: 2001:0DB8:1234::/48
 * @param int    $ipOverrideDataOverrideType Describes the type of IP override.
 */
function remove_ip_override_sample(
    string $formattedName,
    string $ipOverrideDataIp,
    int $ipOverrideDataOverrideType
): void {
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $ipOverrideData = (new IpOverrideData())
        ->setIp($ipOverrideDataIp)
        ->setOverrideType($ipOverrideDataOverrideType);
    $request = (new RemoveIpOverrideRequest())
        ->setName($formattedName)
        ->setIpOverrideData($ipOverrideData);

    // Call the API and handle any network failures.
    try {
        /** @var RemoveIpOverrideResponse $response */
        $response = $recaptchaEnterpriseServiceClient->removeIpOverride($request);
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
    $formattedName = RecaptchaEnterpriseServiceClient::keyName('[PROJECT]', '[KEY]');
    $ipOverrideDataIp = '[IP]';
    $ipOverrideDataOverrideType = OverrideType::OVERRIDE_TYPE_UNSPECIFIED;

    remove_ip_override_sample($formattedName, $ipOverrideDataIp, $ipOverrideDataOverrideType);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_RemoveIpOverride_sync]
