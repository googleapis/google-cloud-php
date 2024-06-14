<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\MutationTrait;
use Google\Cloud\Spanner\ValueMapper;
use PHPUnit\Framework\TestCase;

class MutationTraitTest extends TestCase
{
    private MutationTraitImpl $impl;

    public function setUp(): void
    {
        $this->impl = new MutationTraitImpl();
    }

    public function testInsert()
    {
        $this->impl->insert('Posts', ['foo' => 'bar']);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['insert']['table']);
        $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
    }

    public function testInsertBatch()
    {
        $this->impl->insertBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['insert']['table']);
        $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
    }

    public function testUpdate()
    {
        $this->impl->update('Posts', ['foo' => 'bar']);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['update']['table']);
        $this->assertEquals('foo', $mutations[0]['update']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['update']['values'][0]);
    }

    public function testUpdateBatch()
    {
        $this->impl->updateBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['update']['table']);
        $this->assertEquals('foo', $mutations[0]['update']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['update']['values'][0]);
    }

    public function testInsertOrUpdate()
    {
        $this->impl->insertOrUpdate('Posts', ['foo' => 'bar']);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['insertOrUpdate']['table']);
        $this->assertEquals('foo', $mutations[0]['insertOrUpdate']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insertOrUpdate']['values'][0]);
    }

    public function testInsertOrUpdateBatch()
    {
        $this->impl->insertOrUpdateBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['insertOrUpdate']['table']);
        $this->assertEquals('foo', $mutations[0]['insertOrUpdate']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insertOrUpdate']['values'][0]);
    }

    public function testReplace()
    {
        $this->impl->replace('Posts', ['foo' => 'bar']);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['replace']['table']);
        $this->assertEquals('foo', $mutations[0]['replace']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['replace']['values'][0]);
    }

    public function testReplaceBatch()
    {
        $this->impl->replaceBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->impl->getMutations();

        $this->assertEquals('Posts', $mutations[0]['replace']['table']);
        $this->assertEquals('foo', $mutations[0]['replace']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['replace']['values'][0]);
    }

    public function testDelete()
    {
        $this->impl->delete('Posts', new KeySet(['keys' => ['foo']]));

        $mutations = $this->impl->getMutations();
        $this->assertEquals('Posts', $mutations[0]['delete']['table']);
        $this->assertEquals('foo', $mutations[0]['delete']['keySet']['keys'][0]);
        $this->assertArrayNotHasKey('all', $mutations[0]['delete']['keySet']);
    }
}

//@codingStandardsIgnoreStart
class MutationTraitImpl
{
    use MutationTrait {
        getMutations as public;
    }

    private ValueMapper $mapper;

    public function __construct()
    {
        $this->mapper = new ValueMapper(false);
    }
}
//@codingStandardsIgnoreEnd
