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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateSubpropertyEventFilter_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\SubpropertyEventFilter;
use Google\Analytics\Admin\V1alpha\SubpropertyEventFilterClause;
use Google\Analytics\Admin\V1alpha\SubpropertyEventFilterClause\FilterClauseType;
use Google\Analytics\Admin\V1alpha\SubpropertyEventFilterExpression;
use Google\ApiCore\ApiException;

/**
 * Creates a subproperty Event Filter.
 *
 * @param string $formattedParent                                     The ordinary property for which to create a subproperty event
 *                                                                    filter. Format: properties/property_id Example: properties/123
 *                                                                    Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param int    $subpropertyEventFilterFilterClausesFilterClauseType The type for the filter clause.
 */
function create_subproperty_event_filter_sample(
    string $formattedParent,
    int $subpropertyEventFilterFilterClausesFilterClauseType
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $subpropertyEventFilterFilterClausesFilterExpression = new SubpropertyEventFilterExpression();
    $subpropertyEventFilterClause = (new SubpropertyEventFilterClause())
        ->setFilterClauseType($subpropertyEventFilterFilterClausesFilterClauseType)
        ->setFilterExpression($subpropertyEventFilterFilterClausesFilterExpression);
    $subpropertyEventFilterFilterClauses = [$subpropertyEventFilterClause,];
    $subpropertyEventFilter = (new SubpropertyEventFilter())
        ->setFilterClauses($subpropertyEventFilterFilterClauses);

    // Call the API and handle any network failures.
    try {
        /** @var SubpropertyEventFilter $response */
        $response = $analyticsAdminServiceClient->createSubpropertyEventFilter(
            $formattedParent,
            $subpropertyEventFilter
        );
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
    $formattedParent = AnalyticsAdminServiceClient::propertyName('[PROPERTY]');
    $subpropertyEventFilterFilterClausesFilterClauseType = FilterClauseType::FILTER_CLAUSE_TYPE_UNSPECIFIED;

    create_subproperty_event_filter_sample(
        $formattedParent,
        $subpropertyEventFilterFilterClausesFilterClauseType
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateSubpropertyEventFilter_sync]
