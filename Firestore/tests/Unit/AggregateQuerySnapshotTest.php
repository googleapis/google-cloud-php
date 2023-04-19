<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\AggregateQuerySnapshot;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-query
 */
class AggregateQuerySnapshotTest extends TestCase
{
    public function testTransactionId()
    {
        $testTransactionId = 'test123xyz';
        $aggregationQuerySnapshot = new AggregateQuerySnapshot([
            'transaction' => $testTransactionId
        ]);

        $this->assertEquals(
            $testTransactionId,
            $aggregationQuerySnapshot->getTransaction()
        );
    }

    public function testReadTime()
    {
        $readTime = (new \DateTime())->format(Timestamp::FORMAT);
        $aggregationQuerySnapshot = new AggregateQuerySnapshot([
            'readTime' => $readTime
        ]);

        $this->assertEquals(
            $readTime,
            $aggregationQuerySnapshot->getReadTime()
        );
    }

    public function testGetThrowsForInvalidKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('alias does not exist');

        $aggregationQuerySnapshot = new AggregateQuerySnapshot([
            'result' => ['aggregateFields' => []]
        ]);

        $aggregationQuerySnapshot->get('non_existing_alias');
    }

    public function testGetReturnsForValidKey()
    {
        $aggregationQuerySnapshot = new AggregateQuerySnapshot([
            'result' => [
                'aggregateFields' => [
                    'alias1' => ['integerValue' => 1],
                    'alias2' => ['integerValue' => 2],
                    'alias3' => ['integerValue' => 3],
                ]
            ]
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $this->assertEquals(
                $i,
                $aggregationQuerySnapshot->get('alias' . $i)
            );
        }
    }
}
