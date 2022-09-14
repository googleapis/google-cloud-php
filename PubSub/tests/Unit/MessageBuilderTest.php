<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\PubSub\Tests\Unit;

use Google\Cloud\PubSub\MessageBuilder;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group pubsub
 * @group pubsub-message-builder
 */
class MessageBuilderTest extends TestCase
{
    use ExpectException;

    public function testSetters()
    {
        $expected = [
            'data' => 'hello',
            'attributes' => [
                'foo' => 'bar',
                'bat' => 'baz'
            ],
            'orderingKey' => 'test'
        ];
        $builder = new MessageBuilder;

        $builder = $builder->setData($expected['data'])
            ->setAttributes($expected['attributes'])
            ->addAttribute('extra', 'ok')
            ->setOrderingKey($expected['orderingKey']);

        $expected['attributes']['extra'] = 'ok';
        $this->assertEquals($expected, $builder->build()->toArray());
    }

    public function testMissingData()
    {
        $this->expectException('\BadMethodCallException');

        (new MessageBuilder)->build();
    }
}
