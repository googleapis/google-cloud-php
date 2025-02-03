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

// [START backupdr_v1_generated_BackupDR_CreateBackupPlan_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1\BackupPlan;
use Google\Cloud\BackupDR\V1\BackupRule;
use Google\Cloud\BackupDR\V1\BackupWindow;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\CreateBackupPlanRequest;
use Google\Cloud\BackupDR\V1\StandardSchedule;
use Google\Cloud\BackupDR\V1\StandardSchedule\RecurrenceType;
use Google\Rpc\Status;

/**
 * Create a BackupPlan
 *
 * @param string $formattedParent                                                 The `BackupPlan` project and location in the format
 *                                                                                `projects/{project}/locations/{location}`. In Cloud BackupDR locations
 *                                                                                map to GCP regions, for example **us-central1**. Please see
 *                                                                                {@see BackupDRClient::locationName()} for help formatting this field.
 * @param string $backupPlanId                                                    The name of the `BackupPlan` to create. The name must be unique
 *                                                                                for the specified project and location.The name must start with a lowercase
 *                                                                                letter followed by up to 62 lowercase letters, numbers, or hyphens.
 *                                                                                Pattern, /[a-z][a-z0-9-]{,62}/.
 * @param string $backupPlanBackupRulesRuleId                                     Immutable. The unique id of this `BackupRule`. The `rule_id` is
 *                                                                                unique per `BackupPlan`.The `rule_id` must start with a lowercase letter
 *                                                                                followed by up to 62 lowercase letters, numbers, or hyphens. Pattern,
 *                                                                                /[a-z][a-z0-9-]{,62}/.
 * @param int    $backupPlanBackupRulesBackupRetentionDays                        Configures the duration for which backup data will be kept. It is
 *                                                                                defined in “days”. The value should be greater than or equal to minimum
 *                                                                                enforced retention of the backup vault.
 *
 *                                                                                Minimum value is 1 and maximum value is 90 for hourly backups.
 *                                                                                Minimum value is 1 and maximum value is 90 for daily backups.
 *                                                                                Minimum value is 7 and maximum value is 186 for weekly backups.
 *                                                                                Minimum value is 30 and maximum value is 732 for monthly backups.
 *                                                                                Minimum value is 365 and maximum value is 36159 for yearly backups.
 * @param int    $backupPlanBackupRulesStandardScheduleRecurrenceType             Specifies the `RecurrenceType` for the schedule.
 * @param int    $backupPlanBackupRulesStandardScheduleBackupWindowStartHourOfDay The hour of day (0-23) when the window starts for e.g. if value
 *                                                                                of start hour of day is 6 that mean backup window start at 6:00.
 * @param int    $backupPlanBackupRulesStandardScheduleBackupWindowEndHourOfDay   The hour of day (1-24) when the window end for e.g. if value of
 *                                                                                end hour of day is 10 that mean backup window end time is 10:00.
 *
 *                                                                                End hour of day should be greater than start hour of day.
 *                                                                                0 <= start_hour_of_day < end_hour_of_day <= 24
 *
 *                                                                                End hour of day is not include in backup window that mean if
 *                                                                                end_hour_of_day= 10 jobs should start before 10:00.
 * @param string $backupPlanBackupRulesStandardScheduleTimeZone                   The time zone to be used when interpreting the schedule.
 *                                                                                The value of this field must be a time zone name from the IANA tz database.
 *                                                                                See https://en.wikipedia.org/wiki/List_of_tz_database_time_zones for the
 *                                                                                list of valid timezone names. For e.g., Europe/Paris.
 * @param string $backupPlanResourceType                                          The resource type to which the `BackupPlan` will be applied.
 *                                                                                Examples include, "compute.googleapis.com/Instance",
 *                                                                                "sqladmin.googleapis.com/Instance", or "alloydb.googleapis.com/Cluster".
 * @param string $formattedBackupPlanBackupVault                                  Resource name of backup vault which will be used as storage
 *                                                                                location for backups. Format:
 *                                                                                projects/{project}/locations/{location}/backupVaults/{backupvault}
 *                                                                                Please see {@see BackupDRClient::backupVaultName()} for help formatting this field.
 */
