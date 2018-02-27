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

namespace Google\Cloud\Spanner\Tests\Snippet\Batch;

/**
 * Shared snippet tests for partitions.
 */
trait PartitionSharedSnippetTestTrait
{
    private $partition;
    private $token = 'token';
    private $options = ['hello' => 'world'];

    public abstract function setUp();

    /**
     * @dataProvider provideSerializeSnippetIndex
     */
    public function testClassSerializeExamples($index)
    {
        $snippet = $this->snippetFromClass($this->className, $index);
        $snippet->addLocal('partition', $this->partition);

        $res = $snippet->invoke('partitionString');
        $this->assertEquals($this->partition->serialize(), $res->returnVal());
    }

    public function provideSerializeSnippetIndex()
    {
        return [[1],[2]];
    }

    /**
     * @dataProvider provideGetters
     */
    public function testGetters($name)
    {
        $snippet = $this->snippetFromMethod($this->className, $name);
        $snippet->addLocal('partition', $this->partition);

        $res = $snippet->invoke($name);
        $this->assertEquals($this->$name, $res->returnVal());
    }

    public function provideGetters()
    {
        return [['token'], ['options']];
    }

    public function testSerialize()
    {
        $snippet = $this->snippetFromMethod($this->className, 'serialize');
        $snippet->addLocal('partition', $this->partition);
        $res = $snippet->invoke('partitionString');
        $this->assertEquals($this->partition->serialize(), $res->returnVal());
    }
}
