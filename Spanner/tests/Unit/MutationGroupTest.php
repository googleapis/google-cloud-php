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
use Google\Cloud\Spanner\MutationGroup;
use PHPUnit\Framework\TestCase;

class MutationGroupTest extends TestCase
{
    private MutationGroup $mutationGroup;

    public function setUp(): void
    {
        $this->mutationGroup = new MutationGroup(false);
    }

    public function testMutationGroup()
    {
        $this->mutationGroup->insert('Posts', ['foo' => 'bar'])
            ->insertOrUpdateBatch('Posts', [['foo' => 'bar']])
            ->replaceBatch('Posts', [['foo' => 'bar']])
            ->delete('Posts', new KeySet(['keys' => ['foo']]));

        $data = $this->mutationGroup->toArray();
        $this->assertEquals($data, ['mutations' => [
            ['insert' => [
                'table' => 'Posts',
                'columns' => ['foo'],
                'values' => ['bar']
            ]],
            ['insertOrUpdate' => [
                'table' => 'Posts',
                'columns' => ['foo'],
                'values' => ['bar']
            ]],
            ['replace' => [
                'table' => 'Posts',
                'columns' => ['foo'],
                'values' => ['bar']
            ]],
            ['delete' => [
                'table' => 'Posts',
                'keySet' => ['keys' => ['foo']],
            ]],
        ]]);
    }
}
