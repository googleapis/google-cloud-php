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

// [START cloudsupport_v2beta_generated_SupportEventSubscriptionService_ExpungeSupportEventSubscription_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2beta\Client\SupportEventSubscriptionServiceClient;
use Google\Cloud\Support\V2beta\ExpungeSupportEventSubscriptionRequest;

/**
 * Expunges a support event subscription.
 *
 * EXAMPLES:
 *
 * cURL:
 *
 * ```shell
 * support_event_subscription="organizations/123456789/supportEventSubscriptions/abcdef123456"
 * curl \
 * --request POST \
 * --header "Authorization: Bearer $(gcloud auth print-access-token)" \
 * "https://cloudsupport.googleapis.com/v2beta/$support_event_subscription:expunge"
 * ```
 *
 * Python:
 *
 * ```python
 * import googleapiclient.discovery
 *
 * api_version = "v2beta"
 * supportApiService = googleapiclient.discovery.build(
 * serviceName="cloudsupport",
 * version=api_version,
 * discoveryServiceUrl=f"https://cloudsupport.googleapis.com/$discovery/rest?version={api_version}",
 * )
 *
 * request = supportApiService.supportEventSubscriptions().expunge(
 * name="organizations/123456789/supportEventSubscriptions/abcdef123456"
 * )
 * print(request.execute())
 * ```
 *
 * @param string $formattedName The name of the support event subscription to expunge.
 *                              Format:
 *                              organizations/{organization_id}/supportEventSubscriptions/{subscription_id}
 *                              Please see {@see SupportEventSubscriptionServiceClient::supportEventSubscriptionName()} for help formatting this field.
 */
function expunge_support_event_subscription_sample(string $formattedName): void
{
    // Create a client.
    $supportEventSubscriptionServiceClient = new SupportEventSubscriptionServiceClient();

    // Prepare the request message.
    $request = (new ExpungeSupportEventSubscriptionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $supportEventSubscriptionServiceClient->expungeSupportEventSubscription($request);
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
    $formattedName = SupportEventSubscriptionServiceClient::supportEventSubscriptionName(
        '[ORGANIZATION]',
        '[SUPPORT_EVENT_SUBSCRIPTION]'
    );

    expunge_support_event_subscription_sample($formattedName);
}
// [END cloudsupport_v2beta_generated_SupportEventSubscriptionService_ExpungeSupportEventSubscription_sync]
