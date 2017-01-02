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

namespace Google\Cloud\Tests\Snippets\SpannerAdmin;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group spanneradmin
 */
class ConfigurationTest extends SnippetTestCase
{
    const PROJECT = 'my-awesome-project';
    const CONFIG = 'regional-europe-west';

    private $connection;
    private $config;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->config = \Google\Cloud\Dev\stub(Configuration::class, [
            $this->connection->reveal(),
            self::PROJECT,
            self::CONFIG
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Configuration::class);
        $res = $snippet->invoke('configuration');

        $this->assertInstanceOf(Configuration::class, $res->returnVal());
        $this->assertEquals(self::CONFIG, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Configuration::class, 'name');
        $snippet->addLocal('configuration', $this->config);

        $res = $snippet->invoke('name');
        $this->assertEquals(self::CONFIG, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Configuration::class, 'info');
        $snippet->addLocal('configuration', $this->config);

        $this->connection->getConfig(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'projects/'. self::PROJECT .'/instanceConfigs/'. self::CONFIG,
                'displayName' => self::CONFIG
            ]);

        $this->config->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::CONFIG, $res->output());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Configuration::class, 'exists');
        $snippet->addLocal('configuration', $this->config);

        $this->connection->getConfig(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'projects/'. self::PROJECT .'/instanceConfigs/'. self::CONFIG,
                'displayName' => self::CONFIG
            ]);

        $this->config->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Configuration exists!', $res->output());
    }

    public function testReload()
    {
        $info = [
            'name' => 'projects/'. self::PROJECT .'/instanceConfigs/'. self::CONFIG,
            'displayName' => self::CONFIG
        ];

        $snippet = $this->snippetFromMethod(Configuration::class, 'reload');
        $snippet->addLocal('configuration', $this->config);

        $this->connection->getConfig(Argument::any())
            ->shouldBeCalled()
            ->willReturn($info);

        $this->config->setConnection($this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }
}
