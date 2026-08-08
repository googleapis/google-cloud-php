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

// [START compute_v1_generated_Hosts_Get_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Compute\V1\Client\HostsClient;
use Google\Cloud\Compute\V1\GetHostRequest;
use Google\Cloud\Compute\V1\Host;

/**
 * Retrieves information about the specified host.
 *
 * @param string $association The parent resource association for the Host. This field specifies the
 *                            hierarchical context (e.g., reservation, block, sub-block) when
 *                            accessing the host. For example, reservations/reservation_name,
 *                            reservations/reservation_name/reservationBlocks/reservation_block_name or
 *                            reservations/reservation_name/reservationBlocks/reservation_block_name/reservationSubBlocks/reservation_sub_block_name.
 * @param string $host        The name of the host, formatted as RFC1035 or a resource ID
 *                            number.
 * @param string $project     The project ID for this request.
 * @param string $zone        The name of the zone for this request, formatted as RFC1035.
 */
function get_sample(string $association, string $host, string $project, string $zone): void
{
    // Create a client.
    $hostsClient = new HostsClient();

    // Prepare the request message.
    $request = (new GetHostRequest())
        ->setAssociation($association)
        ->setHost($host)
        ->setProject($project)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var Host $response */
        $response = $hostsClient->get($request);
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
    $association = '[ASSOCIATION]';
    $host = '[HOST]';
    $project = '[PROJECT]';
    $zone = '[ZONE]';

    get_sample($association, $host, $project, $zone);
}
// [END compute_v1_generated_Hosts_Get_sync]