function create_backup_plan_sample(
    string $formattedParent,
    string $backupPlanId,
    string $backupPlanBackupRulesRuleId,
    int $backupPlanBackupRulesBackupRetentionDays,
    int $backupPlanBackupRulesStandardScheduleRecurrenceType,
    int $backupPlanBackupRulesStandardScheduleBackupWindowStartHourOfDay,
    int $backupPlanBackupRulesStandardScheduleBackupWindowEndHourOfDay,
    string $backupPlanBackupRulesStandardScheduleTimeZone,
    string $backupPlanResourceType,
    string $formattedBackupPlanBackupVault
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $backupPlanBackupRulesStandardScheduleBackupWindow = (new BackupWindow())
        ->setStartHourOfDay($backupPlanBackupRulesStandardScheduleBackupWindowStartHourOfDay)
        ->setEndHourOfDay($backupPlanBackupRulesStandardScheduleBackupWindowEndHourOfDay);
    $backupPlanBackupRulesStandardSchedule = (new StandardSchedule())
        ->setRecurrenceType($backupPlanBackupRulesStandardScheduleRecurrenceType)
        ->setBackupWindow($backupPlanBackupRulesStandardScheduleBackupWindow)
        ->setTimeZone($backupPlanBackupRulesStandardScheduleTimeZone);
    $backupRule = (new BackupRule())
        ->setRuleId($backupPlanBackupRulesRuleId)
        ->setBackupRetentionDays($backupPlanBackupRulesBackupRetentionDays)
        ->setStandardSchedule($backupPlanBackupRulesStandardSchedule);
    $backupPlanBackupRules = [$backupRule,];
    $backupPlan = (new BackupPlan())
        ->setBackupRules($backupPlanBackupRules)
        ->setResourceType($backupPlanResourceType)
        ->setBackupVault($formattedBackupPlanBackupVault);
    $request = (new CreateBackupPlanRequest())
        ->setParent($formattedParent)
        ->setBackupPlanId($backupPlanId)
        ->setBackupPlan($backupPlan);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->createBackupPlan($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BackupPlan $result */
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
    $formattedParent = BackupDRClient::locationName('[PROJECT]', '[LOCATION]');
    $backupPlanId = '[BACKUP_PLAN_ID]';
    $backupPlanBackupRulesRuleId = '[RULE_ID]';
    $backupPlanBackupRulesBackupRetentionDays = 0;
    $backupPlanBackupRulesStandardScheduleRecurrenceType = RecurrenceType::RECURRENCE_TYPE_UNSPECIFIED;
    $backupPlanBackupRulesStandardScheduleBackupWindowStartHourOfDay = 0;
    $backupPlanBackupRulesStandardScheduleBackupWindowEndHourOfDay = 0;
    $backupPlanBackupRulesStandardScheduleTimeZone = '[TIME_ZONE]';
    $backupPlanResourceType = '[RESOURCE_TYPE]';
    $formattedBackupPlanBackupVault = BackupDRClient::backupVaultName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUPVAULT]'
    );

    create_backup_plan_sample(
        $formattedParent,
        $backupPlanId,
        $backupPlanBackupRulesRuleId,
        $backupPlanBackupRulesBackupRetentionDays,
        $backupPlanBackupRulesStandardScheduleRecurrenceType,
        $backupPlanBackupRulesStandardScheduleBackupWindowStartHourOfDay,
        $backupPlanBackupRulesStandardScheduleBackupWindowEndHourOfDay,
        $backupPlanBackupRulesStandardScheduleTimeZone,
        $backupPlanResourceType,
        $formattedBackupPlanBackupVault
    );
}
// [END backupdr_v1_generated_BackupDR_CreateBackupPlan_sync]
