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

// [START iap_v1_generated_IdentityAwareProxyAdminService_ValidateIapAttributeExpression_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iap\V1\Client\IdentityAwareProxyAdminServiceClient;
use Google\Cloud\Iap\V1\ValidateIapAttributeExpressionRequest;
use Google\Cloud\Iap\V1\ValidateIapAttributeExpressionResponse;

/**
 * Validates that a given CEL expression conforms to IAP restrictions.
 *
 * @param string $name       The resource name of the IAP protected resource.
 * @param string $expression User input string expression. Should be of the form
 *                           `attributes.saml_attributes.filter(attribute, attribute.name in
 *                           ['{attribute_name}', '{attribute_name}'])`
 */
function validate_iap_attribute_expression_sample(string $name, string $expression): void
{
    // Create a client.
    $identityAwareProxyAdminServiceClient = new IdentityAwareProxyAdminServiceClient();

    // Prepare the request message.
    $request = (new ValidateIapAttributeExpressionRequest())
        ->setName($name)
        ->setExpression($expression);

    // Call the API and handle any network failures.
    try {
        /** @var ValidateIapAttributeExpressionResponse $response */
        $response = $identityAwareProxyAdminServiceClient->validateIapAttributeExpression($request);
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
    $name = '[NAME]';
    $expression = '[EXPRESSION]';

    validate_iap_attribute_expression_sample($name, $expression);
}
// [END iap_v1_generated_IdentityAwareProxyAdminService_ValidateIapAttributeExpression_sync]
