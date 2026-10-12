<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\System;

/**
 * Manages shared database states across Spanner system tests to avoid provisioning
 * a new database for every test class.
 *
 * @internal
 */
class TestDatabaseManager
{
    public static $client;
    public static $instance;

    public static $sqlHasSetUp = false;
    public static $sqlDatabase;
    public static $sqlDbName;

    public static $pgHasSetUp = false;
    public static $pgDatabase;
    public static $pgDbName;
}
