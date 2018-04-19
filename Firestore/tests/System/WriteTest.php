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

namespace Google\Cloud\Firestore\Tests\System;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;

/**
 * @group firestore
 * @group firestore-write
 */
class WriteTest extends FirestoreTestCase
{
    use TimeTrait;

    /**
     * @dataProvider timestamps
     */
    public function testTimestampPrecision($timestamp)
    {
        $doc = self::$collection->add([
            'timestampField' => $timestamp
        ]);

        $res = $doc->snapshot()['timestampField'];

        // update and read back (what should be the same) value.
        $doc->set([
            'timestampField' => $res
        ], ['merge' => true]);

        $res2 = $doc->snapshot()['timestampField'];

        $this->assertEquals($timestamp->get()->format('U'), $res->get()->format('U'));
        $this->assertEquals($timestamp->nanoSeconds(), $res->nanoSeconds());
        $this->assertEquals($timestamp->formatAsString(), $res->formatAsString());

        $this->assertEquals($timestamp->get()->format('U'), $res2->get()->format('U'));
        $this->assertEquals($timestamp->nanoSeconds(), $res2->nanoSeconds());
        $this->assertEquals($timestamp->formatAsString(), $res2->formatAsString());
    }

    /**
     * @dataProvider timestamps
     */
    public function testTimestampPrecisionLocale($timestamp)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        try {
            $doc = self::$collection->add([
                'timestampField' => $timestamp
            ]);

            $res = $doc->snapshot()['timestampField'];

            // update and read back (what should be the same) value.
            $doc->set([
                'timestampField' => $res
            ], ['merge' => true]);

            $res2 = $doc->snapshot()['timestampField'];

            $this->assertEquals($timestamp->get()->format('U'), $res->get()->format('U'));
            $this->assertEquals($timestamp->nanoSeconds(), $res->nanoSeconds());
            $this->assertEquals($timestamp->formatAsString(), $res->formatAsString());

            $this->assertEquals($timestamp->get()->format('U'), $res2->get()->format('U'));
            $this->assertEquals($timestamp->nanoSeconds(), $res2->nanoSeconds());
            $this->assertEquals($timestamp->formatAsString(), $res2->formatAsString());
        } finally {
            setlocale(LC_ALL, null);
        }
    }

    public function timestamps()
    {
        $today = new \DateTime;
        $str = $today->format('Y-m-d\TH:i:s');

        $r = new \ReflectionClass(Timestamp::class);
        return [
            [new Timestamp($today)],
            [new Timestamp($today, 0)],
            [new Timestamp($today, 1000)],
            [$r->newInstanceArgs($this->parseTimeString($str .'.100000000Z'))],
            [$r->newInstanceArgs($this->parseTimeString($str .'.000001Z'))],
            [$r->newInstanceArgs($this->parseTimeString($str .'.101999Z'))],
        ];
    }
}
