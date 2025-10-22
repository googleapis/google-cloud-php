<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

//@codingStandardsIgnoreStart
class Fixtures
{
    public static function JSON_KEY_FIXTURE()
    {
        return __DIR__ . '/fixtures/json-key-fixture.json';
    }

    public static function SERVICE_ACCOUNT_FIXTURE(): array
    {
        return [
            'type' => 'service_account',
            'project_id' => 'example-project-12345',
            'private_key_id' => 'xyz',
            'client_email' => 'test-service-account@example-project-12345.iam.gserviceaccount.com',
            'client_id' => '123456789012345678901',
            'private_key' => 'xyz',
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/test-service-account%40example-project-12345.iam.gserviceaccount.com'
        ];
    }

    public static function SERVICE_FIXTURE()
    {
        return __DIR__ . '/fixtures/service-fixture.json';
    }

    public static function SERVICE_FIXTURE_BASEPATH()
    {
        return __DIR__ . '/fixtures/service-fixture-basepath.json';
    }
}
//@codingStandardsIgnoreEnd
