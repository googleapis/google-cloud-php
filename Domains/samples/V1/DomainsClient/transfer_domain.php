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

// [START domains_v1_generated_Domains_TransferDomain_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Domains\V1\Client\DomainsClient;
use Google\Cloud\Domains\V1\Registration;
use Google\Cloud\Domains\V1\TransferDomainRequest;
use Google\Rpc\Status;

/**
 * Transfers a domain name from another registrar to Cloud Domains.  For
 * domains managed by Google Domains, transferring to Cloud Domains is not
 * supported.
 *
 *
 * Before calling this method, go to the domain's current registrar to unlock
 * the domain for transfer and retrieve the domain's transfer authorization
 * code. Then call `RetrieveTransferParameters` to confirm that the domain is
 * unlocked and to get values needed to build a call to this method.
 *
 * A successful call creates a `Registration` resource in state
 * `TRANSFER_PENDING`. It can take several days to complete the transfer
 * process. The registrant can often speed up this process by approving the
 * transfer through the current registrar, either by clicking a link in an
 * email from the registrar or by visiting the registrar's website.
 *
 * A few minutes after transfer approval, the resource transitions to state
 * `ACTIVE`, indicating that the transfer was successful. If the transfer is
 * rejected or the request expires without being approved, the resource can
 * end up in state `TRANSFER_FAILED`. If transfer fails, you can safely delete
 * the resource and retry the transfer.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function transfer_domain_sample(): void
{
    // Create a client.
    $domainsClient = new DomainsClient();

    // Prepare the request message.
    $request = new TransferDomainRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $domainsClient->transferDomain($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Registration $result */
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
// [END domains_v1_generated_Domains_TransferDomain_sync]
