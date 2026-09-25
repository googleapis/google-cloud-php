<?php
/**
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit\Command;

use Google\Cloud\Dev\Command\RepoComplianceCommand;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group dev
 */
class RepoComplianceCommandTest extends TestCase
{
    public function testFailsWithoutToken()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A Github token is required (via --token or -t)');

        $commandTester = new CommandTester(new RepoComplianceCommand());
        $commandTester->execute([]);
    }
}
