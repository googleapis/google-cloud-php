<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\BigQuery\Tests\System;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Core\Testing\System\SystemTestCase;

class BigQueryTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';
    const ENCRYPTION_SERVICE_ACCOUNT_EMAIL_TEMPLATE = 'bq-%s@bigquery-encryption.iam.gserviceaccount.com';

    protected static $bucket;
    protected static $storageClient;
    protected static $client;
    protected static $dataset;
    protected static $legacyTable;
    protected static $table;
    private static $hasSetUp = false;

    public static function setUpBeforeClass(): void
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');

        self::$storageClient = new StorageClient([
            'keyFilePath' => $keyFilePath
        ]);

        self::$bucket = self::createBucket(self::$storageClient, uniqid(self::TESTING_PREFIX));

        self::$client = new BigQueryClient([
            'keyFilePath' => $keyFilePath
        ]);
        self::$dataset = self::createDataset(self::$client, uniqid(self::TESTING_PREFIX));
        $options['schemaFile'] = '/data/table-schema.json';
        self::$table = self::createTable(self::$dataset, uniqid(self::TESTING_PREFIX), $options);
        $options['schemaFile'] = '/data/legacy-table-schema.json';
        self::$legacyTable = self::createTable(self::$dataset, uniqid(self::TESTING_PREFIX), $options);

        self::$hasSetUp = true;
    }

    protected static function createTable(Dataset $dataset, $name = null, array $options = [])
    {
        if (!isset($options['schema'])) {
            if (isset($options['schemaFile'])) {
                $options['schema']['fields'] = json_decode(
                    file_get_contents(__DIR__ . $options['schemaFile']),
                    true
                );
            } else {
                $options['schema']['fields'] = json_decode(
                    file_get_contents(__DIR__ . '/data/table-schema.json'),
                    true
                );
            }
            unset($options['schemaFile']);
        }
        return $dataset->createTable($name ?: uniqid(self::TESTING_PREFIX), $options);
    }
}
