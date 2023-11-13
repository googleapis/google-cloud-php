<?php
/**
 * Copyright 2023 Google LLC
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

use Google\Cloud\Dev\Command\UpdateDepsCommand;
use Google\Cloud\Dev\Composer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group dev
 */
class UpdateDepsCommandTest extends TestCase
{
    /**
     * @dataProvider provideUpdateDeps
     */
    public function testUpdateDeps(array $cmdOptions, array $json, array $expectedJson)
    {
        $tmpFile = sys_get_temp_dir() . '/composer.json';
        file_put_contents($tmpFile, json_encode($json));
        $cmdOptions['--component'] = [$tmpFile];
        $commandTester = new CommandTester(new UpdateDepsCommand());
        $commandTester->execute($cmdOptions);

        $this->assertEquals($expectedJson, json_decode(file_get_contents($tmpFile), true));
    }

    public function testBumpWithVersionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('You cannot supply both a package version and the --bump flag');

        $commandTester = new CommandTester(new UpdateDepsCommand());
        $commandTester->execute([
            'package' => 'google/gax',
            'version' => '1.2.3',
            '--bump' => true,
        ]);
    }

    public function testNoBumpOrVersionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('You must either supply a package version or the --bump flag');

        $commandTester = new CommandTester(new UpdateDepsCommand());
        $commandTester->execute([
            'package' => 'google/gax',
        ]);
    }

    public function testInvalidComponentWithLocalThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Component not found for package google/foo');

        $commandTester = new CommandTester(new UpdateDepsCommand());
        $commandTester->execute([
            'package' => 'google/foo',
            'version' => '1.2.3',
            '--local' => true,
        ]);
    }

    public function provideUpdateDeps()
    {
        return [
            // Update package (require)
            [
                ['package' => 'google/gax', 'version' => '4.5.6'],
                ['require' => ['google/gax' => '1.2.3']],
                ['require' => ['google/gax' => '4.5.6']],
            ],
            // Update package (require-dev)
            [
                ['package' => 'google/gax', 'version' => '4.5.6'],
                ['require-dev' => ['google/gax' => '1.2.3']],
                ['require-dev' => ['google/gax' => '4.5.6']],
            ],
            // Update package (doesn't exist)
            [
                ['package' => 'google/gax', 'version' => '4.5.6'],
                [],
                [],
            ],
            // Update package with add (require)
            [
                ['package' => 'google/gax', 'version' => '4.5.6', '--add' => true],
                [],
                ['require' => ['google/gax' => '4.5.6']],
            ],
            // Update package with add (require-dev)
            [
                ['package' => 'google/gax', 'version' => '4.5.6', '--add' => 'dev'],
                [],
                ['require-dev' => ['google/gax' => '4.5.6']],
            ],
            // Update package with bump (require-dev)
            [
                ['package' => 'google/gax', '--bump' => true],
                ['require' => ['google/gax' => '1.2.3']],
                ['require' => ['google/gax' => Composer::getLatestVersion('google/gax')]],
            ],
            // Update package with local
            [
                ['package' => 'google/cloud-core', 'version' => '1.100', '--local' => true],
                ['require' => ['google/cloud-core' => '1.2.3']],
                [
                    'require' => ['google/cloud-core' => '1.100'],
                    'repositories' => [
                        [
                            'type' => 'path',
                            'url' => '../Core',
                            'options' => ['versions' => ['google/cloud-core' => '1.100']],
                        ],
                    ],
                ],
            ],
        ];
    }
}
