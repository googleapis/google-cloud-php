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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateAudience_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\Audience;
use Google\Analytics\Admin\V1alpha\AudienceFilterClause;
use Google\Analytics\Admin\V1alpha\AudienceFilterClause\AudienceClauseType;
use Google\ApiCore\ApiException;

/**
 * Creates an Audience.
 *
 * @param string $formattedParent                 Example format: properties/1234
 *                                                Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param string $audienceDisplayName             The display name of the Audience.
 * @param string $audienceDescription             The description of the Audience.
 * @param int    $audienceMembershipDurationDays  Immutable. The duration a user should stay in an Audience. It
 *                                                cannot be set to more than 540 days.
 * @param int    $audienceFilterClausesClauseType Specifies whether this is an include or exclude filter clause.
 */
function create_audience_sample(
    string $formattedParent,
    string $audienceDisplayName,
    string $audienceDescription,
    int $audienceMembershipDurationDays,
    int $audienceFilterClausesClauseType
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $audienceFilterClause = (new AudienceFilterClause())
        ->setClauseType($audienceFilterClausesClauseType);
    $audienceFilterClauses = [$audienceFilterClause,];
    $audience = (new Audience())
        ->setDisplayName($audienceDisplayName)
        ->setDescription($audienceDescription)
        ->setMembershipDurationDays($audienceMembershipDurationDays)
        ->setFilterClauses($audienceFilterClauses);

    // Call the API and handle any network failures.
    try {
        /** @var Audience $response */
        $response = $analyticsAdminServiceClient->createAudience($formattedParent, $audience);
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
    $audienceDisplayName = '[DISPLAY_NAME]';
    $audienceDescription = '[DESCRIPTION]';
    $audienceMembershipDurationDays = 0;
    $audienceFilterClausesClauseType = AudienceClauseType::AUDIENCE_CLAUSE_TYPE_UNSPECIFIED;

    create_audience_sample(
        $formattedParent,
        $audienceDisplayName,
        $audienceDescription,
        $audienceMembershipDurationDays,
        $audienceFilterClausesClauseType
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateAudience_sync]
