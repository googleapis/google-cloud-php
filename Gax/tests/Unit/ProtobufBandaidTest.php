<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\Testing\GeneratedTest;

class ProtobufBandaidTest extends GeneratedTest
{
    use TestTrait;

    /**
     * @dataProvider protobufMessageProvider
     */
    public function testCompare($expected, $actual)
    {
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider protobufMessageNotEqualProvider
     */
    public function testCompareNotEqual($expected, $actual)
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);
        $this->assertEquals($expected, $actual);
    }

    public function protobufMessageProvider()
    {
        $this->autoloadTestdata('generated');
        $this->autoloadTestdata('generated/metadata', 'GPBMetadata\\'  . __NAMESPACE__);

        $msg1 = new MyMessage();
        $msg2 = new Mymessage();

        $v1 = new \Google\Protobuf\Value();
        $v1->setStringValue('TEST');
        $v2 = new \Google\Protobuf\Value();
        $v2->setStringValue('test');

        $struct1 = new \Google\Protobuf\Struct();
        $struct1->setFields(['TEST' => $v1, 'test' => $v2]);

        $struct2 = new \Google\Protobuf\Struct();
        $struct2->setFields(['test' => $v2, 'TEST' => $v1]);

        return [
            [$msg1, $msg2],
            [[$msg1, $msg2], [$msg1, $msg2]],
            [$struct1, $struct2],
        ];
    }

    public function protobufMessageNotEqualProvider()
    {
        $v1 = new \Google\Protobuf\Value();
        $v1->setStringValue('TEST');
        $v2 = new \Google\Protobuf\Value();
        $v2->setStringValue('test');

        $struct1 = new \Google\Protobuf\Struct();
        $struct1->setFields(['TEST' => $v1]);

        $struct2 = new \Google\Protobuf\Struct();
        $struct2->setFields(['test' => $v2]);

        $status = new \Google\Rpc\Status();
        $color = new \Google\Type\Color();

        return [
            [$struct1, $struct2],
            [$status, $color],
        ];
    }
}
